<?php
require 'C:\xampp\htdocs\DatabaseREST\jwt\src\JWT.php';
require 'C:\xampp\htdocs\DatabaseREST\jwt\src\ExpiredException.php';
require 'C:\xampp\htdocs\DatabaseREST\jwt\src\SignatureInvalidException.php';
require 'C:\xampp\htdocs\DatabaseREST\jwt\src\BeforeValidException.php';

use \Firebase\JWT\JWT;

class JwtHandler {
    protected $jwt_secrect;
    protected $token;
	protected $auth_token;
    protected $issuedAt;
    protected $expire;
    protected $jwt;

    public function __construct()
    {
        // Timezone
        date_default_timezone_set('Europe/Rome');
        $this->issuedAt = time();

        // Token validation (3600 seconds = 1 hour)
        $this->expire = $this->issuedAt + 3600;

        $this->jwt_secrect = "90lrimgtsanc";
    }

    public function _jwt_encode_data($iss,$data){

        $this->token = array(
            "iss" => $iss,
            "aud" => $iss,
            "iat" => $this->issuedAt,
            "exp" => $this->expire,
            "data"=> $data
        );

        $this->jwt = JWT::encode($this->token, $this->jwt_secrect);
        return $this->jwt;

    }

    protected function _errMsg($msg){
        return [
            "auth" => 0,
            "message" => $msg
        ];
    }

    public function _jwt_decode_data($jwt_token){
        try{
            $decode = JWT::decode($jwt_token, $this->jwt_secrect, array('HS256'));
            return [
                "auth" => 1,
                "data" => $decode->data
            ];
        }
        catch(\Firebase\JWT\ExpiredException $e){
            return $this->_errMsg($e->getMessage());
        }
        catch(\Firebase\JWT\SignatureInvalidException $e){
            return $this->_errMsg($e->getMessage());
        }
        catch(\Firebase\JWT\BeforeValidException $e){
            return $this->_errMsg($e->getMessage());
        }
        catch(\DomainException $e){
            return $this->_errMsg($e->getMessage());
        }
        catch(\InvalidArgumentException $e){
            return $this->_errMsg($e->getMessage());
        }
        catch(\UnexpectedValueException $e){
            return $this->_errMsg($e->getMessage());
        }

    }
}
?>
