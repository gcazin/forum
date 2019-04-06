<?php

session_start();
if(!isset($_SESSION['id'])) {
    header('Location: mon-compte.php');
    die;
}

require '../app/Autoloader.php';
Autoloader::register();

App::getHead("Poster un topic");
App::getMenu();
?>
<div class="jumbotron">
    <div class="container">
        <h1 class="text-center mb-3">Formulaire de connexion</h1>
        <form action="poster-un-topic.php" method="post">
            <div class="form-group">
                <label for="titre">Titre du sujet</label>
                <select name="categorie" class="form-control">
                    <?php
                    $bdd = Database::connect();
                    $categories = $bdd->query('SELECT * FROM categorie');
                    foreach($categories as $category) {
                        echo '<option value="'.$category['cat_id'].'">'.$category['cat_nom'].'</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="titre">Titre du sujet</label>
                <input type="text" name="titre" id="titre" class="form-control" placeholder="Titre du sujet"
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea name="contenu" id="contenu" class="form-control" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
            </div>
        </form>
        <?php

        if(isset($_POST)) {
            if(isset($_POST['categorie'], $_POST['titre'], $_POST['contenu'])) {
                $bdd = Database::connect();
                $categorie = $_POST['categorie'];
                $titre = $_POST['titre'];
                $contenu = $_POST['contenu'];
                $errors = array();
                if(strlen($titre) < 5 || strlen($titre) > 100 || empty($titre)) {
                    array_push($errors, "Titre trop long ou trop court ou vide");
                }
                if(strlen($contenu) < 5 || strlen($contenu) > 500 || empty($contenu)) {
                    array_push($errors, "Contenu trop long ou trop court ou vide");
                }
                if(count($errors) > 0) {
                    echo '<div class="alert alert-danger">Le formulaire contient les erreurs suivantes: <ul>';
                    foreach($errors as $error) {
                        echo '<li>'.$error.'</li>';
                    }
                    echo '</ul></div>';
                    return true;
                } else {
                    $bdd = Database::connect();
                    $sql = 'INSERT INTO 
                            topic(topic_sujet, topic_contenu, topic_date, topic_cat, topic_par, cat_id, user_id)
                            VALUES (?, ?, CURDATE(), ?, ?, ?, ?)';
                    $req = $bdd->prepare($sql);
                    $req->bindParam(1, $titre);
                    $req->bindParam(2, $contenu);
                    $req->bindParam(3, $categorie);
                    $req->bindParam(4, $_SESSION['pseudo']);
                    $req->bindParam(5, $categorie);
                    $req->bindParam(6, $_SESSION['id']);
                    $req->execute();
                    AlertHelper::alert('primary', 'Topic posté!');
                    header( "Refresh:2; url=forum.php", true, 303);
                }
            }
        }

        ?>
    </div>
</div>
<?php App::getFooter(); ?>
