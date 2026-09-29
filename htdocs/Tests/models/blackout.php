<?php
class Blackout
{
	private $conn;
	private $table_name = "blackouts";

	public $codice;
	public $data;
	public $tempo;
	public $caso;
	public $tentativi;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	//READALL
	function readAll()
	{
		$query = "SELECT * FROM " . $this->table_name;
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	//READ
	function read(&$val)
	{
	    $query = "SELECT * FROM " . $this->table_name . " WHERE codice=:Codice";
	    $stmt = $this->conn->prepare($query);
	    $this->codice = htmlspecialchars(strip_tags($this->codice));
	    $stmt->bindParam(":Codice", $this->codice);
	    if ($stmt->execute()) {
	        $val = $stmt;
	        return true;
	    }
	    return false;
	}

	//CREATE
	function create()
	{
		/*$format_data = date_create();
		$format_tempo = $this->tempo;
		$format_tempo = convertTime($format_tempo, $format_data);
		$this->tempo = $format_tempo;
		$format_data = date_format($format_data, 'Y-m-d H:i:s');
		$this->data = $format_data;*/

		$query = "INSERT INTO " . $this->table_name . " SET codice=:Codice, data=:Data, tempo=:Tempo, caso=:Caso, tentativi=:Tentativi";

		$stmt = $this->conn->prepare($query);
		$this->codice = htmlspecialchars(strip_tags($this->codice));
		$this->data = htmlspecialchars(strip_tags($this->data));
		$this->tempo = htmlspecialchars(strip_tags($this->tempo));
		$this->caso = htmlspecialchars(strip_tags($this->caso));
		$this->tentativi = htmlspecialchars(strip_tags($this->tentativi));
		$stmt->bindParam(":Codice", $this->codice);
		$stmt->bindParam(":Data", $this->data);
		$stmt->bindParam(":Tempo", $this->tempo);
		$stmt->bindParam(":Caso", $this->caso);
		$stmt->bindParam(":Tentativi", $this->tentativi);
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}

	//UPDATE
	function update()
	{
		$query = "UPDATE " . $this->table_name . " SET codice=:Codice, tempo=:Tempo, caso=:Caso, tentativi=:Tentativi WHERE data=:Data";
		$stmt = $this->conn->prepare($query);
		$this->codice = htmlspecialchars(strip_tags($this->codice));
		$this->data = htmlspecialchars(strip_tags($this->data));
		$this->tempo = htmlspecialchars(strip_tags($this->tempo));
		$this->caso = htmlspecialchars(strip_tags($this->caso));
		$this->tentativi = htmlspecialchars(strip_tags($this->tentativi));
		$stmt->bindParam(":Codice", $this->codice);
		$stmt->bindParam(":Data", $this->data);
		$stmt->bindParam(":Tempo", $this->tempo);
		$stmt->bindParam(":Caso", $this->caso);
		$stmt->bindParam(":Tentativi", $this->tentativi);
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}

	//DELETE
	function delete()
	{
		$query = "DELETE FROM " . $this->table_name . " WHERE data = ?";
		$stmt = $this->conn->prepare($query);
		$this->data = htmlspecialchars(strip_tags($this->data));
		$stmt->bindParam(1, $this->data);
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}
}

function convertTime($decimale, $data)
{
    $secondi = floor($decimale);
    $minuti = floor($secondi / 60);
    $secondi -= $minuti * 60;
    $ore = floor($minuti / 60);
    $minuti -= $ore * 60;
    $giorni = floor($ore / 24);
    $ore -= $giorni * 24;
    date_sub($data, date_interval_create_from_date_string(floor($decimale) . " seconds"));
    $timeString = $secString = $minString = $hrString = $dayString = "";
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
?>
