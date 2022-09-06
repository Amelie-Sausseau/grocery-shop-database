<?php

    $servername = 'localhost';
    $username = 'root';
    $password = '';
    
    //On établit la connexion
    $conn = new mysqli($servername, $username, $password);
    
    //On vérifie la connexion
    if($conn->connect_error){
        die('Erreur : ' .$conn->connect_error);
    };

class Article
{
    public $id;
    public $name;
    public $image;
    public $price;
    public $category;
    public $description;
    public $quantity = 1;


    public function __construct($id = '', $name = '', $image = '', $price = '', $category = '', $description = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
        $this->price = $price;
        $this->category = $category;
        $this->description = $description;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}

$home_products = [
    new Article(
        "0",
        "Pommes",
        "images/apples.jpg",
        2.30,
        "fruit",
        "La pomme gala peut se déguster en tarte, au four, à cuisiner ou simplement à croquer !"
    ),
    new Article(
        "1",
        "Ananas",
        "images/pineapples.jpg",
        3,
        "fruit",
        "Pour rehausser le goût de vos diverses préparations, choisissez cet ananas Victoria. À la fois savoureux et rafraîchissant, il saura émerveiller vos papilles. Cet ananas victoria est ce qu'il vous faut pour apporter une touche d'exotisme à vos plats. "

    ),

    new Article(
        "2",
        "Fraises",
        "images/strawberry.jpg",
        2.50,
        "fruit",
        "Fraise juteuse, fondante et très parfumée, le parfait équilibre sucré et acidulé de la gariguette fait l’unanimité !"
    ),
];


//panier

function addToCart($article)
{
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    for ($i = 0; $i < count($_SESSION['cart']); $i++) {
        if ($_SESSION['cart'][$i]->id == $article->id) {
            echo "<script>alert(\"Le produit a déjà été ajouté au panier\")</script>";
            return;
        }
    }
    $article->quantity = 1;
    array_push($_SESSION['cart'], $article);
}

function homeProducts()
{
    return [
        new Article(
            "0",
            "Pommes",
            "images/apples.jpg",
            2.30,
            "fruit",
            "La pomme gala peut se déguster en tarte, au four, à cuisiner ou simplement à croquer !"
        ),
        new Article(
            "1",
            "Ananas",
            "images/pineapples.jpg",
            3,
            "fruit",
            "Pour rehausser le goût de vos diverses préparations, choisissez cet ananas Victoria. À la fois savoureux et rafraîchissant, il saura émerveiller vos papilles. Cet ananas victoria est ce qu'il vous faut pour apporter une touche d'exotisme à vos plats. "

        ),

        new Article(
            "2",
            "Fraises",
            "images/strawberry.jpg",
            2.50,
            "fruit",
            "Fraise juteuse, fondante et très parfumée, le parfait équilibre sucré et acidulé de la gariguette fait l’unanimité !"
        ),
    ];
}

function getArticleFromId($id)
{
    foreach (homeProducts() as $product) {
        if ($product->id == $id) {
            return $product;
        }
    }
}

function removeArticles($deleteId)
{
    if (!empty($_SESSION['cart'])) {
        for ($i = 0; $i < count($_SESSION['cart']); $i++) {
            if ($_SESSION['cart'][$i]->id == $deleteId->id) {
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
