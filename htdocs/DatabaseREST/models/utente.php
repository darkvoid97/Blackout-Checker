<?php
class Utente
{
	private $conn;
	private $table_name = "utenti";

	public $username;
	public $password;
	public $codice;
	
	public function __construct($db)
	{
		$this->conn = $db;
	}

	//READ
	function read()
	{
		$query = "SELECT * FROM " . $this->table_name;
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	//READUSER
	function readUser(&$val)
	{
	    $query = "SELECT * FROM " . $this->table_name . " WHERE username=:Username";
	    $stmt = $this->conn->prepare($query);
	    $this->username = htmlspecialchars(strip_tags($this->username));
	    $stmt->bindParam(":Username", $this->username);
	    if ($stmt->execute()) {
	        $val = $stmt;
	        return true;
	    }
	    return false;
	}

	//CREATE
	function create()
	{
		$query = "INSERT INTO " . $this->table_name . " SET username=:Username, password=:Password, codice=:Codice";
		$stmt = $this->conn->prepare($query);
		$this->username = htmlspecialchars(strip_tags($this->username));
		$this->password = htmlspecialchars(strip_tags($this->password));
		$this->codice = htmlspecialchars(strip_tags($this->codice));
		$stmt->bindParam(":Username", $this->username);
		$stmt->bindParam(":Password", $this->password);
		$stmt->bindParam(":Codice", $this->codice);
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}

	//UPDATE
	function update()
	{
		$query = "UPDATE " . $this->table_name . " SET username=:Username, password=:Password WHERE codice=:Codice";
		$stmt = $this->conn->prepare($query);
		$this->username = htmlspecialchars(strip_tags($this->username));
		$this->password = htmlspecialchars(strip_tags($this->password));
		$this->codice = htmlspecialchars(strip_tags($this->codice));
		$stmt->bindParam(":Username", $this->username);
		$stmt->bindParam(":Password", $this->password);
		$stmt->bindParam(":Codice", $this->codice);
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}

	//DELETE
	function delete()
	{
		$query = "DELETE FROM " . $this->table_name . " WHERE codice = ?";
		$stmt = $this->conn->prepare($query);
		$this->codice = htmlspecialchars(strip_tags($this->codice));
		$stmt->bindParam(1, $this->codice);
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}
}
?>
