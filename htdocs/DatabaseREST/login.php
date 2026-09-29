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
require 'C:\xampp\htdocs\DatabaseREST\jwthandler\JwtHandler.php';

$db_connection = new Database();
$conn = $db_connection->getConnection();
$data = json_decode(file_get_contents("php://input"));
$data = file_get_contents("php://input");

$entry = explode("&", trim($data));
$user_entry = explode("=", trim($entry[0]));
$pass_entry = explode("=", trim($entry[1]));

$user = $user_entry[1];
$pass = $pass_entry[1];

function constructData($user, $pass)
{
	$json_string = "{ \"username\" : \"" .$user."\", \"password\" : \"" .$pass."\" }";
	$data = json_decode($json_string);

	return $data;
}

$returnData = [];

login(constructData($user, $pass), $conn);

$_SESSION['alert'] = -2;

function login($data, $conn)
{
	if($_SERVER["REQUEST_METHOD"] != "POST"):
		if(isset($_SERVER["REQUEST_METHOD"]))
		$returnData = msg(0,404,'Page Not Found!');
		$_SESSION['alert'] = '-1';
		@header("Location: http://localhost/accedi.php");

elseif(!isset($data->username)
	|| !isset($data->password)
	|| empty(trim($data->username))
    || empty(trim($data->password))):

    $fields = ['fields' => ['username','password']];
    $returnData = msg(0,422,'You must fill every field to proceed!',$fields);
	$_SESSION['alert'] = '0';
	header("Location: http://localhost/accedi.php");

else:
    $username = trim($data->username);
    $password = trim($data->password);

    if(strlen($password) < 8):
        $returnData = msg(0,422,'Input password must be at least 8 characters long!');
		$_SESSION['alert'] = '1';
		header("Location: http://localhost/accedi.php");

    else:
        try{

            $fetch_user_by_username = "SELECT * FROM `users` WHERE `username`=:username";
            $query_stmt = $conn->prepare($fetch_user_by_username);
            $query_stmt->bindValue(':username', $username,PDO::PARAM_STR);
            $query_stmt->execute();

            if($query_stmt->rowCount()){
                $row = $query_stmt->fetch(PDO::FETCH_ASSOC);
                $check_password = password_verify($password, $row['password']);

                if($check_password)
				{

                    $jwt = new JwtHandler();
                    $token = $jwt->_jwt_encode_data(
                        'http://localhost/blackout checker',
                        array("user_id"=> $row['codice'])
                    );

                    $returnData = [
                        'success' => 1,
                        'message' => 'Successfully logged in.',
                        'token' => $token
                    ];

					$_SESSION['nome'] = $row['nome'];
					$_SESSION['genere'] = $row['genere'];
					$_SESSION['username'] = $username;
					$_SESSION['codice'] = $row['codice'];
						$_SESSION['token'] = $token;

					header("Location: http://localhost/blackoutchecker.php");

				}

                else{
                    $returnData = msg(0,422,'Input password is not correct.');
					$_SESSION['alert'] = '3';
					header("Location: http://localhost/accedi.php");
				}
			}
            else
			{
                $returnData = msg(0,422,'Invalid username!');
				$_SESSION['alert'] = '4';
				header("Location: http://localhost/accedi.php");
			}
        }
        catch(PDOException $e){
            $returnData = msg(0,500,$e->getMessage());
        }

    endif;

endif;

return $returnData;
}
?>
