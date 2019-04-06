<?php

session_start();
require '../app/Autoloader.php';
Autoloader::register();

App::getHead("Forum");
App::getMenu();
?>
<div class="jumbotron">
    <div class="container">
        <h1>Forum</h1>
        <p class="lead">Bienvenue sur le forum</p>
        <p><a href="forum.php">Tout</a> <a href="?cat=1">Informatique</a> <a href="?cat=2">Reseau</a></p>
    </div>
</div>
<div class="container">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">Numéro</th>
            <th scope="col">Titre</th>
            <th scope="col">Posté par</th>
            <th scope="col">Catégorie</th>
            <th scope="col">Date</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $bdd = Database::connect();
        if(!empty($_GET['cat']) && $_GET['cat'] == "1") {
            $req = $bdd->query('SELECT * FROM topic INNER JOIN categorie c on topic.cat_id = c.cat_id WHERE c.cat_id = 1');
        }
        else if(!empty($_GET['cat']) && $_GET['cat'] == "2") {
            $req = $bdd->query('SELECT * FROM topic INNER JOIN categorie c on topic.cat_id = c.cat_id WHERE c.cat_id = 2');
        } else {
            $req = $bdd->query('SELECT * FROM topic INNER JOIN categorie c on topic.cat_id = c.cat_id');
        }


        foreach($req as $topic): ?>
        <tr>
            <td><?= $topic['topic_id']; ?></td>
            <td><a href="topic.php?id=<?= $topic['topic_id'] ?>"><?= $topic['topic_sujet'] ?></a></td>
            <td><?= $topic['topic_par']; ?></td>
            <td><?= $topic['cat_nom']; ?></td>
            <td><?= $topic['topic_date']; ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php App::getFooter(); ?>
