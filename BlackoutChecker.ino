// Including libraries for handling the Esp32 display
#include <Wire.h>
#include "SSD1306Wire.h"
#include <OLEDDisplayFonts.h>

// Including libraries to handle Wi-Fi connection and to handle connection to the Web Server for adding data in tha database
#include <WiFi.h>
#include <HTTPClient.h>

// Costants for Esp32's LED PWM
#define TIMER_13_BIT         13
#define LEDC_BASE_FREQ       5000
#define BUZZER_BASE_FREQ     50

// Costants for the Channels that have to be assigned to the LEDs
#define BUZZER_CH          0
#define LEDB_CH            1

// Costants for numbered assigned PINs
#define pot                34
#define ledB               18
#define ledR               19
#define buzzer             25
#define buttonPin          23
#define lcd1               26  // SDA
#define lcd2               27  // SCL

// Create the Display
SSD1306Wire display(0x3c, 26, 27); // (26 SDA, 27 SCL)

// Connect to a Wi-Fi Router
const char* ssid     = "INSERT ROUTER SSID";        // Wi-Fi Router name
const char* password = "INSERT ROUTER PASSWORD";    // Wi-Fi Router password

// The idea here is that every 'Blackout Checker' device would have a unique ID so that it can be identified
const char* id = "hrvd_CS50x";

// Specific location of the Server REST API that handles HTTP POST requests (Change it by your use cases, needs to be the SPECIFIC PATH to the SPECIFIC FILE)
const char* serverName = "http://localhost/DatabaseREST/blackout/create.php";

/******************************************************************************************************************************************************************************************/
// SETUP

void setup()
{
  // Setting the Red LED (Digital)
  pinMode(ledR, OUTPUT);
  // Setting the Blue LED (Analog Custom)
  ledcSetup(LEDB_CH, LEDC_BASE_FREQ, TIMER_13_BIT);
  ledcAttachPin(ledB, LEDB_CH);
  // Setting the Buzzer as an Output (it will have to 'beep' when prompted to, at a variable frequency)
  ledcSetup(BUZZER_CH, BUZZER_BASE_FREQ, TIMER_13_BIT);
  ledcAttachPin(buzzer, BUZZER_CH);
  // Setting the Button as Input (INPUT_PULLUP has inverted logic: when resting, its value is HIGH, when in action it becomes LOW)
  pinMode(buttonPin, INPUT_PULLUP);

  // Setting the Display
  display.init();                               // Initialize the display
  display.clear();                              // Clean the display
  display.setFont(Arimo_Italic_13);
  display.flipScreenVertically();               // As it has been constructed, it needs to be flipped
  display.setTextAlignment(TEXT_ALIGN_LEFT);

  // randomSeed function to initialize the pseudo-random numbers generator
  // It's suggested to use the PIN 0 as when it is disconnected, it creates "noise" so that every time it is initialized, it has a different seed
  randomSeed(analogRead(0));

  // Using the Serial to check the Esp32's Wi-Fi connection
  Serial.begin(115200);
}

/******************************************************************************************************************************************************************************************/
// Useful and Main functions

// custom analogWrite()
void ledcAnalogWrite(uint8_t channel, uint32_t value, uint32_t valueMax = 255)
{
  // To calulcate the Duty, 8191 (aka 2 ^ 13 - 1, in general: 2^(Resolution bits) - 1)
  uint32_t duty = (8191 / valueMax) * min(value, valueMax);
  ledcWrite(channel, duty);
}

// Enum of the several states ("State Machine" approach)
enum state
{
  ON,
  OVERLOAD,
  FAILURE
};

// Variable that handles state selection (Initialized to 0, the first element of the enum state (ON))
int currentState = 0;
// Variable that stores the previous state (Overload or Power Failure) when the power is restored
int prevState;

void setDisplay(String str)
{
  // Clean the Display
  display.clear();
  display.drawStringMaxWidth(0, 0, 128, str);
  // (X, Y, max String size, String)
  display.display();
  // You need this so that it shows the string on the Display
}

unsigned long currentMillis;
unsigned long prevPot;          // Variable that stores the previous milli() counting in the potRead() function
bool powerRestored = true;      // Boolean needed to the potRead() function so that it doesn't immediately go alarm mode yet again after the power is restored
// Other potRead() variables
int inputValue;
int outputValue = 0;
bool errorMessage = false;

int nTries = 0;   // Variable to keep track of how many tries it took to restore the power

String wifiStatus;    // String that shows the status for connecting to the Web Server

bool isConnected = false;   // Boolean needed so that it doesn't try to connect to the Wi-Fi again once it's already connected

unsigned long autoRestore;

