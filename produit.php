<?php
require 'functions.php';
require '_header.tpl.php';
require '_footer.tpl.php';
session_start();
?>

<?php $id = $_GET['id'];
$product = getArticleFromId($id); ?>

<div class="detail-product">
    <h5><?= $product['nom'] ?></h5>
    <img src="<?= $product['image'] ?>" alt="<?= $product['nom'] ?>">
    <p><?= $product['description_detaillee'] ?></p>
    <p><?= $product['prix'] ?>€/kg</p>
    <a href="panier.php"><button type='submit' class="btn btn-dark" name='cart' value='<?=addToCart($product)?>'>Acheter</button> </a>
</div>