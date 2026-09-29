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
$dati = json_decode(file_get_contents("php://input"));

$utente->username = $dati->username;
$stmt;
if($utente->readUser($stmt))
{
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
                "Codice" => $codice,
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
            array("message" => "No reported user.")
            );
    }
}
else
{
    http_response_code(503);	//503 = Not Available
    echo json_encode(array("message" => "Can not get access to the service."));
}
?>