// Since this is supposed to handle power in a domestic environment, to simulate this I've hardcoded basically a potentiometer reader.
// It will read it until it reaches 0 value
void potRead()
{
  // Commented functions are debug only
  currentMillis = millis();
  if(currentMillis-prevPot>=500) // So that the loop can keep going, otherwise it will just be doing this all the time
  {
    prevPot = currentMillis;
    inputValue = analogRead(pot); // Read the potentiometer's value

    //Serial.print("Input: ");
    //Serial.println(inputValue);

    outputValue = map(inputValue, 0, 4095, 255, 0); // Converts the 0->4095 interval to the 255->0 interval

    //Serial.print("Output: ");
    //Serial.println(outputValue);

    //char buffer [3];
    //String outputString = itoa(outputValue, buffer, 10);

    ledcAnalogWrite(LEDB_CH, outputValue); // The Blue LED's intensity mirrors the value read by the Potentiometer, as far as simulations go I think this is acceptable

    if (isConnected == true)
    {
      wifiStatus = "Connected to Wi-Fi Network " + String(ssid);
    }
    else
    {
      wifiStatus = "No active Wi-Fi connection detected.";
    }

    if (errorMessage == false)
    {
      setSchermo("Device: Active. Current: Present. Intensity: " + String(outputValue) + ". " + wifiStatus);
    }
    else if (errorMessage == true)
    {
      showMessage();
    }
    // Once the power is back on after it went off, the value could still be 0, so I'll just make it wait until it becomes a different value and start reading again
    if(outputValue != 0)
    {
      powerRestored = false;
    }
  }
  // Check if power is missing
  if((outputValue == 0) && (powerRestored == false))
  {
    powerRestored = true;
    // The random() function assigns a pseudo-random value between the first parameter (optional and inclusive) and the second one (exclusive)
    currentState = random(1,3);   // In this case, random value between 1 and 2 (aka the OVERLOAD and FAILURE states of the enum)
    prevState = currentState;
    // A power failure means it will be back on on its own. Since we're simulating, I'm setting a random amount of time after which the power will automatically be back on
    if (currentState == FAILURE)
    {
      autoRestore = random(10000,20001);    // Values are in milliseconds. Second parameter is exclusive, so in this case, it's between 10 and 20 seconds
    }
    nTries = 0;
  }
}

bool doOnce = false;
int prevMsg;    // For counting the milliseconds in the showMessage() function

// Function that shows either the OVERLOAD or FAILURE messages to the Display
void showMessage()
{
  currentMillis = millis();
  if (doOnce == false)
  {
    prevMsg = currentMillis;
    doOnce = true;
  }
  if (prevState == OVERLOAD)
  {
    if(currentMillis-prevMsg>=3000)
    {
      setDisplay("WARNING - A power overload has occurred.");
    }
    else
    {
      setDisplay("Power has been successfully restored.");
    }
  }
  else if (prevState == FAILURE)
  {
    setDisplay("WARNING - A power failure has occurred.");
  }
  else
  {
    setDisplay("[DEBUG] - This is here just for safety, as it shouldn't never happen.");
  }
  if(currentMillis-prevMsg>=10000)
  {
    errorMessage = false;
    doOnce = false;
  }
}

// Variables for the doBuzzer() function
bool buzzerOn = false;
unsigned long prevMillis;

// Handles the beeping of the Buzzer
void doBuzzer(uint32_t freq, int buzzerTime)
{
  currentMillis = millis();
  if(currentMillis-prevMillis>=buzzerTime)
  {
    prevMillis = currentMillis;
    if (buzzerOn == true)
    {
      ledcAnalogWrite(BUZZER_CH, 0);
      buzzerOn = false;
    }
    else
    {
      ledcAnalogWrite(BUZZER_CH, freq);
      buzzerOn = true;
    }
  }
}

// Handles the reading of the Button
void buttonRead()
{
  // Variable that stores the Button's last state (the byte type requires less memory than an int)
  static byte lastState = HIGH;

  // Read Button input
  byte buttState = digitalRead(buttonPin);
  // Different beeps if button is pressed or if it isn't
  if (buttState == HIGH)
  {
    doBuzzer(255, 500);
  }
  else
  {
    doBuzzer(100, 500);
  }
  // If it changed
  if (buttState != lastState)
  {
    if (lastState == LOW)
    {
     // At every button pressing, 'beep' for 100 milliseconds
     ledcAnalogWrite(BUZZER_CH,255);
     delay(100);
     ledcAnalogWrite(BUZZER_CH,0);
     nTries++;
     waitRestore(3);

     buttState = 1;
    }
    // Store the last state
    lastState = buttState;
  }
}

// Variables for the alarm() function
bool setTimer = false;
unsigned long blackoutTime;

