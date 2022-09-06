<?php
session_start();
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
                        <img src="<?= $currentProduct->getImage() ?>" class="card-img-top" alt="<?= $currentProduct->getName() ?>">
                        <div class="card-body">
                            <h3 class="card-title"><?= $currentProduct->getName() ?></h3>
                            <p class="card-text"><?= $currentProduct->getPrice() ?>€/kg</p>
                            <div class="card-btns">
                                <a href="produit.php?&id=<?= $currentProduct->getId() ?>" class="btn btn-light">Détails produit</a>
                                <form action="panier.php" method="post">
                                    <input type="hidden" name="addProduct" value="<?=$currentProduct->id ?>">
                                    <input type="submit" name="cart" class="btn btn-dark btn-sm" value="Acheter">
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>