<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <?php
                    if(array_key_exists("identifiant",$_SESSION)){
                        echo('<a class="nav-link active" aria-current="page" href="deconnexion.php">Se deconnecter</a>');
                        echo('<a class="nav-link active" aria-current="page" href="addplayer.php">Ajouter des joueurs</a>');
                    }else{
                        echo('<a class="nav-link active" aria-current="page" href="connexion.php">Se connecter</a>');
                    }

                    ?>
                </li>

        </div>
    </div>
</nav>