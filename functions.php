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
            <div class=\"card border-success\" style=\"width: 18rem;\">
                <img src=\" " . $currentProduct['image'] . " \" class=\"card-img-top\">
                <span class=\"badge text-bg-light\">" . $range['nom'] . "</span>
                <div class=\"card-body\">
                    <h3 class=\"card-title\">" . $currentProduct['nom'] . " </h3>
                    <p class=\"card-text\">" . $currentProduct['prix'] . "€/kg</p>
                    <p class=\"card-text\">" . $currentProduct['description'] . "</p>
                    " . showStocks($currentProduct['id']) . "
                    <div class=\"card-btns\">
                        <a href=\"produit.php?&id=" . $currentProduct['id'] . " \"class=\"btn btn-outline-secondary\">Détails produit</a>
                        <form action=\"panier.php\" method=\"post\">
                        <input type=\"hidden\" name=\"addProduct\" value=\"" . $currentProduct['id'] . " \">
                        <input " . possiblePurchase($currentProduct['stock']) . " name=\"cart\" class=\"btn btn-dark btn-sm\" value=\"Acheter\">
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
    $query = $connect->prepare("SELECT * FROM articles WHERE id_gamme = ? ORDER BY nom");
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
        "<nav class=\"navbar range-name\" style=\"background-color: #1987546b; border-radius: 10px;\">
        <div class=\"container-fluid\">
          <h3 class=\"navbar-brand mb-0 h1\" style=\"text-transform: capitalize; color: black !important; font-weight : bold;\">" . $currentRange['nom'] . "s</h3>
        </div>
      </nav>";
        foreach ($productByRange as $product) {
            echo
            "<div class=\"col range-products\">
            <div class=\"card border-success\" style=\"width: 18rem;\">
                <img src=\" " . $product['image'] . " \" class=\"card-img-top\">
                <div class=\"card-body\">
                    <h3 class=\"card-title\">" . $product['nom'] . " </h3>
                    <p class=\"card-text\">" . $product['prix'] . "€/kg</p>
                    <p class=\"card-text\">" . $product['description'] . "</p>
                    " . showStocks($product['id']) . "
                    <div class=\"card-btns\">
                        <a href=\"produit.php?&id=" . $product['id'] . " \"class=\"btn btn-outline-secondary\">Détails produit</a>
                        <form action=\"panier.php\" method=\"post\">
                        <input type=\"hidden\" name=\"addProduct\" value=\"" . $product['id'] . " \">
                        <input " . possiblePurchase($product['stock']) . " name=\"cart\" class=\"btn btn-dark btn-sm\" value=\"Acheter\">
                        </form>
                    </div>
                </div>
            </div>
        </div>";
        }
    }
}

function showStocks($id)
{
    $connect = connectDB();
    $query = $connect->prepare("SELECT * FROM articles WHERE id = ?");
    $query->execute(array($id));
    $articleStock =  $query->fetch();

    if ($articleStock['stock'] >= 10) {
        return "<p class=\"badge text-bg-success\">En Stock</p>";
    } else if ($articleStock['stock'] < 10 && $articleStock['stock'] >= 1) {
        return "<p class=\"badge text-bg-warning\">Plus que " . $articleStock['stock'] . " kg en stock</p>";
    } else if ($articleStock['stock'] == 0) {
        return "<p class=\"badge text-bg-danger\">Article epuisé</p>";
    }
}

