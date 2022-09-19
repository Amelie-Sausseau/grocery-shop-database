<?php
require '_footer.tpl.php';
require 'functions.php';
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_POST['addProduct'])) {
    $article = getArticleFromId($_POST['addProduct']);
    addToCart($article);
}

if (isset($_POST['quantity'])) {
    updateQuantity($_POST['articleId'], $_POST['quantity']);
}

if (isset($_POST['deleteId'])) {
    $deleteId = $_POST['deleteId'];
    removeArticles($deleteId);
}

if (isset($_POST['clearedId'])) {
    emptyCart();
}

?>

<header>
    <?php require '_header.tpl.php'; ?>
</header>

<div class="container cart-page">

    <h3>Mon panier</h3>

    <p class="card-text"></p>

    <?php foreach ($_SESSION['cart'] as $key => $products) : ?>
        <div class="card mb-3" style="max-width: 1000px; margin-left: auto; margin-right: auto;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="<?= $products['image'] ?>" class="img-fluid rounded-start" alt="<?= $products['nom']  ?>" style="max-width: 250px;">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?= $products['nom']  ?></h5>
                        <p class="card-text">Quantité : <?= $products['quantity']  ?></p>
                        <form action="panier.php" method="post" class="quantity">
                            <p>Modifier la quantité :</p>
                            <input type="number" class="form-control" name="quantity" value="<?= $products['quantity']  ?>" min="1">
                            <p class="card-text"><small class="text-muted"><?= $products['prix']  ?>€/kg</small></p>
                            <input type="hidden" name="articleId" value="<?= $products['id']  ?>">
                            <input type="submit" name="submit" class="btn btn-dark btn-sm" value='Valider'>
                        </form>
                        <form action="panier.php" method="post">
                            <input type="hidden" name="deleteId" value="<?= $products['id']  ?>">
                            <input type="submit" name="delete" class="btn btn-danger btn-sm" value='Retirer du panier'>
                        </form>

                        <p class="card-text">Total : <?= totalPerProduct($products['prix'] , $products['quantity'] ) ?> €</p>

                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="resume">
        <h5>Total : <?= countProducts() ?> articles | <?= totalPrice() ?> €</h5>
        <div class="resume-buttons">
        <?php if(isset($_SESSION['id'])) {echo "<form action=\"validation.php\" method=\"post\">
                <input type=\"submit\" name=\"validateCart\" class=\"btn btn-success btn-sm\" value='Valider le panier'>
            </form>";}?>
            <form action="panier.php" method="post">
                <input type="hidden" name="clearedId">
                <input type="submit" name="clear" class="btn btn-dark btn-sm" value='Vider le panier'>
            </form>
        </div>
    </div>
</div>