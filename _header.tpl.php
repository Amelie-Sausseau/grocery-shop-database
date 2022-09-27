<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/d659d91cfe.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css">
  <title>Epicerie en ligne</title>
  <script>
    const myModal = document.getElementById('myModal')
    const myInput = document.getElementById('myInput')

    myModal.addEventListener('shown.bs.modal', () => {
      myInput.focus()
    })
  </script>
</head>

<?php
setlocale(LC_TIME, 'fr_FR.utf8', 'fra');

if (isset($_POST['deconnexion'])) {
  session_destroy();
  unset($_session['id']);
  header("Location: index.php");
}
?>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a href="index.php"><img class="navbar-brand" src="images/Fruits & légumes (400 × 200 px) (200 × 150 px).png"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link <?php if (basename($_SERVER['SCRIPT_NAME']) == 'index.php') {
                                  echo "active";
                                } ?>" aria-current="page" href="index.php">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if (basename($_SERVER['SCRIPT_NAME']) == "gammes.php") {
                                  echo "active";
                                } ?>" href="gammes.php">Gammes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if (basename($_SERVER['SCRIPT_NAME']) == "panier.php") {
                                  echo "active";
                                } ?>" href="panier.php"><?= navbarCart() ?></a>
          </li>
        </ul>

        <div class="d-flex btn-user">
          <?php if (!isset($_SESSION['id'])) {
            echo "<a class=\"btn btn-outline-light\" type=\"submit\" href=\"connexion.php\">Connexion</a>";
          } ?>
          <?php if (isset($_SESSION['id'])) {
            echo "<a class=\"btn btn-outline-light\" type=\"submit\" href=\"profil.php\">Mon compte</a>";
          } ?>
          <?php if (isset($_SESSION['id'])) {
            echo
            "<form action=\"profil.php\" method=\"post\" class=\"my-auto\">
        <input type=\"hidden\" name=\"deconnexion\">
        <input class=\"btn btn-outline-light\" type=\"submit\" value=\"Déconnexion\">
        </form>";
          } ?>
          <?php if (!isset($_SESSION['id'])) {
            echo "<a class=\"btn btn-outline-light\" type=\"submit\" href=\"inscription.php\">Inscription</a>";
          } ?>
        </div>
      </div>
    </div>
  </nav>