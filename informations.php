<?php
require '_footer.tpl.php';
require 'functions.php';
session_start();

if (isset($_POST['updateUser'])) {
    changeProfile();
}
?>

<header>
    <?php require '_header.tpl.php'; ?>
</header>

<div class="container">

    <div class="form">
        <h2>Modifier mes informations</h2>
        <form method="post" class="form-body">
            <div class="form-object" class="lastname">
                <label>Nom :</label>
                <input name="newLastname" type="text" placeholder="Nom" value="<?= $_SESSION['nom']; ?>">
            </div>
            <div class="form-object" class="firstname">
                <label>Prénom :</label>
                <input name="newFirstname" type="text" placeholder="Prénom" value="<?= $_SESSION['prenom']; ?>">
            </div>
            <div class="form-object" class="email">
                <label>Adresse email :</label>
                <input name="newEmail" type="email" placeholder="adresse@email.fr" value="<?= $_SESSION['email']; ?>">
            </div>
            
            <input type="hidden" name="updateUser">
            <input type="submit" name="modifier" class="btn btn-success btn-sm" value="Enregistrer">
        </form>
    </div>
    <div class="btn-back">
        <a href="profil.php" type="button" class="btn btn-success">Mon compte</a>
    </div>
    
</div>