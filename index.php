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
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "site";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La connexion a échoué: " . $conn->connect_error);
    }
    ?>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/pageprincipale.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Site Web</title>
</head>

<body>
    <header>
        <a href='index.php'><img id='logo' src='IMG/logo.png' alt='Image de VenteExpress'></a>
        <h2>VenteExpress</h2>
        <div>
            <a href="connexion.html"><img id='connexion' src='IMG/connexion.png' alt='Image de connexion'></a>
            <img id='panier' src='IMG/cartnoir.png' alt='Image de panier'>
        </div>
    </header>
    <?php
    echo "<h1>Bienvenue $prenom $nom, voici les produits que vous avez consulté recemment :</h1>";
        
    ?>
    <div id="produits-container">
        <?php
        // Ajouter la colonne description dans la requête SQL
        $sql = "SELECT id_article, nom, prix, image, description FROM articles";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Inclure la description dans l'appel de la fonction openPopup
                echo "<div class='produits' onclick='openPopup(" . $row["id_article"] . ", \"" . htmlspecialchars($row["nom"]) . "\", \"" .
                    htmlspecialchars($row["prix"]) . "\", \"" . htmlspecialchars($row["image"]) . "\", \"" . htmlspecialchars($row["description"]) . "\")'>";
                echo "<p class='nom'>" . $row["nom"] . "</p>";
                echo "<img class='imageProduit' src='" . $row["image"] . "' alt='Image de " . $row["nom"] . "'>";
                echo "<p class='prix'>" . $row["prix"] . "€</p></div>";
            }
        } else {
            echo "0 résultats";
        }
        ?>
    </div>


    <div id="popup">
        <div id="popup-content">
            <div id="ligne1">
                <h1 id="popup-title">Nom du Produit</h1><br>
                <span id="close-popup">&times;</span>
            </div>
            <div id="ligne2">
                <img id="popup-image" src="" alt="Image du produit">
                <div id="popup-details">
                    <h2>Description:</h2>
                    <p id="popup-description"></p>
                    <p id="popup-price"></p><br><br>
                    <button id="popup-button">Ajouter au panier</button>
                </div>
            </div>
        </div>
    </div>

    <script src="JS/popUpPagePrincipale.js"></script>
</body>

</html>