<?php

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

// Page index

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

// Affichage produits / gammes

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
                        <input type=\"hidden\" name=\"addProduct\" value=\"" . $product['id'] . " \">
                        <input type=\"submit\" name=\"cart\" class=\"btn btn-dark btn-sm\" value=\"Acheter\">
                        </form>
                    </div>
                </div>
            </div>
        </div>";
        }
    }
}

// Gestion panier

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
    $article['quantity'] = 1;
    array_push($_SESSION['cart'], $article);
}


function removeArticles($deleteId)
{
    if (!empty($_SESSION['cart'])) {
        for ($i = 0; $i < count($_SESSION['cart']); $i++) {
            if ($_SESSION['cart'][$i]['id'] == $deleteId) {
                array_splice($_SESSION['cart'], $i, 1);
            }
        }
    }
}

function updateQuantity($id, $quantity)
{
    if (!empty($_SESSION['cart'])) {
        for ($i = 0; $i < count($_SESSION['cart']); $i++) {
            if ($_SESSION['cart'][$i]['id'] == $id) {
                $_SESSION['cart'][$i]['quantity'] = $quantity;
                break;
            }
        }
    }
}

function countProducts()
{
    $countProducts = 0;
    foreach ($_SESSION['cart'] as $product) {
        $countProducts += $product['quantity'];
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

// Calculs prix / taxes / dates

function totalPrice()
{
    $totalPrice = 0;
    foreach ($_SESSION['cart'] as $product) {
        $totalPrice += $product['prix'] * $product['quantity'];
    }
    return number_format($totalPrice, 2, ',', ' ');
}

function taxes()
{
    $taxes = 0;
    foreach ($_SESSION['cart'] as $product) {
        $taxes += 2.5 * $product['quantity'];
    }
    return number_format($taxes, 2, ',', ' ');
}

function totalWithTaxes()
{
    $totalPrice = 0;
    foreach ($_SESSION['cart'] as $product) {
        $totalPrice += $product['prix']  * $product['quantity'];
    };
    $taxes = 0;
    foreach ($_SESSION['cart'] as $product) {
        $taxes += 2.5 * $product['quantity'];
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

// Gestion utilisateurs

function newUser()
{
    $connect = new PDO('mysql:host=localhost;dbname=boutique_en_ligne', 'root', '');

    if (!empty($_POST['lastname']) && !empty($_POST['firstname']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        $nom = strip_tags($_POST['lastname']);
        $prenom = strip_tags($_POST['firstname']);
        $email = strip_tags($_POST['email']);
        $mdp = strip_tags($_POST['password']);


        if (strlen($nom) >= 2 && strlen($prenom) >= 2 && strlen($email) >= 10 && strlen($mdp) >= 6) {

            if (strlen($nom) <= 20 && strlen($prenom) <= 20 && strlen($email) <= 40 && strlen($mdp) <= 30) {

                if ((emailExists($email)) == false) {

                    $mdp_secu = password_hash($mdp, PASSWORD_BCRYPT);

                    $query = $connect->prepare("INSERT INTO clients (nom,prenom,email,mot_de_passe) VALUES(:nom, :prenom, :email, :mot_de_passe)");
                    $query->execute(array(
                        'nom' => $nom,
                        'prenom' => $prenom,
                        'email' => $email,
                        'mot_de_passe' => $mdp_secu,
                    ));

                    echo "<script>alert(\"Inscription réussie\")</script>";

                    header("Location: profil.php");
                    exit();

                } else echo "<script>alert(\"Cette adresse email est déjà utilisée\")</script>";

            } else echo "<script>alert(\"Trop de caractères\")</script>";

        } else echo "<script>alert(\"Il manque des caractères\")</script>";

    } else echo "<script>alert(\"Veuillez saisir tous les champs\")</script>";
}

function emailExists($email)
{
    $connect = connectDB();
    $query = $connect->prepare("SELECT * FROM clients WHERE email = ?");
    $query->execute(array($email));
    $result = $query->fetchAll();

    if($result) {
        return true;
    }
}

function connexion() 
{
    if (isset($_POST['connect_email']) &&  isset($_POST['connect_pwd'])) {

    }
}
