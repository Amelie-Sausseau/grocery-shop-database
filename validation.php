<?php
require '_footer.tpl.php';
require 'functions.php';
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$numero = orderNumber();
$produits = $_SESSION['cart'];


if (isset($_POST['validationId'])) {
    createOrder($numero, $produits);
    emptyCart();
}

$adresse = getAddress();
$adresseId = $adresse['id'];

if (isset($_POST['changeAddress'])) {
    changeAddress($adresseId);
}

if (isset($_POST['updateUser'])) {
    changeProfile();
}

?>

<header>
    <?php require '_header.tpl.php';?>
</header>

<div class="container cart-page">

    <h3>Valider ma commande</h3>

    <?php foreach ($_SESSION['cart'] as $key => $products) : ?>
        <div class="card card-product mb-3" style="max-width: 1000px; margin-left: auto; margin-right: auto;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="<?= $products['image'] ?>" class="img-fluid rounded-start" alt="<?= $products['nom']  ?>" style="max-width: 250px;">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?= $products['nom']  ?></h5>
                        <p class="card-text">Quantité : <?= $products['quantity']  ?></p>
                        <form action="validation.php" method="post" class="quantity">

                        </form>

                        <p class="card-text">Total : <?= totalPerProduct($products['prix'], $products['quantity']) ?> €</p>

                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="resume">
        <h5>Sous-total : <?= countProducts() ?> articles | <?= totalPrice() ?> €</h5>
        <p>Frais de port : 2,50€/kg</p>
    </div>

    <div class="form form-update">
        <h2>Coordonnées</h2>
        <form action="validation.php" method="post" class="form-body">
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

    <div class="form form-update">
        <h2>Adresse de livraison</h2>
        <form action="validation.php" method="post" class="form-body">
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

    <div class="total" name="createOrder">
    <form method="post">
        <h4>Total à régler: <?= totalWithTaxes() ?> €</h4>
        <p>(Frais de port : <?= taxes() ?> €)</p>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        Valider la commande</button>
    </form>
    </div>

    <!-- Modal -->
    <form method="post">
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
                        <input type="hidden" name="validationId">
                        <input type="submit" name="validation" class="btn btn-success btn-sm" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop" value='Fermer'>
                    </form>
                </div>
            </div>
        </div>
    </div>