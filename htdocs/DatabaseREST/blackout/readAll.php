<?php
include_once '../htdocs/DatabaseREST/config/database.php';
include_once '../htdocs/DatabaseREST/models/blackout.php';

$database = new Database();
$db = $database->getConnection();
$blackout = new Blackout($db);

$stmt = $blackout->readAll();
$num = $stmt->rowCount();
if($num > 0)
{
	$blackouts_arr = array();
	$blackouts_arr["elenco"] = array();
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
		array_push($blackouts_arr["elenco"], $blackout_item);
	}
	http_response_code(200);
	//echo json_encode($blackouts_arr);
}
else
{
	http_response_code(404);
	/*echo json_encode(
		array("message" => "No reported Blackout entry.")
		);*/
}
?>
