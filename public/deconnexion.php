<?php

session_start();
if(isset($_SESSION['id'])) {
    session_destroy();
    $_SESSION = array();
    header('Location: index.php');
} else {
    header('Location: connexion.php');
}
