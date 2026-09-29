<?php

	@session_start();

	//If logging out, throw away the cookie
	if (isset($_POST['logout']))
	{
		setcookie("cookie", " ", time() - 3600);
	}

	//If the cookie is set, stay connected
	if (isset($_COOKIE['cookie']))
	{
		header("Location: http://localhost/homepage.php");
	}

?>

<html>

<meta content="text/html; charset=UTF-8" http-equiv="content-type">
<html>
    <head>
        <title>Login</title>
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

/* MESSAGGIO DI ALERT */
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

		if (isset($_POST['alert_msg']))
		{
			$alert_msg = $_POST['alert_msg'];
		}

		else
		{
			$alert_msg = -2;
		}

	?>

	<center><form method="POST" action="http://localhost:8080/blackoutchecker/login">
            <div id="titolo">Login</div><br>
            <input type="text" placeholder="Username" name="username">
            <input type="password" placeholder="Password" name="password">
            <br><br><button type="submit" value="login"><p style="color: white">Login</p></button>
			<br><i><a href = "registrati.php"><u><p style = "color:white">Click here if you don't have an account.</p></u></a></i>
	</form></center>

    </body>

	<?php

		loginResult($alert_msg);

		function loginResult($alert_msg)
		{

		if ($alert_msg < -1)
		{

		}

		else if ($alert_msg == -1)
		{
			echo '<div class="alert">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
				ERROR 404! NOT FOUND!
				</div>';
			unset($_POST['alert_msg']);
		}

		else if ($alert_msg == 0)
		{
			echo '<div class="alert">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
				WARNING! You must fill every field to proceed!
				</div>';
			unset($_POST['alert_msg']);
		}

		else if ($alert_msg == 1)
		{
			echo '<div class="alert">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
				WARNING! Input password must be at least 8 characters long!
				</div>';
			unset($_POST['alert_msg']);
		}

		else if ($alert_msg == 2)
		{
			echo '<div class="alert">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
				Successfully logged in.
				</div>';
			unset($_POST['logout']);
			unset($_POST['alert_msg']);
		}

		else if ($alert_msg == 3)
		{
			echo '<div class="alert">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
				WARNING! Input password is not correct.
				</div>';
			unset($_POST['alert_msg']);
		}

		else if ($alert_msg == 4)
		{
			echo '<div class="alert">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
				WARNING! Input username is invalid.
				</div>';
			unset($_POST['alert_msg']);
		}

		else if ($alert_msg == 5)
		{
			echo '<div class="alert">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
				Signed up successfully. You can now login.
				</div>';
			unset($_POST['alert_msg']);
		}

		else if ($alert_msg == 6)
		{
			echo '<div class="alert">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
				WARNING! You can not use special characters.
				</div>';
			unset($_POST['alert_msg']);
		}

		return $alert_msg;
	}
	?>

	<?php
	echo '<body style="background-image: url(https://i.imgur.com/RJobLv7.png);
	background-repeat: repeat;
	background-attachment: fixed">';
	?>

</html>
