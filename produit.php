<?php
require 'functions.php';
require '_header.tpl.php';
require '_footer.tpl.php';
session_start();
?>

<?php $id = $_GET['id'];
$product = $home_products[$id]; ?>

<div class="detail-product">
    <h5><?= $product->name ?></h5>
    <img src="<?= $product->image ?>" alt="<?= $product->name ?>">
    <p><?= $product->description ?></p>
    <p><?= $product->price ?>€/kg</p>
    <a href="panier.php"><button type='submit' class="btn btn-dark" name='cart' value='<?=addToCart($product)?>'>Acheter</button> </a>
</div>