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
	$idEntry = NULL;
	$time = NULL;
	$case = NULL;
	$tries = NULL;
	$date = date_create();
	$code = NULL;

	if (isset($_POST['identry']))
	{
		$idEntry = $_POST['identry'];
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

	if (isset($_POST['codice']))
	{
		$code = $_POST['codice'];
	}

	echo '<body style="background-image: url(https://i.imgur.com/RJobLv7.png);
	background-repeat: repeat;
	background-attachment: fixed">';


function convertTime($decimale, $data)
{
    // Take the seconds
    $secondi = floor($decimale);
    // Calculate the minutes from the seconds
    $minuti = floor($secondi / 60);
    // Take the minutes from the seconds
    $secondi -= $minuti * 60;
    // Calculate the hours from the minutes
    $ore = floor($minuti / 60);
    // Take the hours from the minutes
    $minuti -= $ore * 60;
    // Calculate the days from the hours
    $giorni = floor($ore / 24);
    // Take the days from the hours
    $ore -= $giorni * 24;
    // Create Datetime from the moment the Blackout happened
    date_sub($data, date_interval_create_from_date_string(floor($decimale) . " seconds"));
    // Format the Datetime
    $timeString = $secString = $minString = $hrString = $dayString = "";
    // Set the temporal strings
    $secString = $secondi . (($secondi == 1) ? " second" : " seconds");
    $minString = $minuti . (($minuti == 1) ? " minute" : " minutes");
    $hrString = $ore . (($ore == 1) ? " hour" : " hours");
    $dayString = $giorni . (($giorni == 1) ? " day" : " days");
    if ($giorni > 0)
        $timeString = $dayString . ", " . $hrString . ", " . $minString . ", " . $secString;
    else
    {
        if ($ore > 0)
            $timeString = $hrString . ", " . $minString . ", " . $secString;
        else
        {
            if ($minuti > 0)
                $timeString = $minString . ", " . $secString;
            else
                $timeString = $secString;
        }
    }
    return $timeString;
}

	if ($time != NULL)
	{
		$format_time = convertTime($time, $date);
		$time = $format_time;
	}
	$format_date = date_format($date, 'Y-m-d H:i:s');
	$date = $format_date;

	echo '<form action="http://localhost:8080/blackoutchecker/codelist" method="POST" id="myForm">
	<div style="display:none">
    <input name="identry" type="hidden" value="' . $idEntry . '">
    <input name="time" type="hidden" value="' . $time . '">
	<input name="case" type="hidden" value="' . $case . '">
	<input name="tries" type="hidden" value="' . $tries . '">
	<input name="date" type="hidden" value="' . $date . '">
	<input name="code" type="hidden" value="' . $code . '">
    <input type="submit" value="submit">
	</div>
	</form>';

	echo '<script type="text/javascript">
		document.getElementById("myForm").submit();
	</script>';
?>
</body>

</html>
