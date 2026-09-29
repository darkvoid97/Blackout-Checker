# Blackout Checker
#### Video Demo:  https://youtu.be/SJDplR7F4FY
#### Description:
Blackout Checker is a device that's been conceived for home safety. It is designed to detect any power out situations in a domestic environment, giving users a warning when a power failure or overload occurs, by providing an immediate alert through a red LED and a distinct beep. The device, besides trying to facilitate users in power restoring, also keeps track of blackouts activity thanks to its communication (via Wi-Fi connection) to a web server that handles the blackouts' data by inserting them into a secure database. Blackout Checker also offers an intuitive web application and interface, in which users can securely check for their blackout informations.

## Features
- **Blackout Tracking**: The device keeps monitoring for power failure/overload events.
- **User Registration and Authentication**: New users can register for an account and login to use the application, checking for stored blackouts information concerning their environment.
- **Facilitating Power Restoring**: The device will make it easier and safer for the user to get the power back on.
- **Facilitating Managing Data for Admins**: Application's admins can easily check and edit users' blackouts data without having to directly navigate into the database

## Getting Started
### Hardware Specifics (Prerequisites)
- An ESP32 microcontroller (with Wi-Fi capabilities)
- A breadboard
- 2 LEDs
- A potentiometer
- A passive buzzer
- An OLED Display 0.96" 128x64 Pixel I2C
- A button
- 5 resistors (10, 100, 220 Ω)

