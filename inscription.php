<?php
require '_header.tpl.php';
require '_footer.tpl.php';
require 'functions.php';
session_start();

?>

<div class="container">

    <div class="form">
        <h2>Créer mon compte</h2>
        <form class="form-body" action="">
            <div class="form-object" class="lastname">
                <label for="lastname">Nom :</label>
                <input type="text" placeholder="Nom">
            </div>
            <div class="form-object" class="firstname">
                <label for="firstname">Prénom :</label>
                <input type="text" placeholder="Prénom">
            </div>
            <div class="form-object" class="email">
                <label for="email">Adresse email :</label>
                <input type="email" placeholder="adresse@email.fr">
            </div>
            <div class="form-object" class="password">
                <label for="password">Mot de passe:</label>
                <input type="password" placeholder="Mot de passe">
            </div>
            <div class="form-object" class="adress">
                <label for="adress">Adresse :</label>
                <input type="text" placeholder="1 Rue de L'épicerie">
            </div>
            <div class="form-object" class="zip">
                <label for="zip">Code Postal :</label>
                <input type="text" placeholder="01000">
            </div>
            <div class="form-object" class="city">
                <label for="city">Ville :</label>
                <input type="text" placeholder="Ville">
            </div>
        </form>
        <form action="connexion.php" method="post" class="btn-inscription">
            <input type="hidden" name="newUser">
            <input type="submit" name="inscription" class="btn btn-dark btn-sm" value="S'inscrire">
        </form>

    </div>
    
</div>