function possiblePurchase($int)
{
    if ($int > 0) {
        return "type=\"submit\"";
    } else {
        return "type=\"hidden\"";
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

function navbarCart() {
    if (isset($_SESSION['cart'])) {
        return "Panier (".count($_SESSION['cart']).")";
    }
    else {
        return "Panier (0)";
    }
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

function ordersTaxes($articles)
{
    $taxes = 0;
    foreach ($articles as $product) {
        $taxes += 2.5 * $product['quantite'];
    }
    return number_format($taxes, 2, ',', ' ');
}

function actualDate()
{
    $actualDate = date('d M Y');
    setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
    echo date("d M Y", strtotime($actualDate));
}

function sendDate()
{
    $sendDate = date('d M Y', strtotime("+2 days"));
    setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
    echo date("d M Y", strtotime($sendDate));
}

function receiveDate()
{
    $receiveDate = date('d M Y', strtotime("+5 days"));
    setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
    echo date("d M Y", strtotime($receiveDate));
}

// Gestion utilisateurs
function checkPassword($password)
{
    // minimum 8 caractères et maximum 15, minimum 1 lettre, 1 chiffre et 1 caractère spécial
    $regex = "^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[@$!%*?/&])(?=\S+$).{8,15}$^";
    return preg_match($regex, $password);
}

function newUser()
{
    $connect = connectDB();

    if (!empty($_POST['lastname']) && !empty($_POST['firstname']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        $nom = strip_tags($_POST['lastname']);
        $prenom = strip_tags($_POST['firstname']);
        $email = strip_tags($_POST['email']);
        $mdp = strip_tags($_POST['password']);
        $adresse = strip_tags($_POST['address']);
        $cp = strip_tags($_POST['zip']);
        $ville = strip_tags($_POST['city']);


        if (strlen($nom) >= 2 && strlen($prenom) >= 2 && strlen($email) >= 10 && strlen($mdp) >= 8) {

            if (strlen($nom) <= 20 && strlen($prenom) <= 20 && strlen($email) <= 40 && strlen($mdp) <= 15) {

                if ((emailExists($email)) == false) {

                    if (checkPassword($mdp)) {

                        $mdp_secu = password_hash($mdp, PASSWORD_BCRYPT);

                        $query = $connect->prepare("INSERT INTO clients (nom,prenom,email,mot_de_passe) VALUES(:nom, :prenom, :email, :mot_de_passe)");
                        $query->execute(array(
                            'nom' => htmlspecialchars($nom),
                            'prenom' => htmlspecialchars($prenom),
                            'email' => htmlspecialchars($email),
                            'mot_de_passe' => htmlspecialchars($mdp_secu),
                        ));

                        $id = $connect->lastInsertId();

                        if (!empty($id) && !empty($adresse) || !empty($cp) || !empty($ville)) {
                            $query = $connect->prepare("INSERT INTO adresses (id_client,adresse,code_postal,ville) VALUES(:id_client, :adresse, :code_postal, :ville)");
                            $query->execute(array(
                                'id_client' => $id,
                                'adresse' => htmlspecialchars($adresse),
                                'code_postal' => htmlspecialchars($cp),
                                'ville' => htmlspecialchars($ville),
                            ));
                        }

                        echo "<script>alert(\"Inscription réussie\")</script>";

                        header("Location: connexion.php");
                        exit();
                    } else echo "<script>alert(\"Mot de passe incorrect\")</script>";
                } else echo "<script>alert(\"Cette adresse email est déjà utilisée\")</script>";
            } else echo "<script>alert(\"Trop de caractères\")</script>";
        } else echo "<script>alert(\"Il manque des caractères\")</script>";
    } else echo "<script>alert(\"Veuillez saisir tous les champs\")</script>";
}

function addAddress($user)
{
    $connect = connectDB();

    $adresse = strip_tags($_POST['address']);
    $cp = strip_tags($_POST['zip']);
    $ville = strip_tags($_POST['city']);

    $query = $connect->prepare("INSERT INTO adresses (id_client,adresse,code_postal,ville) VALUES(:id_client, :adresse, :code_postal, :ville)");
    $query->execute(array(
        'id_client' => htmlspecialchars($user),
        'adresse' => htmlspecialchars($adresse),
        'code_postal' => htmlspecialchars($cp),
        'ville' => htmlspecialchars($ville),
    ));
}

function emailExists($email)
{
    $connect = connectDB();
    $query = $connect->prepare("SELECT * FROM clients WHERE email = ?");
    $query->execute(array($email));
    $result = $query->fetchAll();

    if ($result) {
        return true;
    }
}

function connexion()
{
    $connect = connectDB();

    $email = strip_tags($_POST['connect_email']);
    $password = $_POST['connect_pwd'];

    if (isset($email) && isset($password)) {
        $query = $connect->prepare("SELECT * FROM clients WHERE email = ?");
        $query->execute(array($email));
        $validatedEmail = $query->fetch();

        if ($validatedEmail) {
            $validatedPassword = password_verify($password, $validatedEmail['mot_de_passe']);

            if ($validatedPassword) {
                echo "<script>alert(\"Connexion réussie\")</script>";

                $_SESSION['email'] = $email;
                $_SESSION['id'] = $validatedEmail['id'];
                $_SESSION['prenom'] = $validatedEmail['prenom'];
                $_SESSION['nom'] = $validatedEmail['nom'];
                $_SESSION['adresse'] = getAddress($validatedEmail['id']);

                header("Location: profil.php");
                exit();
            } else echo "<script>alert(\"Adresse email ou mot de passe incorrect\")</script>";
        } else echo "<script>alert(\"Adresse email ou mot de passe incorrect\")</script>";
    } else echo "<script>alert(\"Veuillez remplir tous les champs\")</script>";
}

function getAddress()
{
    $connect = connectDB();

    $query = $connect->prepare("SELECT * FROM adresses WHERE id_client = ?");
    $query->execute(array($_SESSION['id']));
    return $query->fetch();
}

function changeAddress($id)
{
    $connect = connectDB();

    $query = $connect->prepare("UPDATE adresses SET adresse = :adresse, code_postal = :code_postal, ville = :ville WHERE id = :id");
    $query->execute(array(
        'adresse' => $_POST['newAddress'],
        'code_postal' => $_POST['newZip'],
        'ville' => $_POST['newCity'],
        'id' => $id
    ));

    $_SESSION['adresse'] = $id;

    echo "<script>alert(\"Adresse modifiée\")</script>";
}

function changeProfile()
{
    $connect = connectDB();

    $query = $connect->prepare("UPDATE clients SET nom = :nom, prenom = :prenom, email = :email WHERE id = :id");
    $query->execute(array(
        'nom' => $_POST['newLastname'],
        'prenom' => $_POST['newFirstname'],
        'email' => $_POST['newEmail'],
        'id' => $_SESSION['id']
    ));

    $_SESSION['email'] = $_POST['newEmail'];
    $_SESSION['id'] = $_SESSION['id'];
    $_SESSION['prenom'] = $_POST['newFirstname'];
    $_SESSION['nom'] = $_POST['newLastname'];

    echo "<script>alert(\"Informations modifiées\")</script>";
}

function changePassword()
{
    $connect = connectDB();

    $id = $_SESSION['id'];
    $password = $_POST['lastPassword'];
    $mdp = $_POST['newPassword'];

    $query = $connect->prepare("SELECT * FROM clients WHERE id = $id");
    $query->execute(array());
    $currentUser = $query->fetch();

    $verifyPassword = password_verify($password, $currentUser['mot_de_passe']);

    if ($verifyPassword) {
        if (checkPassword($mdp)) {
            $mdp_secu = password_hash($mdp, PASSWORD_BCRYPT);

            $query = $connect->prepare("UPDATE clients SET mot_de_passe = :mot_de_passe WHERE id = :id");
            $query->execute(array(
                'mot_de_passe' => $mdp_secu,
                'id' => $_SESSION['id']
            ));

            echo "<script>alert(\"Mot de passe modifié\")</script>";

            header("Location: connexion.php");
            exit();
        } else echo "<script>alert(\"Nouveau mot de passe invalide \")</script>";
    } else echo "<script>alert(\"Ancien mot de passe incorrect\")</script>";
}

function deconnexion()
{
    if (isset($_POST['deconnexion'])) {
        if (isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        session_destroy();
        unset($_session['id']);
        header("Location: index.php");
    }
}

// Gestion des commandes

function orderNumber()
{
    $randomNumber = random_int(0000000, 9999999);
    return $randomNumber;
}

function createOrder($numero, $produits)
{
    $connect = connectDB();

    date_default_timezone_set('Europe/Paris');
    $date = date('m/d/Y h:i:s a', time());

    $id = $_SESSION['id'];
    $prix = totalWithTaxes();

    if (!empty($date) && !empty($prix) && !empty($numero) && !empty($id)) {
        $query = $connect->prepare("INSERT INTO commandes (id_client,numero,date_commande,prix) VALUES(:id_client, :numero, :date_commande, :prix)");
        $query->execute(array(
            'id_client' => $id,
            'prix' => htmlspecialchars($prix),
            'numero' => htmlspecialchars($numero),
            'date_commande' => $date,
        ));

        $id_order = $connect->lastInsertId();
        $query = $connect->prepare("INSERT INTO commande_article (id_commande,id_article,quantite) VALUES(:id_commande, :id_article, :quantite)");

        foreach ($produits as $article) {
            $query->execute(array(
                'id_commande' => $id_order,
                'id_article' => $article['id'],
                'quantite' => $article['quantity'],
            ));
        }

        $stock = $article['stock'] - $article['quantity'];

        $query = $connect->prepare("UPDATE articles SET stock = :stock WHERE id = :id");
        $query->execute(array(
            'id' => $article['id'],
            'stock' => $stock,
        ));

        header("Location: profil.php");
    }
}

function listOrders()
{
    $connect = connectDB();

    $query = $connect->prepare("SELECT * FROM commandes WHERE id_client = ? ORDER BY id DESC");
    $query->execute(array($_SESSION['id']));
    $orders = $query->fetchAll();

    if (empty($orders)) {
        echo "<h4>Pas encore de commande passée</h4>";
    } else {
        echo "<tr class=\"list-group-item\">
        <th>Numéro de commande</th>
        <th>Date de commande</th>
        <th>Prix</th>
        </tr>";
        foreach ($orders as $clientOrder) {
            echo "<tr class=\"list-group-item\"><td>" . $clientOrder['numero'] . "</td><td>" .  date("d M Y à G:i", strtotime($clientOrder['date_commande'])) . "</td><td>" . $clientOrder['prix'] . "€ </td><td><a href=\"detailcommandes.php?&id=" . $clientOrder['id'] . " \"class=\"btn btn-outline-success\">Voir</a></td></tr>";
        }
    }
}

function getOrderFromId($id)
{
    $connect = connectDB();
    $query = $connect->prepare("SELECT * FROM commandes WHERE id = ?");
    $query->execute(array($id));
    return $query->fetch();
}

function getArticlesFromOrder($id)
{
    $connect = connectDB();
    $query = $connect->prepare("SELECT * FROM commande_article ca INNER JOIN articles a ON ca.id_article = a.id WHERE id_commande = ?");
    $query->execute(array($id));
    $articleList = $query->fetchAll();
    return $articleList;
}
