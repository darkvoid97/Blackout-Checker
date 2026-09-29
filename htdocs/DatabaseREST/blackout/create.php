<?php

@session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'C:/xampp/htdocs/DatabaseREST/config/database.php';
require 'C:/xampp/htdocs/DatabaseREST/models/blackout.php';

$database = new Database();
$db = $database->getConnection();
$blackout = new Blackout($db);
$dati = file_get_contents("php://input");

	$entry = explode("&", trim($dati));

	$codice_entry = explode("=", trim($entry[0]));
	$tempo_entry = explode("=", trim($entry[1]));
	$caso_entry = explode("=", trim($entry[2]));
	$tentativi_entry = explode("=", trim($entry[3]));

	if (strlen($codice_entry[1]) != 10)
	{
		$_SESSION['alert'] = '1';
			header("Location: http://localhost/testBlackout.php");
			exit();
	}

	if ($caso_entry[1] != "FAILURE")
	{
		if ($caso_entry[1] != "OVERLOAD")
		{
			$_SESSION['alert'] = '2';
				header("Location: http://localhost/testBlackout.php");
				exit();
		}
	}

	if (!(is_numeric($tentativi_entry[1])))
	{
		$_SESSION['alert'] = '3';
			header("Location: http://localhost/testBlackout.php");
			exit();
	}

	if (!(is_numeric($tempo_entry[1])))
	{
		$_SESSION['alert'] = '4';
			header("Location: http://localhost/testBlackout.php");
			exit();
	}

	$json_string = "{ \"codice\" : \"" .$codice_entry[1]."\", \"tempo\" : \"" .$tempo_entry[1]."\",  \"caso\" : \"" .$caso_entry[1]."\", \"tentativi\" : \"" .$tentativi_entry[1]."\"}";
	$dati = json_decode($json_string);


if(!empty($dati->codice) && !empty($dati->tempo) && !empty($dati->caso) && !empty($dati->tentativi))
{
	$blackout->codice = trim($dati->codice);
	$blackout->tempo = trim($dati->tempo);
	$blackout->caso = trim($dati->caso);
	$blackout->tentativi = trim($dati->tentativi);

	$format_data = date_create();
	$format_tempo = $blackout->tempo;
	$format_tempo = convertTime($format_tempo, $format_data);
	$blackout->tempo = $format_tempo;
	$format_data = date_format($format_data, 'Y-m-d H:i:s');
	$blackout->data = $format_data;

	if($blackout->create())
	{
		header("Location: http://localhost/blackoutchecker.php");
		exit();
			http_response_code(201);
	}

	else
	{
		http_response_code(503);	//503 = Not Available
			echo json_encode(array("message" => "Can not insert Blackout entry."));
	}
}
else
{
	http_response_code(400);	//400 = Bad Request
		echo json_encode(array("message" => "Can not insert Blackout entry, input data is not complete."));
}

?>
