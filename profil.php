<?php
require '_header.tpl.php';
require '_footer.tpl.php';
require 'functions.php';
session_start();
?>
<div>
    <div class="account-banner">
        <h1>Mon compte</h1>
    </div>
    <div class="account-buttons">
        <div class="row align-items-start">
            <div class="col home-products">
                <div class="card card-user" style="width: 18rem;">
                    <i class="fa-solid fa-user"></i>
                    <div class="card-btns">
                        <a href="" class="btn btn-dark">Modifier mes informations</a>
                    </div>
                </div>
            </div>
            <div class="col home-products">
                <div class="card card-user" style="width: 18rem;">
                <i class="fa-solid fa-key"></i>
                    <div class="card-btns">
                        <a href="" class="btn btn-dark">Modifier mon mot de passe</a>
                    </div>
                </div>
            </div>
            <div class="col home-products">
                <div class="card card-user" style="width: 18rem;">
                <i class="fa-solid fa-location-dot"></i>
                    <div class="card-btns">
                        <a href="" class="btn btn-dark">Modifier mon adresse</a>
                    </div>
                </div>
            </div>
            <div class="col home-products">
                <div class="card card-user" style="width: 18rem;">
                <i class="fa-solid fa-bag-shopping"></i>
                    <div class="card-btns">
                        <a href="commandes.php" class="btn btn-dark">Voir mes commandes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>