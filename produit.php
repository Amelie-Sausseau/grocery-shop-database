<?php
require 'functions.php';
require '_footer.tpl.php';
session_start();
?>

<?php $id = $_GET['id'];
$product = getArticleFromId($id); ?>

<header>
    <?php require '_header.tpl.php'; ?>
</header>

<div class="detail-product">
    <h5><?= $product['nom'] ?></h5>
    <img src="<?= $product['image'] ?>" alt="<?= $product['nom'] ?>">
    <?= showStocks($product['id']) ?>
    <p><?= $product['description_detaillee'] ?></p>
    <p><?= $product['prix'] ?>€/kg</p>
    <?php if ($product['stock']>0) {echo "<a href=\"panier.php\"><button type='submit' class=\"btn btn-success\" name='cart' value='".addToCart($product)."'>Acheter</button> </a>";} ?>
</div>