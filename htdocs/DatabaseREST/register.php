<?php

@session_start();


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

function msg($success,$status,$message,$extra = []){
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ],$extra);
}

require 'C:\xampp\htdocs\DatabaseREST\config\database.php';
$db_connection = new Database();
$conn = $db_connection->getConnection();

$data = file_get_contents("php://input");
print_r($data);
$entry = explode("&", trim($data));
$name_entry = explode("=", trim($entry[0]));
$sur_entry = explode("=", trim($entry[1]));
$gender_entry = explode("=", trim($entry[2]));
$user_entry = explode("=", trim($entry[3]));
$pass_entry = explode("=", trim($entry[4]));
$code_entry = explode("=", trim($entry[5]));

$name = $name_entry[1];
$sur = $sur_entry[1];
$gender = $gender_entry[1];
$user = $user_entry[1];
$pass = $pass_entry[1];
$code = $code_entry[1];

function constructData($name, $sur, $user, $pass, $code, $gender)
{
	$json_string = "{ \"nome\" : \"" .$name."\", \"cognome\" : \"" .$sur."\", \"username\" : \"" .$user."\", \"password\" : \"" .$pass."\", \"codice\" : \"" .$code."\", \"genere\" : \"" .$gender."\" }";
	$data = json_decode($json_string);

	return $data;
}

$returnData = [];

register(constructData($name, $sur, $user, $pass, $code, $gender), $conn);

function register($data, $conn)
{

if(strlen($data->codice) != 10)
{
	$_SESSION['alert'] = '-1';
	header("Location: http://localhost/registrati.php");
}

else if(!isset($data->nome) || !isset($data->cognome) || !isset($data->username) || !isset($data->password) || !isset($data->codice)
    || empty(trim($data->nome)) || empty(trim($data->cognome)) || empty(trim($data->username)) || empty(trim($data->password)) || empty(trim($data->codice)))
	{

    $fields = ['fields' => ['nome','cognome','username','password','codice']];
    $returnData = msg(0,422,'You must fill every field to proceed!',$fields);
	$_SESSION['alert'] = '0';
	header("Location: http://localhost/registrati.php");
	}

else if (preg_match("([<>&(),%'?+])", $data->nome) || preg_match('/"/', $data->nome) || preg_match("([<>&(),%'?+])", $data->cognome) || preg_match('/"/', $data->cognome) || preg_match("([<>&(),%'?+])", $data->username) || preg_match('/"/', $data->username) || preg_match("([<>&(),%'?+])", $data->password) || preg_match('/"/', $data->password))
{
	$returnData = msg(0,422,'You can not use special characters!');
	$_SESSION['alert'] = '1';
	header("Location: http://localhost/registrati.php");
}

else
{
	$name = trim($data->nome);
	$surname = trim($data->cognome);
	$gender = trim($data->genere);
    $username = trim($data->username);
    $password = trim($data->password);
    $codice = trim($data->codice);

    if(strlen($password) < 8)
	{
        $returnData = msg(0,422,'Input password must be at least 8 characters long!');
		$_SESSION['alert'] = '2';
		header("Location: http://localhost/registrati.php");
    }

	else if ($gender != "F" && $gender != "M" && $gender != " " && $gender != "N")
	{
		print_r($gender);
		$returnData = msg(0,422,'Invalid gender input.');
		$_SESSION['alert'] = '6';
		//header("Location: http://localhost/registrati.php");
	}

	else if(strlen($username) < 3)
	{
        $returnData = msg(0,422,'Input username must be at least 3 characters long!');
		$_SESSION['alert'] = '3';
		header("Location: http://localhost/registrati.php");
	}
    else
	{
        try
		{

            $check_username = "SELECT `username` FROM `users` WHERE `username`=:Username";
            $check_username_stmt = $conn->prepare($check_username);
            $check_username_stmt->bindValue(':Username', $username,PDO::PARAM_STR);
            $check_username_stmt->execute();

            if($check_username_stmt->rowCount())
			{
                $returnData = msg(0,422, 'Input username is already in use.');
				$_SESSION['alert'] = '4';
				header("Location: http://localhost/registrati.php");
            }

			$check_code = "SELECT `codice` FROM `users` WHERE `codice`=:Codice";
            $check_code_stmt = $conn->prepare($check_code);
            $check_code_stmt->bindValue(':Codice', $code,PDO::PARAM_STR);
            $check_code_stmt->execute();

            if($check_code_stmt->rowCount())
			{
                $returnData = msg(0,422, 'Input device ID is already registered.');
				$_SESSION['alert'] = '7';
				header("Location: http://localhost/registrati.php");
            }

            else
			{
                $insert_query = "INSERT INTO `users`(`nome`,`cognome`,`username`,`password`,`codice`, `genere`) VALUES(:nome,:cognome,:username,:password,:codice,:genere)";

                $insert_stmt = $conn->prepare($insert_query);

                // DATA BINDING
				$insert_stmt->bindValue(':nome', htmlspecialchars(strip_tags($name)),PDO::PARAM_STR);
				$insert_stmt->bindValue(':cognome', htmlspecialchars(strip_tags($surname)),PDO::PARAM_STR);
				$insert_stmt->bindValue(':genere', htmlspecialchars(strip_tags($gender)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':username', htmlspecialchars(strip_tags($username)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT),PDO::PARAM_STR);
				$insert_stmt->bindValue(':codice', htmlspecialchars(strip_tags($codice)),PDO::PARAM_STR);

                $insert_stmt->execute();

                $returnData = msg(1,201,'Successfully signed up.');
				$_SESSION['alert'] = '5';
				header("Location: http://localhost/blackoutchecker.php");

            }

        }
        catch(PDOException $e)
		{
            $returnData = msg(0,500,$e->getMessage());
		}

	}
}

return $returnData;
}
