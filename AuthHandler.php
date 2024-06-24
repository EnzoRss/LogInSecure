<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/API/Connexion.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/API/Service/Utils.php");

class AuthHandler
{
    public $Connexion;
    public $Utils;

    function __construct()
    {
        $this->Connexion = new  Connexion("login");
        $this->Utils = new Utils();
    }

    function SignUp($mail, $passwd, $confirm = null)
    {
        $acces = $this->Connexion->dbh;


        // Vérifier si l'utilisateur existe déjà
        $sql_check_user = $acces->prepare("SELECT COUNT(*) FROM `user` WHERE user.email = :mail ");
        $sql_check_user->execute(array(":mail" => $mail));
        $res = $sql_check_user->fetch();
        $ans = $res[0];
        if ($confirm == null) {
            if ($ans == 0) {

                // Générer OTP et date de validité
                $otp = $this->Utils->CreateOTP();
                $date = new DateTime();
                $date->modify('+10 minutes');
                $date_str = $date->format('Y-m-d H:i:s');

                // Insérer l'utilisateur dans `user`
                $sql_insert_user = $acces->prepare("INSERT INTO `user`(`email`) VALUES (:mail)");
                $sql_insert_user->execute(array(":mail" => $mail));

                // Insérer l'OTP dans `accountotp`
                $sql_insert_otp = $acces->prepare("INSERT INTO `accountotp`(`OTP`, `Validity`) VALUES (:otp, :date)");
                $sql_insert_otp->execute(array(":otp" => $otp, ":date" => $date_str));
                return $otp; // Retourner l'OTP généré


            } else {
                return 0; // Retourner 0 si l'utilisateur existe déjà
            }
        } else {
            $sql = $acces->prepare("SELECT guid FROM `user` WHERE user.email = :mail ");

            $salt = $this->Utils->generate_salt();
            $password = $this->Utils->hash_password($passwd, $salt);

            $sql_insert_account = $acces->prepare("INSERT INTO `account`(`guid`, `pwd`, `salt`) VALUES (:guid, :password, :salt)");
            $sql_insert_account->execute(array(":guid" => $password, ":password" => $password, ":salt" => $salt));
        }
    }
}