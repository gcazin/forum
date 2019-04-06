<?php

session_start();
require '../app/Autoloader.php';
Autoloader::register();

App::getHead("Profil");
App::getMenu();
?>
<div class="jumbotron">
    <div class="container">
        <h1>Bienvenue sur votre compte</h1>
    </div>
</div>
<div class="container">
    <form action="profil.php?id=<?= $_SESSION['id'] ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <input type="file" class="form-control" name="avatar">
        </div>
        <div class="form-group">
            <button class="btn btn-primary" type="submit">Valider les modifications</button>
        </div>
        <?php
        if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) {
            $tailleMax = 2097152;
            $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
            if($_FILES['avatar']['size'] <= $tailleMax) {
                $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
                if(in_array($extensionUpload, $extensionsValides)) {
                    $chemin = "img/user/avatar/".$_SESSION['id'].".".$extensionUpload;
                    $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
                    if($resultat) {
                        $bdd = Database::connect();
                        $updateavatar = $bdd->prepare('UPDATE user SET user_avatar = :avatar WHERE user_id = :id');
                        $updateavatar->execute(array(
                            'avatar' => $_SESSION['id'].".".$extensionUpload,
                            'id' => $_SESSION['id']
                        ));
                        header('Location: profil.php?id='.$_SESSION['id']);
                    } else {
                        $msg = "Erreur durant l'importation de votre photo de profil";
                    }
                } else {
                    $msg = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
                }
            } else {
                $msg = "Votre photo de profil ne doit pas dépasser 2Mo";
            }
        }
        ?>
    </form>
    <img src="img/user/avatar/<?= $_SESSION['id'] ?>.png">
</div>
<?php App::getFooter(); ?>
