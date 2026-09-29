<?php

@session_start();
@include 'C:\xampp\htdocs\DatabaseREST\register.php';

use PHPUnit\Framework\TestCase;

final class RegisterTest extends TestCase{

	public function testInput()
	{
		_print("Username: ");
		$input = fopen("php://stdin", "r");
		$username = trim(fgets($input));
		_print("Password: ");
		$input = fopen("php://stdin", "r");
		$password = trim(fgets($input));
		_print("Codice: ");
		$input = fopen("php://stdin", "r");
		$codice = trim(fgets($input));

		$url = 'http://localhost/registrati.php';
		$data = array('username' => $username, 'password' => $password, 'codice' => $codice);

		$options = array(
			'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data)
			)
		);

		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
			$result = constructData($username, $password, $codice);
			$this->assertTrue(!(empty($result)));

		_print ("\n\nInput data is sent via POST request to the registrati.php page, which will redirect to the register.php page, which communicates to the REST API.");
		_print ("\nSuccessful return of the test means the data is correctly acquired.");

		return $result;
	}

	/**
	* @depends testInput
	*/
	public function testCorrectInput($result)
	{
		$db_connection = new Database();
		$conn = $db_connection->getConnection();
			$_SERVER["REQUEST_METHOD"] = "POST";

			$alert = @register($result, $conn);
			_print("\n\n");
			_print($alert['message']);
			_print("\n");

				$this->assertTrue($alert['success'] == 1);

		_print ("\nAcquired user data from the first test case have been sent.");
		_print ("\nSuccessful return of the test means the input credentials are valid and the user has successfully signed up.");
	}
}

	function _print($whatever = 'I am printed!')
	{
		if (ob_get_level() == 0) {
			$hasBuffer = false;
			ob_start();
		} else {
			$hasBuffer = true;
		}

		echo $whatever;

		ob_flush();
		flush();
		ob_end_flush();

		if ($hasBuffer) {
			ob_start();
		}
	}
?>
