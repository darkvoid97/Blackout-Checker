<?php

    @session_start();

			if (!isset($_COOKIE['cookie']) && $_POST['alert_msg'] != 2)
			{
				header("Location: http://localhost/accedi.php");
			}

			if (isset($_POST['alert_msg']) && $_POST['alert_msg'] == 2)
			{
				$headerCookies = explode('; ', getallheaders()['Cookie']);

				$cookies = array();

				foreach($headerCookies as $itm) {
					list($key, $val) = explode('=', $itm,2);
					$cookies[$key] = $val;
				}

				if (isset($_POST['username']))
				{
						setcookie('cookie', $_POST['username'], time() + 3600);
				}

			}

?>

<html>

<head>

<title>Blackout Checker</title>

<style>

/* TABLE */

.wrapper {
	overflow: auto;
	border: 2px solid white;
}

table {
	background-color: #000000;
	color: #FFFFFF;
	border-color: #CCCCCC;

	border-collapse: collapse;
	border-bottom-right-radius: 10px;
	border-bottom-left-radius: 10px;
	border-style: hidden;

	-moz-box-shadow: inset 0 0 2px 2px #FFFFFF;
	-webkit-box-shadow: inset 0 0 2px 2px #FFFFFF;
	box-shadow: inset 0 0 2px 2px #FFFFFF;


	width: 800px;

	margin-top: 2%;
	margin-left: auto;
	margin-bottom: 5%;

	opacity: 80%;

	-webkit-transition: all 0.6s ease-in-out;
	-moz-transition: all 0.6s ease-in-out;
	-o-transition: all 0.6s ease-in-out
}

table:hover {
	opacity: 1
}

th, td {
	padding: 10px;
	border: 1px solid #CCCCCC;
	border-style: dotted;
}

#testobottone {
	color: #FFFFFF;
	text-align: center;
	text-shadow: 0px 0px 4px #000000;
	font-weight: bold;
	font-size: 17px;
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
	margin-top: 2%;

}

#campitabella {
	color: #FFFFFF;
	text-align: center;
	font-weight: bold;
	font-size: 15px;
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
}

#testitabella {
	color: #FFFFFF;
	text-align: left;
	font-size: 15px;
	font-family: "Courier New", Courier, monospace;
}

/* CREDITS */
#corpocrediti {
	position: fixed;
	top: 65%;
	left: 0%;
	height: 180px;
	width: 200px;
	background-color: #000000;
	padding: 5px;
	border: 2px dashed #FFFFFF;
	border-left: none;
	border-radius: 0px 50px 50px 0px;
	opacity: 70%;

	transition: all 1s ease-in-out;
    -webkit-transition: all 1s ease-in-out; /** Chrome & Safari **/
    -moz-transition: all 1s ease-in-out; /** Firefox **/
    -o-transition: all 1s ease-in-out; /** Opera **/
}

#corpocrediti:hover {

	transform: translate(0,-50px);
    -webkit-transform: translate(0,-50px); /** Chrome & Safari **/
    -o-transform: translate(0,-50px); /** Opera **/
    -moz-transform: translate(0,-50px); /** Firefox **/
}

#testocredits {
	padding: 8px;
	color: #FFFFFF;
	text-align: justify;
	font-size: 11px;
	font-family: Tahoma, Geneva, sans-serif;
	text-shadow: 0px 0px 2px #000000;
	margin-top: 12px;
	margin-left: 10px;
	line-height: 14px;
	height: 80px
}

/* SIDEBAR */
.corposidebar {
	position: fixed;
	top: 0%;
	right: -19%;
	height: 100%;
	width: 18%;
	background-color: #000000;
	padding: 20px;

	border-left: 2px solid #FFFFFF;
	border-style: dashed;
	opacity: 80%;


    transition: all 2s ease-in-out;
    -webkit-transition: all 2s ease-in-out; /** Chrome & Safari **/
    -moz-transition: all 2s ease-in-out; /** Firefox **/
    -o-transition: all 2s ease-in-out; /** Opera **/
}

