<?php
require '_footer.tpl.php';
require 'functions.php';
session_start();

if (isset($_POST['newUser'])) {
    newUser();
}
?>

<header>
    <?php require '_header.tpl.php'; ?>
</header>

<div class="container">

    <div class="form">
        <h2>Créer mon compte</h2>
        <form action="inscription.php" method="post" class="form-body">
            <div class="form-object" class="lastname">
                <label>Nom :</label>
                <input name="lastname" type="text" placeholder="Nom">
            </div>
            <div class="form-object" class="firstname">
                <label>Prénom :</label>
                <input name="firstname" type="text" placeholder="Prénom">
            </div>
            <div class="form-object" class="email">
                <label>Adresse email :</label>
                <input name="email" type="email" placeholder="adresse@email.fr">
            </div>
            <div class="form-object" class="password">
                <label>Mot de passe:</label>
                <input name="password" type="password" placeholder="Mot de passe">
                <div id="passwordHelp" class="form-text">Entre 8 et 15 caractères, minimum 1 lettre, 1 chiffre et 1 caractère spécial</div>
            </div>
            <div class="form-object" class="adress">
                <label>Adresse :</label>
                <input name="address" type="text" placeholder="1 Rue de L'épicerie">
            </div>
            <div class="form-object" class="zip">
                <label>Code Postal :</label>
                <input name="zip" type="text" placeholder="01000">
            </div>
            <div class="form-object" class="city">
                <label>Ville :</label>
                <input name="city" type="text" placeholder="Ville">
            </div>
            <input type="hidden" name="newUser">
            <input type="submit" name="inscription" class="btn btn-dark btn-sm" value="S'inscrire">
        </form>

    </div>
    
</div>