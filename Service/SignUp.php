<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/API/Service/Service.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/API/AuthHandler.php");
class SignUp extends Service
{

    function Trig()
    {
        $args = $this->GetArgs();
        $data = json_decode($args["data"],true);
        $authHandler = New AuthHandler();
        if (filter_var($data['mail'], FILTER_VALIDATE_EMAIL)){
            $ans = $authHandler->SignUp($data['mail'],$data['password']);
            echo "Votre mot de passe temporaire et a usage unique est : " ;
            echo $ans;
        } else{
            echo "Invalid format email";
        }
    }
    static function EndPoint() {
        new SignUp();
    }
}