<?php
require '_header.tpl.php';
require '_footer.tpl.php';
require 'functions.php';
?>

<div class="container-xxl">
    <div class="title">
        <h1>Bienvenue sur l'épicerie en ligne</h1>
        <aside>Retrouvez ici tous vos produits d'épicerie livrés directement chez vous !</aside>
    </div>

    <div class="three-lasts">
        <p class="add-text">Les 3 derniers produits ajoutés :</p>
        <div class="row align-items-start">
            <?php foreach ($home_products as $currentProduct) : ?>
                <div class="col home-products">
                    <div class="card" style="width: 18rem;">
                        <img src="<?= $currentProduct->image ?>" class="card-img-top" alt="<?= $currentProduct->name ?>">
                        <div class="card-body">
                            <h3 class="card-title"><?= $currentProduct->name ?></h3>
                            <p class="card-text"><?= $currentProduct->price ?>€/kg</p>
                            <div class="card-btns">
                                <a href="" class="btn btn-light">Détails produit</a>
                                <a href="" class="btn btn-dark">Acheter</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>