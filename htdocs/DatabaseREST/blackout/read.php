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
	$blackout->codice = $dati->codice;

$stmt


if($blackout->read($stmt))
{
    $num = $stmt->rowCount();
    if($num > 0)
    {
	   $blackouts_arr = array();
	   //$blackouts_arr["elenco"] = array();
	   while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
	   {
		  extract($row);
		  $blackout_item = array(
		  "Codice" => $codice,
		  "Data" => $data,
		  "Tempo" => $tempo,
		  "Caso" => $caso,
		  "Tentativi" => $tentativi
		  );
		  array_push($blackouts_arr, $blackout_item);
	   }
		http_response_code(200);
		echo json_encode($blackouts_arr, true);
    }
    else
    {
	   http_response_code(404);
	   /*echo json_encode(
		  array("message" => "No reported Blackout entry.")
		  );*/
    }
}
else
{
    http_response_code(503);	//503 = Not Available
    //echo json_encode(array("message" => "Can not get access to the service."));
}
?>