.corposidebar:hover {
    transform: translate(-209px,0); !important
    -webkit-transform: translate(-209px,0); /** Chrome & Safari **/
    -o-transform: translate(-209px,0); /** Opera **/
    -moz-transform: translate(-209px,0); /** Firefox **/
}

.corposidebar:hover ~ .freccetta {
	opacity: 0%;

	transition: all 1s ease-in-out;
    -webkit-transition: all 1s ease-in-out; /** Chrome & Safari **/
    -moz-transition: all 1s ease-in-out; /** Firefox **/
    -o-transition: all 1s ease-in-out; /** Opera **/
}

input[type=text] {
	width: 6%;
	margin-top: 2%;
	border-collapse: collapse;
	border-radius: 10px 10px 10px 10px;
	border-style: hidden;

	opacity: 70%;

	transition: all 1s ease-in-out;
    -webkit-transition: all 1s ease-in-out; /** Chrome & Safari **/
    -moz-transition: all 1s ease-in-out; /** Firefox **/
    -o-transition: all 1s ease-in-out; /** Opera **/
}

input[type=text]:hover {
	opacity: 100%;

	animation: shake 0.4s;

	border-collapse: collapse;
	border-radius: 0px 0px 0px 0px;
	border-style: hidden;

}

input[type=submit] {
	opacity: 70%;
}

#testosidebar {
	padding: 1px;
	color: #FFFFFF;
	text-align: justify;
	font-size: 11.7px;
	font-family: serif;
	margin-top: -19%;
	margin-left: 20px;
	margin-right: 2%;
	width: 185px;
}

#titolosidebar {
	color: #FFFFFF;
	text-align: left;
	font-size: 24px;
	font-family: Impact, Charcoal, sans-serif;
	margin-top: 1px;
	margin-left: 20px;
	height: 80px;
	letter-spacing: 3px;
}

riga {
  border-bottom: 1.5px solid white;
}

