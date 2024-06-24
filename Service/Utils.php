<?php

class Utils
{
    function __construct()
    {

    }

    public function ArrayKeyOnly($data)
    {
        $realdata = [];
        foreach ($data as $cle => $valeur) {
            if (is_string($cle)) {
                $realdata[$cle] = $valeur;
            }
        }

        return $realdata;
    }

    public function ArrayKeyOnly2D($data)
    {
        $realdata = [];
        foreach ($data as $array) {
            // Initialiser un nouveau tableau pour chaque array
            $newArray = [];

            // Filtrer uniquement les clés associatives pour cet array
            foreach ($array as $cle => $valeur) {
                if (is_string($cle)) {
                    $newArray[$cle] = $valeur;
                }
            }

            // Ajouter le nouvel array au tableau de résultats
            $realdata[] = $newArray;
        }
        return $realdata;
    }

    public function CreateOTP()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890@#!:/*ù$^¨£§';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        echo implode($pass);
        return hash('sha512',implode($pass)); //turn the array into a string

    }
    function generate_salt($length = 16) {
        return bin2hex(random_bytes($length));
    }

    // Fonction pour hasher le mot de passe avec un sel
    function hash_password($password, $salt) {
        $hashed_password = hash('sha256', $password . $salt);
        return $hashed_password;
    }
}
