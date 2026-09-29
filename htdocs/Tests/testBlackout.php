<?php

    session_start();

?>

<html>

<meta content="text/html; charset=UTF-8" http-equiv="content-type">
<html>
    <head>
        <title>[Test] Crea Blackout</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap">
        <link rel="stylesheet" href="/css/style.css">
	<style>

input[type=text] {
	width: 15%;
	height: 5%;

	border-collapse: collapse;
	border-radius: 10px 10px 10px 10px;
	border-style: hidden;

	opacity: 70%;

	font-style: oblique;

	text-align: center;

	transition: all 1s ease-in-out;
    -webkit-transition: all 1s ease-in-out; /** Chrome & Safari **/
    -moz-transition: all 1s ease-in-out; /** Firefox **/
    -o-transition: all 1s ease-in-out; /** Opera **/
}

input[type=text]:hover {
	opacity: 100%;

	background-color: black;

	color: #FFFFFF;

	border-collapse: collapse;
	border-radius: 10px 10px 10px 10px;
	border-style: hidden;
}

input[type=password] {
	width: 15%;
	height: 5%;
	margin-top: auto;
	margin-right: auto;
	border-collapse: collapse;
	border-radius: 10px 10px 10px 10px;
	border-style: hidden;

	opacity: 70%;

	font-style: oblique;

	text-align: center;

	transition: all 1s ease-in-out;
    -webkit-transition: all 1s ease-in-out; /** Chrome & Safari **/
    -moz-transition: all 1s ease-in-out; /** Firefox **/
    -o-transition: all 1s ease-in-out; /** Opera **/
}

input[type=password]:hover {
	opacity: 100%;

	background-color: black;

	color: #FFFFFF;

	border-collapse: collapse;
	border-radius: 10px 10px 10px 10px;
	border-style: hidden;

}

button[type=submit] {
	width: 10%;
	height: 7%;

	background-color: black;

	font-family: Arial, Helvetica, sans-serif;

	border-color: #FFFFFF;
	border-style: solid 1px;
}

#titolo {
	color: #FFFFFF;
	text-align: center;
	font-size: 60px;
	font-family: Georgia, serif;
	margin-top: 10%;
	margin-right: auto;
	height: 80px;
	letter-spacing: 3px;
	text-shadow: 0px 0px 10px #000000;
}


#testobottone {
	color: #FFFFFF;
	text-align: left;
	text-shadow: 0px 0px 4px #000000;
	font-weight: bold;
	font-size: 17px;
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
	margin-top: 0%;
	margin-left: 20%;

}

/* ALERT */
.alert {
  padding: 20px;
  background-image: radial-gradient(#f44336, #F52F20);
  color: white;
  margin: auto;
  width: 500px;
  height: 20px;
  opacity: 1;
  transition: opacity 0.6s;
  border: 2px outset;

  animation: shake 0.5s;

  text-shadow: 0px 0px 2px #000000;

  opacity: 100%;

	transition: all 1s ease-in-out;
    -webkit-transition: all 1s ease-in-out; /** Chrome & Safari **/
    -moz-transition: all 1s ease-in-out; /** Firefox **/
    -o-transition: all 1s ease-in-out; /** Opera **/
}

.closebtn {
  margin-left: 15px;
  color: white;
  float: right;
  font-size: 25px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;

  animation: shake 0.5s;
}

.alert:hover {
	opacity: 90%;
}

.closebtn:hover {
  color: black;
}

</style>
    </head>

<body>

	<?php
		if (isset($_SESSION['alert']))
		{
			$alert_msg = $_SESSION['alert'];
		}

		else
		{
			$alert_msg = -2;
		}

	?>

	<center><form method="POST" action="../Tests/blackout/create.php">
            <div id="titolo">Add New Blackout Entry</div><br>
			<?php
				echo '<div id="testobottone">Input here the data for the new Blackout entry.
			<br>Datetime for it will be automatically created and it will be the moment you will submit the fields.
			<br>ID = 10-characters long alphanumeric string that uniquely identifies the device.
			<br>Time = Amount of Blackout time in seconds. (<i>"INT"</i>).
			<br>Occurrence = <i>"OVERLOAD"</i> or <i>"FAILURE"</i>.
			<br>Tries = Integer number that represents the amount of times the device tried to restore the power.
			<br><p style = "color:red">The device ID must be connected to an user for it to work!</p> <a href="http://localhost/registrati.php"><p style = "color:red"><i>Click here to sign up.</i></p></a><br></div>';
			?>
            <input type="text" placeholder="ID" name="codice" required>
            <input type="text" placeholder="Time" name="tempo" required>
			<input type="text" placeholder="Occurrence" name="caso" required>
			<input type="text" placeholder="Tries" name="tentativi" required>
            <br><br><button type="submit"><p style="color: white">Create entry</p></button>
	</form></center>

    </body>

	<?php

		if ($alert_msg == 1)
		{
			echo '<div class="alert">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
				Device ID string must be exactly 10 characters long!
				</div>';
			unset($_SESSION['alert']);
		}

		if ($alert_msg == 2)
		{
			echo '<div class="alert">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
				Invalid occurrence. Try again.
				</div>';
			unset($_SESSION['alert']);
		}

		if ($alert_msg == 3)
		{
			echo '<div class="alert">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
				Number of tries must be an INT!
				</div>';
			unset($_SESSION['alert']);
		}

		if ($alert_msg == 4)
		{
			echo '<div class="alert">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
				Input time must be an INT!
				</div>';
			unset($_SESSION['alert']);
		}

		if ($alert_msg == 5)
		{
			echo '<div class="alert">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
				Can not create Blackout entry! Device ID string is invalid.
				</div>';
			unset($_SESSION['alert']);
		}

	?>

	<?php
	echo '<body style="background-image: url(https://i.imgur.com/RJobLv7.png);
	background-repeat: repeat;
	background-attachment: fixed">';
	?>

</html>
