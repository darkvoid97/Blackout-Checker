<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/utente.php';

$database = new Database();
$db = $database->getConnection();
$utente = new Utente($db);
$data = json_decode(file_get_contents("php://input"));
if(!empty($data->codice) && !empty($data->username) && !empty($data->password))
{
	$utente->username = $data->username;
	$utente->password = $data->password;
	$utente->codice = $data->codice;
	if($utente->create())
	{
		http_response_code(201);
		echo json_encode(array("message" => "Successfully created user entry."));
	}
	else
	{
		http_response_code(503);	//503 = Not Available
		echo json_encode(array("message" => "Can not create user entry."));
	}
}
else
{
	http_response_code(400);	//400 = Bad Request
	echo json_encode(array("message" => "Can not create user entry, input data is not complete."));
}
?>
