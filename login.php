<?php
include('header.php');
include('bdd.php');
?>
<!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css"> -->

<body>
    <div class="card">
        <article class="card-body">
            <h4 class="card-title text-center mb-4 mt-1">Connexion</h4>
            <hr>
            <p class="text-muted text-center">Veuillez vous authentifier</p>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <input name="username" class="form-control" placeholder="Identifiant" type="text">
                    </div>
                    <!-- input-group.// -->
                </div>
                <!-- form-group// -->
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input class="form-control" name="password" placeholder="******" type="password">
                    </div>
                    <!-- input-group.// -->
                </div>
                <!-- form-group// -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block"> Connexion </button>
                </div>
                <!-- form-group// -->
                <p class="text-center"><a href="./register.php" class="btn">S'inscrire</a> <br>
                    <a href="./forget.php" class="btn">Mot de passe oublié ?</a></p>
            </form>
        </article>
    </div>
    <!-- card.// -->
</body>

<?php 
if (isset($_POST['username']) AND isset($_POST['password'])) {

    $username = $_POST['username'];
    //  Récupération de l'utilisateur et de son password hashé
    $req = $bdd->prepare('SELECT id_user, password, prenom, nom FROM account WHERE username = :username');
    $req->execute(array(
        'username' => $_POST['username']));
    $resultat = $req->fetch();

    $prenom = isset($resultat['prenom']);
    $nom = isset($resultat['nom']);

    // Comparaison du password envoyé via le formulaire avec la bdd
    $isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);

    if (!$resultat) {
        echo '<h2>Mauvais identifiant ou mot de passe !!</h2>';
    } else {
        if ($isPasswordCorrect) {
            session_start();
            $_SESSION['id'] = $resultat['id_user'];
            $_SESSION['username'] = $username;
            $_SESSION['prenom'] = $resultat['prenom'];
            $_SESSION['nom'] = $resultat['nom'];
            echo 'Vous êtes connecté !';
            header('Location: home.php');
        } else {
            echo '<h2> Mauvais identifiant ou mot de passe ! </h2>';
        }
    }
}

include('footer.php');
?>
