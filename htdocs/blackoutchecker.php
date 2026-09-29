<?php

    @session_start();

	require 'C:\xampp\htdocs\DatabaseREST\config\database.php';

	if (empty($_SESSION['token']))
	{
		header("Location: http://localhost/accedi.php");
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

	if (isset($_SESSION['codice']))
	{
		$codiceDisp = $_SESSION['codice']; //takes it from ../DatabaseREST/login.php
	}

	if (isset($_SESSION['nome']))
	{
		$nome = $_SESSION['nome']; //takes it from ../DatabaseREST/login.php
	}

	if (isset($_SESSION['genere']))
	{
		$genere = $_SESSION['genere']; //takes it from ../DatabaseREST/login.php
	}

	echo '<body style="background-image: url(https://i.imgur.com/RJobLv7.png);
	background-repeat: repeat;
	background-attachment: fixed">';

function riempi_tabella($select = NULL, $bool = false, $code = NULL, $valid = false, $modify = false, $id = NULL, $date = NULL, $time = NULL, $case = NULL, $tries = NULL)
{
	//require __DIR__ . '../DatabaseREST/config/database.php';
	$db_connection = new Database();
	$conn = $db_connection->getConnection();

	if (isset($_SESSION['username']))
	{
		$username = $_SESSION['username'];
	}

	try{

            $fetch_user_by_username = "SELECT * FROM `users` WHERE `username`=:username";
            $query_stmt = $conn->prepare($fetch_user_by_username);
            $query_stmt->bindValue(':username', $username,PDO::PARAM_STR);
            $query_stmt->execute();

            if($query_stmt->rowCount())
			{
                $row = $query_stmt->fetch(PDO::FETCH_ASSOC);
                $codice = $row['codice'];

				//ADMIN ACTIONS
				if ($codice == "Arrq37X0s1")
				{
					$conditions = array();

					if ($modify == true)
					{
						$delete = true;
						if (!empty($date))
						{
							$conditions[] = "data = '$date'";
							$delete = false;
						}

						if (!empty($time))
						{
							$conditions[] = "tempo = '$time'";
							$delete = false;
						}

						if (!empty($case))
						{
							$conditions[] = "caso = '$case'";
							$delete = false;
						}

						if (!empty($tries))
						{
							$conditions[] = "tentativi = '$tries'";
							$delete = false;
						}

					$condition = implode (', ', $conditions);

					}

					if ($bool == true && $code != NULL)
					{
						$find_rows = "SELECT * FROM `blackouts` WHERE codice=:code ORDER BY `data` DESC";
					}

					else
						$find_rows = "SELECT * FROM `blackouts` ORDER BY `data` DESC";

					if ($modify == true)
					{
						//DELETE ENTRY
						if ($delete == true)
						{
							$deletion = "DELETE FROM blackouts WHERE id_entry = $id";
							$conn->query($deletion);
						}

						//EDIT ENTRY
						else
						{
							$update = "UPDATE blackouts ". "SET ". $condition ." WHERE id_entry = $id";
							$conn->query($update);
						}
					}
				}

				//USER LEVEL VISUALIZATION
				else
				{
					$find_rows = "SELECT * FROM `blackouts` WHERE codice=:Codice ORDER BY `data` DESC";
				}

				$query2_stmt = $conn->prepare($find_rows);

				if ($codice == "Arrq37X0s1")
				{
					if ((isset($code) && $code != ""))
					{
						$query2_stmt->bindValue(':code', $code, PDO::PARAM_STR);
					}
				}

				else
				{
					$query2_stmt->bindValue(':Codice', $codice, PDO::PARAM_STR);
				}

				$query2_stmt->execute();

				$i = 0;
				$n_rows = $query2_stmt->rowCount();

				if($query2_stmt->rowCount())
				{
					if (isset($select) && $select != 0 && $select <= $query2_stmt->rowCount())
					{
						$n_rows = $select;
					}

					while ($row2 = $query2_stmt->fetch(PDO::FETCH_ASSOC))
					{
						if ($codice == "Arrq37X0s1")
						{
							$tabella_identry = $row2['id_entry'];
							$tabella_codice = $row2['codice'];
						}

						$tabella_data = $row2['data'];
						$tabella_tempo = $row2['tempo'];
						$tabella_caso = $row2['caso'];
						$tabella_tentativi = $row2['tentativi'];

						$i++;

						echo '<tbody>
						<tr><td>';
						if ($codice == "Arrq37X0s1")
						{
							echo '<div id = "testitabella">'
							. $tabella_identry . '</div></td><td>
							<div id = "testitabella">'
							. $tabella_codice . '</div></td><td>';
						}

						echo '<div id = "testitabella">'
						. $tabella_data . '</div></td><td><div id = "testitabella">'
						. $tabella_tempo . '</div></td><td><div id = "testitabella">'
						. $tabella_caso . '</div></td><td><div id = "testitabella">'
						. $tabella_tentativi . '</div></td>
						</tr>
						</tbody>';

						if ($i >= $n_rows)
						{
							$valid = true;
							break;
						}
					}
				}

				else if ($codice == "Arrq37X0s1")
				{
					echo '<div class="alertblackout">
					WARNING! There are not any Blackout associated to this account or the unique ID is not registered yet!
					<br><a href="http://localhost/blackoutchecker.php"><p style = "color:white"><i>Click here to go back...</i></p></a>
					</div><br><br>';
					$code = NULL;
					$valid = false;
				}
			}
        }

        catch(PDOException $e)
		{
            $returnData = msg(0,500,$e->getMessage());
        }
}

	$select = NULL;
	$code = NULL;
	$bool = false;
	$id = NULL;
	$date = NULL;
	$time = NULL;
	$case = NULL;
	$tries = NULL;

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

	echo '<div id="testobottone">Input here how many table rows you want to visualize.<br>
	Inserting the number zero or a not valid number will make every row available to visualization.
	<br>They are ordered by most recent first.</div>';
	echo '<div align = "center"><form action="blackoutchecker.php" method="get">
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

	if ($codiceDisp == "Arrq37X0s1")
	{
		echo '<div id="testobottone">Input here the device unique ID in order to visualize its reported Blackouts.</div>';
		echo '<div align = "center"><form action="blackoutchecker.php" method="get">
		<input type="text" placeholder="ID" name="code">
		<input type="submit">
		</form></div>';

		if (isset($_GET['code']))
		{
			$code = $_GET['code'];

			$bool = true;

			echo '<div id="testobottone"><p style = "color:red">Input here the entry number of which fields you want to edit, <br>and then fill the fields you want to edit, or leave everything empty if you want to delete the entry.</p></div>';
			echo '<div align = "center"><form action="blackoutchecker.php" method="post">
			<input type="text" placeholder="Entry" name="identry" required>
			<br><input type="text" placeholder="Datatime" name="date">
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

	echo '<br><div class="wrapper">
	<table cellspacing="2" cellpadding="10" align="center">';
	echo '<thead>
			<tr>';
	if ($codiceDisp == "Arrq37X0s1")
	{
		echo '<th><div id="campitabella">ID Entry</div></th>
		<th><div id="campitabella">ID</div></th>';
	}

					echo '<th><div id="campitabella">Datetime</div></th>
					<th><div id="campitabella">Blackout Time</div></th>
					<th><div id="campitabella">Occurrence</div></th>
					<th><div id="campitabella"># Tries</div></th>
			</tr>
		</thead>';
	echo riempi_tabella($select, $bool, $code, $valid, $modify, $id, $date, $time, $case, $tries);
	echo '</table>
	</div>';



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