// Handles the simulation of a general power problem
void alarm()
{
  if (setTimer == false)
  {
    currentMillis = millis();
    blackoutTime = currentMillis;
    setTimer = true;
  }
  ledcAnalogWrite(LEDB_CH, 0); // Blue LED must be OFF
  digitalWrite(ledR, HIGH);
  setDisplay("WARNING - Power is detected missing!");
  buttonRead();
  if (currentState == FAILURE)
  {
    currentMillis = millis();
    if (currentMillis - blackoutTime >= autoRestore)
    {
      digitalWrite(ledR, LOW);
      ledcAnalogWrite(BUZZER_CH, 0);
      buzzerOn = false;
      errorMessage = true;
      currentState = ON;
      currentMillis = millis();
      blackoutTime = currentMillis - blackoutTime;
      setTimer = false;
      sendPost((blackoutTime/1000),"FAILURE",nTries,id);
    }
  }
}

// Function that handles setting the device's state
void setState()
{
  switch(currentState)
  {
    case ON:
      potRead();
      break;
    case OVERLOAD:
      alarm();
      break;
    case FAILURE:
      alarm();
      break;
    default:
      break;  // default case should never happen
  }
}

String occurence;
int prob;

void waitRestore(int seconds)
{
  digitalWrite(ledR, LOW);
  ledcAnalogWrite(BUZZER_CH, 0);
  buzzerOn = false;
  setDisplay("Trying to restore the power...");
  delay(seconds*1000);
  if (currentState == OVERLOAD)
  {
    errorMessage = true;
    currentState = ON;
  }
  else if (currentState == FAILURE)
  {
    prob = random(0,100);
    if (prob >= 60)
    {
      setDisplay("ERROR - Failed to restore the power. A power failure might have occurred.");
      delay(3000);
    }
    else
    {
      errorMessage = true;
      currentState = ON;
    }
  }
  if (errorMessage == true)
  {
    currentMillis = millis();
    blackoutTime = currentMillis - blackoutTime;
    if (prevState == OVERLOAD)
    {
      occurrence = "OVERLOAD";
    }
    else if (prevState == FAILURE)
    {
      occurrence = "FAILURE";
    }
    else
    {
      occurrence = "[NOT DEFINED]";
    }
    setTimer = false;
    sendPost((blackoutTime/1000),caso,nTries,id);
  }
}

// Variables for the doWifi() function
bool wifiOnce = false;
unsigned long wifiMillis;
unsigned long connectMillis;

// Function that handles the Wi-Fi connection
void doWifi()
{
  if (isConnected == false)
  {
    if (wifiOnce == false)
    {
      WiFi.begin(ssid, password);
      Serial.println("Connecting to the Wi-Fi Router...");
      wifiOnce = true;
    }
    if (WiFi.status() != WL_CONNECTED)
    {
      currentMillis = millis();
      if(currentMillis-wifiMillis>=500)
      {
        wifiMillis = currentMillis;
        Serial.print(".");
      }
    }
    else
    {
      Serial.println("");
      Serial.print("Connected to the Wi-Fi Network with Local IP Address: ");
      Serial.println(WiFi.localIP());
      isConnected = true;
    }
  }
  else
  {
    if (WiFi.status() != WL_CONNECTED)
    {
      Serial.println("Wi-Fi Connection lost. Trying to reconnect...");
      isConnected = false;
      wifiOnce  = false;
      WiFi.disconnect();
    }
  }
}

// Function that build the HTTP POST request in order to send it to the server REST API
void sendPost(unsigned long time, String occurrence, int tries, const char* id)
{
  if(WiFi.status()== WL_CONNECTED)
  {
    HTTPClient http;    // This is the object
    http.addHeader("Content-Type", "application/json");

    // Connect to the Server REST API
    http.begin(String(serverName));

    // Build the POST request body
    String body = "{\"codice\":\"" + String(id) + "\",\"tempo\":\"" + String(time) + "\",\"caso\":\"" + occurrence + "\",\"tentativi\":\"" + String(tries) + "\"}";

    // Send the request and receive a response number
    int httpResponseCode = http.POST(body);

    if (httpResponseCode>0)
    {
      //String payload = http.getString();
      Serial.print("Response HTTP Code: ");
      Serial.println(httpResponseCode);
      //Serial.print("Payload: ");
      //Serial.println(payload);
    }
    else
    {
      Serial.print("ERROR CODE: ");
      Serial.println(httpResponseCode);
    }
    // Free the resources
    http.end();
  }
  else
  {
    Serial.println("The device isn't connected to Wi-Fi. Unable to send request to the Server.");
  }
}

/******************************************************************************************************************************************************************************************/
// MAIN LOOP

void loop()
{
  doWifi();
  setState();
}
