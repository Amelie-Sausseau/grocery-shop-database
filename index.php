<?php
require '_footer.tpl.php';
require 'functions.php';
session_start();
?>

<header>
    <?php require '_header.tpl.php'; ?>
</header>

<div class="container-xxl">
    <div class="title">
        <h1>Bienvenue sur l'épicerie en ligne</h1>
        <aside>Retrouvez ici tous vos produits d'épicerie livrés directement chez vous !</aside>
    </div>

    <div class="three-lasts">
        <p class="add-text">Les 3 derniers produits ajoutés :</p>
        <div class="row align-items-start">
            <?= homeProducts() ?>
        </div>
    </div>
</div>