<?php

session_start();
require '../app/Autoloader.php';
Autoloader::register();

App::getHead("Topic");
App::getMenu();
?>
<?php

$topic_id = $_GET['id'];
$bdd = Database::connect();
$req = $bdd->query("
SELECT * 
FROM topic 
INNER JOIN categorie c on topic.cat_id = c.cat_id
INNER JOIN user u on topic.user_id = u.user_id
WHERE topic_id = " . $topic_id);
$resultat = $req->fetch();

$replies = $bdd->query('
SELECT * 
FROM replie 
INNER JOIN user u on replie.replie_par = u.user_id
WHERE topic_id = ' . $topic_id);

?>
<div class="jumbotron">
    <div class="container">
        <h1><?= $resultat['topic_sujet'] ?></h1>
        <p class="lead">Dans la catégorie <span class="font-weight-bold"><?= $resultat['cat_nom'] ?></span></p>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="card" style="width: 100%;">
            <h5 class="card-header"><img class="rounded-circle shadow-sm border border-dark" src="img/user/<?= ($resultat['user_avatar'] == null) ? "default/default.svg" : "avatar/".$resultat['user_avatar'] ?>" height="40px" width="40px"> <?= $resultat['topic_par']; ?></h5>
            <div class="card-body">
                <p><?= $resultat['topic_contenu']; ?></p>
            </div>
        </div>
        <?php foreach($replies as $reply): ?>
            <div class="card mt-2" style="width: 100%;">
                <h5 class="card-header"><img class="rounded-circle shadow-sm border border-dark" src="img/user/<?= ($reply['user_avatar'] == null) ? "default/default.svg" : "avatar/".$reply['user_avatar'] ?>" height="40px" width="40px"> <?= $reply['user_pseudo']; ?></h5>
                <div class="card-body">
                    <p><?= $reply['replie_content'] ?></p>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="col-lg-12 mt-3">
            <form action="topic.php?id=<?= $topic_id ?>" method="post">
                <div class="form-group">
                    <textarea name="message" id="message" class="form-control" cols="30" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block">Poster le message</button>
                </div>
            </form>
            <?php

            if(isset($_POST)) {
                if(isset($_POST['message'])) {
                    $message = htmlspecialchars($_POST['message']);
                    if(strlen($message) > 500 || empty($message)) {
                        AlertHelper::alert("danger", "Message trop long ou vide");
                    } else {
                        $bdd = Database::connect();
                        $req = $bdd->prepare('
                                INSERT INTO 
                                replie(replie_content, replie_date, replie_topics, replie_par, topic_id) 
                                VALUES (?, CURDATE(), ?, ?, ?)');
                        $req->bindParam(1, $message);
                        $req->bindParam(2, $topic_id);
                        $req->bindParam(3, $_SESSION['id']);
                        $req->bindParam(4, $topic_id);
                        $req->execute();
                        AlertHelper::alert('primary', "Message posté avec succés");
                        header( "Refresh:1; url=topic.php?id=$topic_id", true, 303);
                    }
                }
            }

            ?>
        </div>
    </div>
</div>
<?php App::getFooter(); ?>
