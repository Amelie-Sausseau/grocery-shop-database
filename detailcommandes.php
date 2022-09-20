<?php
require '_footer.tpl.php';
require 'functions.php';
session_start();
?>

<?php
//On récupère l'id de la commande dans l'url
$id = $_GET['id'];
//On retrouve la commande grâce à cet id (commande)
$order = getOrderFromId($id);
//On retrouve le détail de cette commande (commande_article)
$infos = getInfosFromOrder($id);

?>

<header>
    <?php require '_header.tpl.php'; ?>
</header>

<div class="container">
    <h3>Commande n°<?= $order['numero'] ?> du <?= strftime("%d/%m/%y", strtotime($order['date_commande'])) ?></h3>

    <div class="table-details">
    <table>
        <tr class="list-group-item">
            <th></th>
            <th>Produit</th>
            <th>Description</th>
            <th>Quantité</th>
            <th>Prix</th>
        </tr>
        <?php foreach ($infos as $info) {
            //On retrouve chaque produit grâce à leur id (articles)
            $article = getArticleFromId($info['id_article']);
            $price = $info['quantite'] * $article['prix'];
            echo "<tr class=\"list-group-item\"><td><img class=\"table-img\" width=\"100px\" src=\"" . $article['image'] . "\"></td><td>" . $article['nom'] . "</td><td>" . $article['description'] . "</td><td>" . $info['quantite'] . "</td><td>" . $price . "€</td></tr>";}
        ?>
    </table>
    </div>
</div>