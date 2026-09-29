<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../htdocs/DatabaseREST/config/database.php';
include_once '../htdocs/DatabaseREST/models/blackout.php';

$database = new Database();
$db = $database->getConnection();
$blackout = new Blackout($db);
$dati = json_decode(file_get_contents("php://input"));

if (isset($dati))
{
	$blackout->codice = $dati->codice;
	$blackout->data = $dati->data;
	$blackout->tempo = $dati->tempo;
	$blackout->caso = $dati->caso;
	$blackout->tentativi = $dati->tentativi;
}

if($blackout->update())
{
	http_response_code(200);
	//echo json_encode(array("message" => "Successfully updated Blackout entry."));
}
else
{
	http_response_code(503);	//503 = Not Available
	//echo json_encode(array("message" => "Can not update Blackout entry."));
}
?>
