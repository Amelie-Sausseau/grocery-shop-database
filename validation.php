<?php
require '_header.tpl.php';
require '_footer.tpl.php';
require 'functions.php';
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_POST['validationId'])) {
    emptyCart();
}

?>

<div class="container cart-page">

    <h3>Valider ma commande</h3>

    <?php foreach ($_SESSION['cart'] as $key => $products) : ?>
        <div class="card card-product mb-3" style="max-width: 1000px; margin-left: auto; margin-right: auto;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="<?= $products->image ?>" class="img-fluid rounded-start" alt="<?= $products->name ?>" style="max-width: 250px;">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?= $products->name ?></h5>
                        <p class="card-text">Quantité : <?= $products->quantity ?></p>
                        <form action="validation.php" method="post" class="quantity">

                        </form>

                        <p class="card-text">Total : <?= totalPerProduct($products->price, $products->quantity) ?> €</p>

                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="resume">
        <h5>Sous-total : <?= countProducts() ?> articles | <?= totalPrice() ?> €</h5>
        <p>Frais de port : 2,50€/kg</p>
    </div>

    <div class="total">
        <h4>Total à régler: <?= totalWithTaxes() ?> €</h4>
        <p>(Frais de port : <?= taxes() ?> €)</p>
        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Valider la commande
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Félicitations, votre commande est validée !</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Montant total: <?= totalWithTaxes() ?> €</h4>
                    <p>Date d'expédition estimée : <?= sendDate() ?></p>
                    <p>Date de livraison estimée : <?= receiveDate() ?></p>
                </div>
                <div class="modal-footer">
                    <form method="post">
                        <input type="hidden" name="validationId">
                        <input type="submit" name="validation" class="btn btn-dark btn-sm" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop" value='Fermer'>
                    </form>
                </div>
            </div>
        </div>
    </div>