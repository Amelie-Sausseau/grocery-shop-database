<?php
require '_footer.tpl.php';
require 'functions.php';
session_start();

if (isset($_POST['updatePassword'])) {
    changePassword();
}
?>

<header>
    <?php require '_header.tpl.php'; ?>
</header>

<div class="container">

    <div class="form">
        <h2>Modifier mon mot de passe</h2>
        <form method="post" class="form-body">
            <div class="form-object" class="password">
                <label>Ancien mot de passe:</label>
                <input name="lastPassword" type="password" placeholder="Mot de passe">
            </div>
            <div class="form-object" class="password">
                <label>Nouveau mot de passe:</label>
                <input name="newPassword" type="password" placeholder="Mot de passe">
                <div id="newPasswordHelp" class="form-text">Entre 8 et 15 caractères, minimum 1 lettre, 1 chiffre et 1 caractère spécial</div>
            </div>

            <input type="hidden" name="updatePassword">
            <input type="submit" name="modifier" class="btn btn-success btn-sm" value="Enregistrer">
        </form>
    </div>
    <div class="btn-back">
        <a href="profil.php" type="button" class="btn btn-success">Mon compte</a>
    </div>

</div>