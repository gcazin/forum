<?php

require '../app/Autoloader.php';
Autoloader::register();

App::getHead("Inscription");
App::getMenu();
?>
<div class="jumbotron">
    <div class="container">
        <h1 class="text-center mb-3">Formulaire d'inscription</h1>
        <form action="inscription.php" method="post">
            <div class="form-group">
                <label for="pseudo">Pseudo</label>
                <input type="text" name="pseudo" id="pseudo" class="form-control" placeholder="Pseudo">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="luc@gmail.com">
                </div>
                <div class="form-group col-md-6">
                    <label for="mdp">Mot de passe</label>
                    <input type="password" name="mdp" id="mdp" class="form-control" placeholder="Mot de passe">
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
            </div>
        </form>
        <?php

        if(isset($_POST)) {
            if(isset($_POST['pseudo'], $_POST['email'], $_POST['mdp'])) {
                $pseudo = $_POST['pseudo'];
                $email = $_POST['email'];
                $mdp = $_POST['mdp'];
                $errors = array();
                $bdd = Database::connect();
                $req = $bdd->prepare('SELECT COUNT(*) FROM user WHERE user_pseudo = ?');
                $req->execute(array(strtolower($_POST['pseudo'])));
                if ($req->fetchColumn() != 0)
                    array_push($errors, "Ce pseudo est déjà utilisé");
                if(strlen($pseudo) < 4 || strlen($pseudo) > 24 || empty($pseudo))
                    array_push($errors, "Votre pseudo est trop long ou trop court, ou est vide");
                if(!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($email))
                    array_push($errors, "Votre email n'a pas un format valide ou est vide");
                if(strlen($mdp) < 4 || empty($mdp))
                    array_push($errors, "Votre mot de passe est trop court ou vide");
                if(count($errors) > 0) {
                    echo '<div class="alert alert-danger">Le formulaire contient les erreurs suivantes: <ul>';
                    foreach($errors as $error) {
                        echo '<li>'.$error.'</li>';
                    }
                    echo '</ul></div>';
                    return true;
                } else {
                    $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
                    $bdd = Database::connect();
                    $sql = 'INSERT INTO 
                            user(user_pseudo, user_mdp, user_email, user_dateinscription) 
                            VALUES (?, ?, ?, CURDATE())';
                    $req = $bdd->prepare($sql);
                    $req->bindParam(1, $pseudo);
                    $req->bindParam(2, $mdp);
                    $req->bindParam(3, $email);
                    $req->execute();
                    AlertHelper::alert('primary', 'Inscription réussi! Vous allez être redigiré vers la page de connexion');
                    header( "Refresh:2; url=connexion.php", true, 303);
                    $_SESSION['pseudo_temp'] = $pseudo;
                }
            }
        }

        ?>
    </div>
</div>
<?php App::getFooter(); ?>
