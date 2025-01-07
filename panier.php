<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: connexion.html");
    exit;
}

$id = $_SESSION['id'];
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    require 'PHP/connectBDD.php'
    ?>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/panier.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vente Express</title>
</head>

<body>
    <header>
        <a href='index.php'><img id='logo' src='IMG/logo.png' alt='Image de VenteExpress'></a>
        <h2>VenteExpress</h2>
        <div>
            <a href="connexion.html"><img id='connexion' src='IMG/connexion.png' alt='Image de connexion'></a>
            <a href="panier.php"><img id='panier' src='IMG/cartnoir.png' alt='Image de panier'></a>
        </div>
    </header>
    <div id="articles-panier-container">
        <?php
        echo "<h1>Bienvenue $prenom $nom, voici les produits que vous dans votre panier :</h1>";
        $sql = "select articles.nom, articles.image, articles.prix, panier.quantite from panier, users, articles where panier.id_user = users.id_users AND panier.id_article = articles.id_article AND users.id_users ='$id';";
        $result = $conn->query($sql);
        $prixtotal = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $prix = 0;
                $prix += $row["prix"] * $row["quantite"];
                $prixtotal += $prix;
                echo "<div class='articles-panier'>";
                echo "<h3 class='nom'><img src='" . $row["image"] . "' alt='Image de " . $row["nom"] . "' id='image'>" . $row["nom"] . "</h3>";
                echo "<p class='prix'>" . $prix . "€</p>";
                echo "<p class='quantite'>Quantité: <span class='quantitenombre'>" . $row["quantite"] . "</span></p>";
                echo "<p class='close'>&times;</p>";
                echo "</div>";
            }
            echo "<div id='paiement'>";
            echo "<h1 id='total'>Total: $prixtotal €</h1>";
            echo "<button id='commander'>Aller au paiement</button>";
            echo "</div>";
        } else {
            echo "<h1>Votre panier est vide</h1>";
        }
        ?>

        <?php
        if (isset($_GET['nom']) && isset($_GET['quantite'])) {
            $nom = $_GET['nom'];
            $quantite = $_GET['quantite'];
            $sql = "DELETE panier FROM panier
            INNER JOIN users ON panier.id_user = users.id_users
            INNER JOIN articles ON panier.id_article = articles.id_article
            WHERE panier.id_user = '$id' AND articles.nom = '$nom' AND panier.quantite = '$quantite';";
            $result = $conn->query($sql);
            header("Location: " . $_SERVER['PHP_SELF']);
        }
        ?>
    </div>
    <script src="JS/panier.js"></script>
</body>