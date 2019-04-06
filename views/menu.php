<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">Forum</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="forum.php">Accéder au forum</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <?php if(!isset($_SESSION['id'])): ?>
            <li><a class="nav-link" href="connexion.php">Connexion</a></li>
            <li><a class="btn btn-primary" href="inscription.php">Inscription</a></li>
            <?php endif; ?>
            <?php if(isset($_SESSION['id'])): ?>
                <li><a class="nav-link" href="deconnexion.php">Déconnexion</a></li>
                <li><a class="nav-link" href="profil.php?id=<?= $_SESSION['id'] ?>"><?= $_SESSION['pseudo']; ?></a></li>
                <li><a class="btn btn-primary" href="poster-un-topic.php">Poster un topic</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