### Software Specifics (Prerequisites)
- Arduino IDE
- XAMPP (for Apache and MySQL) (https://www.apachefriends.org/it/download.html
)
- Java 1.8
- Apache Tomcat 9.0
- Apache TomEE 9 (https://www.apache.org/dyn/closer.cgi/tomee/tomee-9.0.0-M2/apache-tomee-9.0.0-M2-webprofile.zip)
- Eclipse IDE for Enterprise Java Developers (https://www.eclipse.org/downloads/packages/release/2020-09/r/eclipse-ide-enterprise-java-developers)

### Installing
#### Hardware
![Circuit design to make the ESP32 work on its intended purposes](https://od.lk/s/OTNfMzUyMDc2Mjdf/Hardware%20Design.png)

There's no better way to explain it: just install everything on the breadboard as shown in the image. (The image shows an Arduino UNO instead of an ESP32 because I couldn't find a decent enough pic of it while doing this design. Using the ESP32 is highly suggested. The circuit image should also be present in this project's folder, just in case you can't see it up here)

#### Software
1. Download all of this project's files.
2. Put the _"ESP8266_and_ESP32_OLED_driver_for_SSD1306_displays"_ folder into your _Documents/Arduino/libraries_ folder. If there isn't an _Arduino_ folder in your _Documents_, just open the Arduino IDE, or create the folders yourself.
3. Put the _BlackoutChecker.ino_ file into a folder with the same name and then open it with the Arduino IDE. (The Arduino IDE requires for each of its files to be into a folder with the same name as said file)
4. In the _BlackoutChecker.ino_ file, edit the "ssid" and "password" strings (at lines 32, 33) as needed for it to successfully connect to the Wi-Fi router. Then compile the code into the ESP32 (This obviously requires for the Hardware part to be installed already). Now the device should be operating as intended.
5. Now it's time to install the web server. Open the XAMPP Control Panel and start the "Apache" and "MySQL" services.
6. Go to the XAMPP default folder (usually _YOUR MAIN DISK:\xampp_) and remove the default _htdocs_, then copypaste the project's _htdocs_ folder there. (Should also be fine if you just copypaste the _htdocs_ folder to the already existent one)
7. Open the Eclipse IDE for Enterprise Java Developers and select the project's folder _blackoutchecker-workspace_ as workspace when prompted to.
8. In the Eclipse IDE, click on the **Window** tab and then on **Preferences**. Find the **Servers** tab and click on the **little arrow icon** on its left. Then click on **Runtime Environment**, and then "**Add...**". Select your _Apache Tomcat 9_ folder (usually into the _Apache_ folder) then click on **Next**. Rename it into _Apache TomEE 9.0_ and as installation Tomcat folder, select the _apache-tomee-webprofile-9.0.0-M2_ one (It is highly suggested that the Java Runtime Environment is version 1.8). Now click on **Finish**.
9. If you didn't check for the "Create a locale server" during the previous step find the **Servers** tab in the lower side of the Eclipse IDE and create a new locale server. Select "Tomcat 9.0 Server" and leave the rest as is. Then click on **Finish**. Once done that, right-click on the just created server and then on **Properties**. Find "General" if the location appears as "[workspace metadata]", click on **Switch Location**, then on **Apply and Close**.
10. Double-click on the created server. The server Overview should be opened. From here, under **Server Locations**, select **Use Tomcat installation**. On the **Deploy path**, click on "**Browse...**" and select the _webapps_ folder into the _apache-tomee-webprofile-9.0.0-M2_ one. Then save the edits and close the Overview.
11. Now, external libraries are needed for the Java services to work. You'll find them in the project's _other\_libraries_ folder. In the Eclipse IDE, right-click on the workspace's project folder "blackoutchecker" and select **Build Path** then **Configure build path**. Click on **add external
jars** and select the aforementioned libraries (_junit-4.13.jar_ is not necessairly needed in this step as it's used for testing purposes, the other ones are mandatory). **WARNING**: The execution environment of the JRE Library System MUST be JavaSE-1.8
12. Now, right-click again on the workspace's project folder "blackoutchecker", then on **Run As...**, and then on **Run on Server**. Select the previously created server, then click on **Next**, make sure that the folder is appearing on the right-sided list and then click on **Finish**. At this point the TomEE server that handles the web services of the application should be correctly setup and started.
13. Now the Database installation remains. The web application, thanks to XAMPP in the previous steps, is hosted on the local machine, so it can be accessed by a web browser by going to the "localhost" address. Open the web browser and go to "http://localhost/phpmyadmin/". On the upper navbar of the webpage, select **Import**, then on **Choose file**. Select the project's file _blackoutchecker.sql_. Once it's done, a new "blackout checker" database with two tables "users" and "blackouts" should appear.
14. The entire web system is now ready to be used and tested. You can interface with the front-end by using the web browser and going to the "localhost" address.

## How to use
- **Registration and Login**: Register for a new account and log in.
- **Use the potentiometer**: Once the device is operating, you can change the "power intensity" it is detecting by using the potentiometer. Once it reaches 0 (aka the intensity LED is turned off), a blackout has occurred. The device will alert with you with another LED turned on and the beeping.
- **Try and restore the power**: You can press the button to try and restore the power. If it fails, you can also wait for it to be restored itself.
- **Check the webpage**: Log in into your account and check for details of the blackout events that have occurred.

## Admin credentials and Testing
There are hardcoded admin credentials (it's suggested to not delete the admin's entry in the database for this reason) in order to test the aforementioned admin features for the web application.

Username: **Admin**

Password: **Arrq37X0s1**

The project also has extra files for testing purposes. As it's not a primary feature, additional instructions into .txt files have been added inside the "_htdocs/Tests_" and "_blackoutchecker-workspace/blackoutchecker/src/tests_" folders.

## System Design
Both the Web Application and the ESP32 device communicate to the Database by sending requests to a REST API Web Service, developed in Java and working on Apache, thanks to Apache Tomcat v9.0. The aforementioned web service is in fact the **only** way to interface with the Database, as it's otherwise completely inaccessible from the outside (therefore, secure). Requests for the database are received from Jakarta Servlets, and then redirected by them to the Java Server Pages, which then extract the needed attributes in order to generate alerts to finally send to the user's client. Database itself is done with MySQL. The Web interface is developed in PHP, in order to easily make the HTML and CSS 'dynamic' for every user. The ESP32 microcontroller can be programmed using the Arduino IDE, with some extrenal help from specific libraries. This helps to ease the work if you're already familiar with the Arduino programming (which has the C language under the hood). The system has been designed prioritizing security, as it is in fact safe from several attacks such as SQL injection and similiar. The hardware part has instead been designed prioritizing simplicity, mostly since that part is mostly been executed in a more of simulated environment rather than a real world use case, but it's also designed just real enough that one can clearly see the possible real world applications of the entire technology.

## What is CS50x?
This is a project made for the final week of the CS50x course. CS50x is a openware course from Harvard University and taught by David J. Malan

Introduction to the intellectual enterprises of computer science and the art of programming. This course teaches students how to think algorithmically and solve problems efficiently. Topics include abstraction, algorithms, data structures, encapsulation, resource management, security, and software engineering. Languages include C, Python, SQL, HTML, CSS, JavaScript and also a little of Scratch.

This is the link: https://cs50.harvard.edu/x/

## Final words

Well, this has been my CS50x journey.

Ad maiora!
