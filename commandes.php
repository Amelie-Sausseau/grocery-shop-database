<?php
require '_footer.tpl.php';
require 'functions.php';
session_start();
?>

<header>
    <?php require '_header.tpl.php'; ?>
</header>

<div class="container cart-page">

    <h3>Mes commandes</h3>

    <div class="table">
        <table>
            <?= listOrders() ?>
        </table>
    </div>
    <div class="btn-back">
        <a href="profil.php" type="button" class="btn btn-success">Mon compte</a>
    </div>
</div>