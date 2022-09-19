<?php
require '_footer.tpl.php';
require 'functions.php';
session_start();

if (isset($_POST['LogIn'])) {
    connexion();
}
?>

<header>
    <?php require '_header.tpl.php'; ?>
</header>

<div class="container">

    <div class="form">
        <h2>Connexion</h2>
        <form action="connexion.php" method="post" class="form-body">
            <div class="form-object" class="email">
                <label for="email">Adresse email :</label>
                <input type="email" name="connect_email" placeholder="adresse@email.fr">
            </div>
            <div class="form-object" class="password">
                <label for="password">Mot de passe:</label>
                <input type="password" name="connect_pwd" placeholder="Mot de passe">
            </div>
            <input type="hidden" name="LogIn">
            <input type="submit" name="connexion" class="btn btn-dark btn-sm" value="Se connecter">
        </form>
    </div>

    <div class="not-registered">
    <h3>Pas encore de compte ?</h3>
    <form action="inscription.php" method="post" class="btn-inscription">
            <input type="hidden" name="signIn">
            <input type="submit" name="sign" class="btn btn-dark btn-sm" value="S'inscrire">
        </form>
    </div>

</div>