@keyframes shake {
  0% { transform: translate(1px, 1px) rotate(0deg); }
  10% { transform: translate(-1px, -2px) rotate(-1deg); }
  20% { transform: translate(-3px, 0px) rotate(1deg); }
  30% { transform: translate(3px, 2px) rotate(0deg); }
  40% { transform: translate(1px, -1px) rotate(1deg); }
  50% { transform: translate(-1px, 2px) rotate(-1deg); }
  60% { transform: translate(-3px, 1px) rotate(0deg); }
  70% { transform: translate(3px, 1px) rotate(-1deg); }
  80% { transform: translate(-1px, -1px) rotate(1deg); }
  90% { transform: translate(1px, 2px) rotate(0deg); }
  100% { transform: translate(1px, -2px) rotate(-1deg); }
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

.alertblackout {
  padding: 20px;
  background-image: radial-gradient(#f44336, #F52F20);
  color: white;
  margin: auto;
  width: 500px;
  height: 60px;
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

.alertblackout:hover {
	opacity: 90%;
}

.closebtn:hover {
  color: black;
}

#titolopagina {
	color: #FFFFFF;
	text-align: center;
	font-size: 60px;
	font-family: Georgia, serif;
	margin-top: 1%;
	height: 80px;
	letter-spacing: 3px;
	text-shadow: 0px 0px 10px #000000;
}

#messaggiobenvenuto {
	color: #FFFFFF;
	text-align: center;
	font-size: 30px;
	font-family: Georgia, serif;
	margin-top: 1%;
	height: 80px;
	letter-spacing: 2px;
	text-shadow: 0px 0px 10px #000000;
}

.freccetta {
	position: fixed;
	top: 1%;
	right: 4%;
	color: #FFFFFF;
	font-size: 60px;
	font-family: Georgia, serif;
	text-shadow: 0px 0px 10px #000000;
	transition: all 2s ease-in-out;
    -webkit-transition: all 2s ease-in-out;
    -moz-transition: all 2s ease-in-out;
    -o-transition: all 2s ease-in-out; /** Opera **/
}

</style>

</head>

<body>

<?php

	$valid = false;
	$modify = false;

	$select = NULL;

	if (isset($_POST['codice']))
	{
		$codiceDisp = $_POST['codice'];
			$_SESSION['codice'] = $codiceDisp;
	}

	else
	{
		$codiceDisp = $_SESSION['codice'];
	}

	if (isset($_POST['username']))
	{
		$username = $_POST['username'];
		$_SESSION['username'] = $username;
	}

	else
	{
		$username = $_SESSION['username'];
	}

	if (isset($_POST['password']))
	{
		$password = $_POST['password'];
		$_SESSION['password'] = $password;
	}

	else
	{
		$password = $_SESSION['password'];
	}


	if (isset($_POST['nome']))
	{
		$nome = $_POST['nome'];
			$_SESSION['nome'] = $nome;
	}

	else
	{
		$nome = $_SESSION['nome'];
	}

	if (isset($_POST['genere']))
	{
		$genere = $_POST['genere'];
			$_SESSION['genere'] = $genere;
	}

	else
	{
		$genere = $_SESSION['genere'];
	}

	if (isset($_POST['alert_msg']))
	{
		$alert_msg = $_POST['alert_msg'];
	}

	else
	{
		$alert_msg = -2;
	}

	echo '<body style="background-image: url(https://i.imgur.com/RJobLv7.png);
	background-repeat: repeat;
	background-attachment: fixed">';

function riempi_tabella($entries_fil = NULL, $select = NULL, $codiceDisp = NULL)
{
	$i = 0;
	$dim = 0;

	if($select != NULL && $select < sizeof($entries_fil) && $select != 0)
	{
		$dim = $select;
	}

	else
	{
		$dim = sizeof($entries_fil);
	}

	if($dim != 0)
	{
		do
		{
			echo '<tbody><tr>';
				if ($codiceDisp == "Arrq37X0s1")
				{
					echo '<td><div id = "testitabella">'
						. $entries_fil[$i]->id_entry . '</div></td><td><div id = "testitabella">'
						. $entries_fil[$i]->codice . '</div></td>';
				}
				echo '<td><div id = "testitabella">'
						. $entries_fil[$i]->data . '</div></td><td><div id = "testitabella">'
						. $entries_fil[$i]->tempo . '</div></td><td><div id = "testitabella">'
						. $entries_fil[$i]->caso . '</div></td><td><div id = "testitabella">'
						. $entries_fil[$i]->tentativi . '</div></td>
						</tr></tbody>';
			$i++;
		}while($i < $dim);
	}
}

	echo '<div id="titolopagina"><u>Blackout Checker</u></div><br>';
	//Handle gendered words for different languages (In english there's no difference)
	if ($genere == 'M' || $genere == 'N' || $genere == " ")
	{
		echo '<div id="messaggiobenvenuto">Welcome <i>' . $nome . '</i>!</div>';
	}
	else if ($genere == 'F')
	{
		echo '<div id="messaggiobenvenuto">Welcome <i>' . $nome . '</i>!</div>';
	}
	echo '<div align = "center"><form action="accedi.php" method="post">
		<input type="submit" value="Click here to logout" name="logout">
		</form></div>';

	alertMessage($alert_msg);

		function alertMessage($alert_msg)
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
				[CREATE BLACKOUT] WARNING: To create a Blackout you need to fill every field that is not "Entry".
				</div>';
			unset($_POST['alert_msg']);
		}

		else if ($alert_msg == 1)
		{
			echo '<div class="alert">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
				[CREATE BLACKOUT] WARNING: Input device ID is not registered.
				</div>';
			unset($_POST['alert_msg']);
		}

		else if ($alert_msg == 3)
		{
			echo '<div class="alert">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
				[CREATE BLACKOUT] Successfully created and inserted Blackout.
				<br>Update the table.
				</div>';
			unset($_POST['logout']);
			unset($_POST['alert_msg']);
		}

		else if ($alert_msg == 4)
		{
			echo '<div class="alert">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
				[CREATE BLACKOUT] Caught error while trying to insert a new Blackout.
				</div>';
			unset($_POST['alert_msg']);
		}

		else if ($alert_msg == 5)
		{
			echo '<div class="alert">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
				[EDIT BLACKOUT] WARNING: Input IDEntry does not exist.
				</div>';
			unset($_POST['alert_msg']);
		}

		else if ($alert_msg == 6)
		{
			echo '<div class="alert">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
				[EDIT BLACKOUT] Successfully deleted Blackout entry.
				<br>Update the table.
				</div>';
			unset($_POST['alert_msg']);
		}

		else if ($alert_msg == 7)
		{
			echo '<div class="alert">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
				[EDIT BLACKOUT] Successfully edited Blackout entry.
				<br>Update the table.
				</div>';
			unset($_POST['alert_msg']);
		}

		else if ($alert_msg == 8)
		{
			echo '<div class="alert">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
				[EDIT BLACKOUT] Caught error while trying to edit or delete the Blackout entry.
				</div>';
			unset($_POST['alert_msg']);
		}

		return $alert_msg;
	}

	echo '<div id="testobottone">Input here how many table rows you want to visualize.<br>
	Inserting the number zero or a not valid number will make every row available to visualization.
	<br>They are ordered by most recent first.</div>';
	echo '<div align = "center"><form action="http://localhost:8080/blackoutchecker/login" method="get">
		<input type="text" name="nrighe">
		<input type="submit">
		</form></div>';

		if (isset($_GET['nrighe']))
		{
			$select = $_GET['nrighe'];

			$Stringselect = (string) $select;
			if (is_numeric($select) == false || strpos ($Stringselect, '.') != false)
			{
				echo '<div class="alert">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
				WARNING! Input value is not valid!
				</div>';
				$select = NULL;
			}
		}

	$bool = false;

	echo '<br><div align = "center"><form action="http://localhost:8080/blackoutchecker/login" method="post">
		<input type="hidden" name="username" value="' . $username . '">
        <input type="hidden" name="password" value="' . $password . '">
		<input type="submit" value="Click here to update the table" name="reload">
		</form></div>';

	if ($codiceDisp == "Arrq37X0s1")
	{
		echo '<div id="testobottone">Input here the device unique ID in order to visualize its reported Blackouts.<br>
		Submitting an empty field will make it show every Blackout entry of every registered device IDs.</div>';
		//uso un get
		echo '<div align = "center"><form action="http://localhost:8080/blackoutchecker/codelist" method="get">
		<input type="text" placeholder="ID" name="code">
		<input type="submit">
		</form></div>';

		if (isset($_GET['code']))
		{
			$code = $_GET['code'];

			$bool = true;

			echo '<div id="testobottone"><p style = "color:red">Input here the entry number of which fields you want to edit, <br>and then fill the fields you want to edit, or leave everything empty if you want to delete the entry.
			<br>To create a new Blackout entry instead, leave the Entry field empty and fill every other ones.</p>
			<br>Datetime for it will be automatically created and it will be the moment you will submit the fields.
			<br>ID = 10-characters long alphanumeric string that uniquely identifies the device.
			<br>Time = Amount of Blackout time in seconds. (<i>"INT"</i>).
			<br>Occurrence = <i>"OVERLOAD"</i> or <i>"FAILURE"</i>.
			<br>Tries = Integer number that represents the amount of times the device tried to restore the power.</div>';
			echo '<div align = "center"><form action="createBlackout.php" method="post">
			<input type="text" placeholder="Entry" name="identry">
			<br><input type="text" placeholder="ID" name="codice">
			<input type="text" placeholder="Time" name="time">
			<input type="text" placeholder="Occurrence" name="case">
			<input type="text" placeholder="Tries" name="tries">
			<input type="submit">
			</form></div>';
		}

		if (isset($_POST['identry']))
		{
			$id = $_POST['identry'];
			$modify = true;
		}

		if (isset($_POST['date']))
		{
			$date = $_POST['date'];
		}

		if (isset($_POST['time']))
		{
			$time = $_POST['time'];
		}

		if (isset($_POST['case']))
		{
			$case = $_POST['case'];
		}

		if (isset($_POST['tries']))
		{
			$tries = $_POST['tries'];
		}
	}

	if (isset($_POST['blackouts']))
	{
		$blackouts = $_POST['blackouts'];
			$_SESSION['blackouts'] = $blackouts;
	}

	else
	{
		$blackouts = $_SESSION['blackouts'];
	}

	$entries = json_decode($blackouts);
	$entries_fil = NULL;

	if ($bool == true)
	{
		if ($code == "all")
		{
			$entries_fil = $entries;
		}
		else
		{
			$e = 0;
			$j = 0;
			$size = sizeof($entries);
			do
			{
				if ($entries[$e]->codice == $code)
				{
					$entries_fil[$j] = $entries[$e];
					$j++;
				}
				$e++;
			}
			while ($e < $size);
		}
	}
	else
	{
		$entries_fil = $entries;
	}

	echo '<br><div class="wrapper">
	<table cellspacing="2" cellpadding="10" align="center">';
	echo '<thead>
			<tr>';
	if ($codiceDisp == "Arrq37X0s1")
	{
		echo '<th><div id="campitabella">ID Entry</div></th>
		<th><div id="campitabella">ID Device</div></th>';
	}

					echo '<th><div id="campitabella">Datetime</div></th>
					<th><div id="campitabella">Blackout Time</div></th>
					<th><div id="campitabella">Occurrence</div></th>
					<th><div id="campitabella"># Tries</div></th>
			</tr>
		</thead>';
	echo riempi_tabella($entries_fil, $select, $codiceDisp);
	echo '</table>
	</div>';

	//print_r($blackouts);


	//***CREDITI***
	echo '<div id="corpocrediti">
			<div id="testocredits"><div align="left">Project created for the final week of the Harvard CS50x course.
			<br>Entirely built by <b><i>Giuseppe Tansella</i></b>.
			<br>In the Sidebar you will find more details on the project.</div></div>
			</div>
			</div>';

	//***SIDEBAR***
	echo '<div class="corposidebar">
			<div id="titolosidebar"><riga>The Project</div>
			<div id="testosidebar"><br>I have used a Microcontroller (ESP-32) in order to easily monitor and restore power, in a domestic environment, in the case of a general Blackout.
			<br>Given the nature of this project, I had to simulate the power part of all of this.
			<br>The device is tasked with alerting for the eventual power failure, and to notify the user as soon as possible (by using a red LED, a Buzzer and a little LCD Display). There also is a button, which gives the chance of trying to restore the power. We can identify two different cases of missing power:
			<br><b>• Overload</b>: If the user is at home, they will have the chance to restore the power, which will be successfully brought back.
			<br><b>• Power Failure</b>: Same as above at first, but the power might not come back when trying to restore it. Besides, the power could also eventually turn back on by itself after a certain amount of time has passed.
			<br>After this, the power return will be simulated, and the data about the Blackout the device will have collected, aka [Date, Time, Blackout total time, Occurrence (Overload or Failure), Number of times it tried to restore the power], will be sent to a Database, in order to be able to be visualized on this Web page.<br>
			</div>
			</div>
			<div class="freccetta">↳</div>';
?>

</body>

</html>
