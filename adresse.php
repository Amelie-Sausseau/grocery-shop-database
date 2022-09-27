<?php
require '_footer.tpl.php';
require 'functions.php';

session_start();

$adresse = getAddress();
$adresseId = $adresse['id'];

if (isset($_POST['changeAddress'])) {
    changeAddress($adresseId);
}
?>

<header>
    <?php require '_header.tpl.php'; ?>
</header>

<div class="container">

    <div class="form">
        <h2>Modifier mon adresse</h2>
        <form action="adresse.php" method="post" class="form-body">
            <div class="form-object" class="adress">
                <label>Adresse :</label>
                <input name="newAddress" type="text" placeholder="1 Rue de L'épicerie" value="<?= $adresse['adresse'] ?>">
            </div>
            <div class="form-object" class="zip">
                <label>Code Postal :</label>
                <input name="newZip" type="text" placeholder="01000" value="<?= $adresse['code_postal'] ?>">
            </div>
            <div class="form-object" class="city">
                <label>Ville :</label>
                <input name="newCity" type="text" placeholder="Ville" value="<?= $adresse['ville'] ?>">
            </div>
            <input type="hidden" name="newUser">
            <input type="submit" name="changeAddress" class="btn btn-success btn-sm" value="Valider">
        </form>
    </div>
    <div class="btn-back">
        <a href="profil.php" type="button" class="btn btn-success">Mon compte</a>
    </div>

</div>