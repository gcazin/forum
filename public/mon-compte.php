<?php

session_start();
if(!isset($_SESSION['id'])) {
    header('Location: connexion.php');
}

require '../app/Autoloader.php';
Autoloader::register();

App::getHead("Mon compte");
App::getMenu();
?>
<div class="jumbotron">
    <div class="container">
        <h1>Tableau de bord</h1>
        <a class="btn btn-primary" href="forum.php">Voir le forum</a>
    </div>
    <img class="rounded-circle shadow-sm border border-dark" src="img/user/<?= (User::getAttribut()['user_avatar'] == null) ? "default/default.svg" : "avatar/".User::getAttribut()['user_avatar'] ?>" height="40px" width="40px">
</div>
<?php App::getFooter(); ?>
