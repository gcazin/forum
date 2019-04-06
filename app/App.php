<?php

class App
{

    private static $titre = "forum";

    public static function getHead($titre)
    {
        self::$titre = $titre;
        require_once '../views/head.php';
    }

    public static function getMenu()
    {
        require_once '../views/menu.php';
    }

    public static function getFooter()
    {
        require_once '../views/footer.php';
    }

}
