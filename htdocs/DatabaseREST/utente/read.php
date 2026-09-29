<?php
//Funzione header() di PHP per specificare gli header HTTP della risposta.
//In particolare, queste due istruzioni si occupano di rendere accessibile la pagina
//read.php a qualsiasi dominio, e di restituire un contenuto di tipo JSON,
//codificato in UTF-8.
//header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
//Inclusione dei file .php del database e della tabella
include_once '../config/database.php';
include_once '../models/utente.php';

$database = new Database();
$db = $database->getConnection();
$utente = new Utente($db);

$stmt = $utente->read();
$num = $stmt->rowCount();
if($num > 0)
{
	$utenti_arr = array();
	$utenti_arr["elenco"] = array();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		extract($row);
		$utente_item = array(
		"Username" => $username,
		"Password" => $password,
		"Codice" => $codice
		);
		array_push($utenti_arr["elenco"], $utente_item);
	}
	http_response_code(200);
	echo json_encode($utenti_arr);
}
else
{
	http_response_code(404);
	echo json_encode(
		array("message" => "No user found.")
		);
}
?>
