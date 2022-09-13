<?php

function connectDB()
{
    $username = 'root';
    $password = '';

    $cnx = 'mysql:dbname=boutique_en_ligne;host=127.0.0.1;charset=UTF8';

    $pdo = new PDO($cnx, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
    ]);

    return $pdo;
};

//panier

function addToCart($article)
{
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    for ($i = 0; $i < count($_SESSION['cart']); $i++) {
        if ($_SESSION['cart'][$i]['id'] == $article['id']) {
            echo "<script>alert(\"Le produit a déjà été ajouté au panier\")</script>";
            return;
        }
    }
    $article['quantite'] = 1;
    array_push($_SESSION['cart'], $article);
}


function homeProducts()
{
    $connect = connectDB();
    $query = $connect->prepare("SELECT * FROM articles ORDER BY id DESC LIMIT 3");
    $query->execute();
    $allArticles = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($allArticles as $currentProduct) {
        $range = getRangeFromId($currentProduct['id_gamme']);

        echo "
        <div class=\"col home-products\">
            <div class=\"card\" style=\"width: 18rem;\">
                <img src=\" " . $currentProduct['image'] . " \" class=\"card-img-top\">
                <span class=\"card-span\" style=\"text-transform: capitalize; color: lightgrey; font-size: 14px\">" . $range['nom'] . "</span>
                <div class=\"card-body\">
                    <h3 class=\"card-title\">" . $currentProduct['nom'] . " </h3>
                    <p class=\"card-text\">" . $currentProduct['prix'] . "€/kg</p>
                    <p class=\"card-text\">" . $currentProduct['description'] . "</p>
                    <div class=\"card-btns\">
                        <a href=\"produit.php?&id=" . $currentProduct['id'] . " \"class=\"btn btn-light\">Détails produit</a>
                        <form action=\"panier.php\" method=\"post\">
                        <input type=\"hidden\" name=\"addProduct\" value=\"" . $currentProduct['id'] . " \">
                        <input type=\"submit\" name=\"cart\" class=\"btn btn-dark btn-sm\" value=\"Acheter\">
                    </form>
                    </div>
                </div>
            </div>
        </div>";
    }
}

function getArticleFromId($id)
{
    $connect = connectDB();
    $query = $connect->prepare("SELECT * FROM articles WHERE id = ?");
    $query->execute(array($id));
    return $query->fetch();
}

function getArticleFromRange($id)
{
    $connect = connectDB();
    $query = $connect->prepare("SELECT * FROM articles WHERE id_gamme = ?");
    $query->execute(array($id));
    return $query->fetchAll();
}

function getRangeFromId($id)
{
    $connect = connectDB();
    $query = $connect->prepare("SELECT * FROM gammes WHERE id = ?");
    $query->execute(array($id));
    return $query->fetch();
}

function articlesByRange()
{
    $connect = connectDB();
    $query = $connect->prepare("SELECT * FROM gammes");
    $query->execute();
    $allRanges = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($allRanges as $currentRange) {
        $productByRange = getArticleFromRange($currentRange['id']);
        echo
        "<nav class=\"navbar bg-light  range-name\">
        <div class=\"container-fluid\">
          <h3 class=\"navbar-brand mb-0 h1\" style=\"text-transform: capitalize; color: black !important\">" . $currentRange['nom'] . "s</h3>
        </div>
      </nav>";
        foreach ($productByRange as $product) {
            echo
        "<div class=\"col range-products\">
            <div class=\"card\" style=\"width: 18rem;\">
                <img src=\" " . $product['image'] . " \" class=\"card-img-top\">
                <div class=\"card-body\">
                    <h3 class=\"card-title\">" . $product['nom'] . " </h3>
                    <p class=\"card-text\">" . $product['prix'] . "€/kg</p>
                    <p class=\"card-text\">" . $product['description'] . "</p>
                    <div class=\"card-btns\">
                        <a href=\"produit.php?&id=" . $product['id'] . " \"class=\"btn btn-light\">Détails produit</a>
                        <form action=\"panier.php\" method=\"post\">
                            <input type=\"hidden\" name=\" " . addToCart($product) . " \" value=\" " . $product['id'] . " \">
                            <input type=\"submit\" name=\"cart\" class=\"btn btn-dark btn-sm\" value=\"Acheter\">
                        </form>

                    </div>
                </div>
            </div>
        </div>";
        }
    }
}

function removeArticles($deleteId)
{
    if (!empty($_SESSION['cart'])) {
        for ($i = 0; $i < count($_SESSION['cart']); $i++) {
            if ($_SESSION['cart'][$i] == $deleteId) {
                array_splice($_SESSION['cart'], $i, 1);
            }
        }
    }
}

function updateQuantity($id, $quantity)
{
    if (!empty($_SESSION['cart'])) {
        for ($i = 0; $i < count($_SESSION['cart']); $i++) {
            if ($_SESSION['cart'][$i]->id == $id) {
                $_SESSION['cart'][$i]->quantity = $quantity;
                break;
            }
        }
    }
}

function countProducts()
{
    $countProducts = 0;
    foreach ($_SESSION['cart'] as $product) {
        $countProducts += $product->quantity;
    }
    return $countProducts;
}

function emptyCartMessage()
{
    if (empty($_SESSION['cart'])) {
        echo 'Le panier est vide';
    }
}

function emptyCart()
{
    $_SESSION['cart'] = [];
}

function totalPerProduct($price, $quantity)
{
    $totalPerProduct = $price * $quantity;
    return number_format($totalPerProduct, 2, ',', ' ');
}

function totalPrice()
{
    $totalPrice = 0;
    foreach ($_SESSION['cart'] as $product) {
        $totalPrice += $product->price * $product->quantity;
    }
    return number_format($totalPrice, 2, ',', ' ');
}

function taxes()
{
    $taxes = 0;
    foreach ($_SESSION['cart'] as $product) {
        $taxes += 2.5 * $product->quantity;
    }
    return number_format($taxes, 2, ',', ' ');
}

function totalWithTaxes()
{
    $totalPrice = 0;
    foreach ($_SESSION['cart'] as $product) {
        $totalPrice += $product->price * $product->quantity;
    };
    $taxes = 0;
    foreach ($_SESSION['cart'] as $product) {
        $taxes += 2.5 * $product->quantity;
    };
    $totalWithTaxes = $totalPrice + $taxes;
    return number_format($totalWithTaxes, 2, ',', ' ');
}

function sendDate()
{
    $sendDate = date('j F Y', strtotime("+2 days"));
    setlocale(LC_TIME, "fr_FR");
    echo strftime("%A %d %B %G", strtotime($sendDate));
}

function receiveDate()
{
    $receiveDate = date('j F Y', strtotime("+5 days"));
    setlocale(LC_TIME, "fr_FR");
    echo strftime("%A %d %B %G", strtotime($receiveDate));
}
