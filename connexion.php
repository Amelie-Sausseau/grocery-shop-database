<?php
require '_header.tpl.php';
require '_footer.tpl.php';
require 'functions.php';
session_start();

?>

<div class="container">

    <div class="form">
        <h2>Connexion</h2>
        <form class="form-body" action="">
            <div class="form-object" class="email">
                <label for="email">Adresse email :</label>
                <input type="email" placeholder="adresse@email.fr">
            </div>
            <div class="form-object" class="password">
                <label for="password">Mot de passe:</label>
                <input type="password" placeholder="Mot de passe">
            </div>
        </form>
        <form action="profil.php" method="post" class="btn-inscription">
            <input type="hidden" name="SignUp">
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