<?php

session_start();
if(isset($_SESSION['id'])) {
    header('Location: mon-compte.php');
    die;
}

require '../app/Autoloader.php';
Autoloader::register();

App::getHead("Connexion");
App::getMenu();
?>
<div class="jumbotron">
    <div class="container">
        <h1 class="text-center mb-3">Formulaire de connexion</h1>
        <form action="connexion.php" method="post">
            <div class="form-group">
                <label for="pseudo">Pseudo</label>
                <input type="text" name="pseudo" id="pseudo" class="form-control" <?= empty($_SESSION['pseudo']) ? 'placeholder="Pseudo"' : 'value="'.$_SESSION['pseudo'].'"'  ?>>
            </div>
            <div class="form-group">
                <label for="mdp">Mot de passe</label>
                <input type="password" name="mdp" id="mdp" class="form-control" placeholder="Mot de passe">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
            </div>
        </form>
        <?php

        if(isset($_POST)) {
            if(isset($_POST['pseudo'], $_POST['mdp'])) {
                $bdd = Database::connect();
                $pseudo = $_POST['pseudo'];

                $req = $bdd->prepare('SELECT * from user WHERE user_pseudo = :pseudo');
                $req->execute(array(':pseudo' => $pseudo));
                $resultat = $req->fetch();

                $verifMdp = password_verify($_POST['mdp'], $resultat['user_mdp']);

                if(!$resultat) {
                    AlertHelper::alert("danger", "Identifiant ou mot de passe incorrect");
                } else {
                    if($verifMdp) {
                        $_SESSION['pseudo_temp'] = session_destroy();
                        session_start();
                        $_SESSION['id'] = $resultat['user_id'];
                        $_SESSION['pseudo'] = $pseudo;
                        $req = $bdd->prepare('SELECT * from user WHERE user_pseudo = :pseudo');
                        $req->execute(array('pseudo' => $pseudo));
                        $resultat = $req->fetch();
                        AlertHelper::alert('primary', 'Connexion réussi! Vous allez être redigiré vers votre tableau de bord');
                        header( "Refresh:1; url=mon-compte.php", true, 303);
                    } else {
                        AlertHelper::alert("danger", "Identifiant ou mot de passe incorrect");
                    }
                }
            }
        }

        ?>
    </div>
</div>
<?php App::getFooter(); ?>
