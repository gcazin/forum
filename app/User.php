<?php

class User extends Database
{

    public static function sessionID()
    {
        if(isset($_SESSION['id'])) {
            return $_SESSION['id'];
        }
    }

    public static function sessionPseudo()
    {
        if(isset($_SESSION['pseudo']))
            return $_SESSION['pseudo'];
    }

    public static function getAttribut()
    {
        $bdd = parent::connect();
        $req = $bdd->query('SELECT * FROM user WHERE user_id = ' . self::sessionID());
        $result = $req->fetch();
        return $result;
    }

}
