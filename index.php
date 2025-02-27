<?php
session_start();

$inactive = 1800;


if (!isset($_SESSION['id']) && isset($_COOKIE['id']) && isset($_COOKIE['nom']) && isset($_COOKIE['prenom']) && isset($_COOKIE['email'])) {
    $_SESSION['id'] = $_COOKIE['id'];
    $_SESSION['nom'] = $_COOKIE['nom'];
    $_SESSION['prenom'] = $_COOKIE['prenom'];
    $_SESSION['email'] = $_COOKIE['email'];
}

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $inactive && !isset($_COOKIE['id'])) {
    session_unset();
    session_destroy();
    header('Location: connexion.html?deconnexion=1');
    exit;
}
$_SESSION['last_activity'] = time();

if (isset($_SESSION['id']) && isset($_SESSION['nom']) && isset($_SESSION['prenom']) && isset($_SESSION['email'])) {
    $id = $_SESSION['id'];
    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
    $email = $_SESSION['email'];
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    require 'PHP/connectBDD.php'
    ?>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/pagePrincipale.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vente Express</title>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
</head>

<body>
    <header>
        <a href='index.php'><img id='logo' src='IMG/logo.png' alt='Image de VenteExpress'></a>
        <h2>VenteExpress</h2>
        <div>
            <form method="GET">
                <input type="text" name="search" placeholder="Rechercher un produit" id="recherche-bar">
                <input type="submit" id="recherche-bouton">
            </form>
            <?php
            if (isset($_SESSION['id'])) {
                echo "<a href='index.php?deconnexion=1'><img id='deconnexion' src='IMG/deconnexion.png' alt='Image de déconnexion'></a>";
                if (isset($_GET['deconnexion'])) {
                    setcookie("id", "", time() - 3600, "/");
                    setcookie("nom", "", time() - 3600, "/");
                    setcookie("prenom", "", time() - 3600, "/");
                    setcookie("email", "", time() - 3600, "/");
                    session_unset();
                    session_destroy();
                    header('Location: connexion.html');
                }
            } else {
                echo "<a href='connexion.html'><img id='connexion' src='IMG/connexion.png' alt='Image de connexion'></a>";
            }
            ?>
            <a href="panier.php"><img id='panier' src='IMG/cartnoir.png' alt='Image de panier'></a>
        </div>
    </header>

    <?php
    if (isset($_SESSION['id']) && isset($_SESSION['nom']) && isset($_SESSION['prenom']) && isset($_SESSION['email'])) {
        echo "<h1>Bienvenue $prenom $nom, voici les produits que vous avez consulté recemment :</h1>";
        echo "<div class='produits-container' id='productsrecent'>";
        if (!isset($_SESSION['array_recent_products'])) {
            $_SESSION['array_recent_products'] = array();
        }
        if (isset($_COOKIE['recent_product'])) {
            $id_article = $_COOKIE['recent_product'];
            if (!in_array($id_article, $_SESSION['array_recent_products'])) {
                if (count($_SESSION['array_recent_products']) >= 5) {
                    array_pop($_SESSION['array_recent_products']);
                }
                array_unshift($_SESSION['array_recent_products'], $id_article);
            } else {
                $key = array_search($id_article, $_SESSION['array_recent_products']);
                unset($_SESSION['array_recent_products'][$key]);
                array_unshift($_SESSION['array_recent_products'], $id_article);
            }
        }

        if (!empty($_SESSION['array_recent_products'])) {
            foreach ($_SESSION['array_recent_products'] as $id_article) {
                $sql_recent = "SELECT id_article, nom, prix, image, description FROM articles WHERE id_article = $id_article";
                $result_recent = $conn->query($sql_recent);
                if ($result_recent->num_rows > 0) {
                    while ($row_recent = $result_recent->fetch_assoc()) {
                        echo "<div class='produits'>";
                        echo "<p class='id_article'>" . $row_recent["id_article"] . "</p>";
                        echo "<p class='nom'>" . $row_recent["nom"] . "</p>";
                        echo "<img class='imageProduit' src='" . $row_recent["image"] . "' alt='Image de " . $row_recent["nom"] . "'>";
                        echo "<p class='description'>" . $row_recent["description"] . "</p>";
                        echo "<p class='prix'>" . $row_recent["prix"] . "€</p>";
                        echo "</div>";
                    }
                }
            }
        } else {
            echo "<h1>Aucun produit consulté récemment.</h1>";
        }
        echo "</div>";
    }
    ?>
    <?php
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $searchTerm = "%" . trim($_GET['search']) . "%"; // Term de recherche sécurisé
    
        // Préparer la requête SQL
        $sql = "SELECT id_article, nom, prix, image, description FROM articles WHERE nom LIKE ?";
        $stmt = $conn->prepare($sql);
    
        if ($stmt) {
            // Lier le paramètre
            $stmt->bind_param("s", $searchTerm);
            $stmt->execute();
            $result = $stmt->get_result();
    
            echo "<h1>Produits trouvés</h1>";
            echo "<div class='produits-container'>";
    
            // Afficher les produits trouvés
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='produits' onclick='cookieProduits(" . $row['id_article'] . ")'>";
                    echo "<p class='id_article'>" . $row["id_article"] . "</p>";
                    echo "<p class='nom'>" . htmlspecialchars($row["nom"]) . "</p>";
                    echo "<img class='imageProduit' src='" . htmlspecialchars($row["image"]) . "' alt='Image de " . htmlspecialchars($row["nom"]) . "'>";
                    echo "<p class='description'>" . htmlspecialchars($row["description"]) . "</p>";
                    echo "<p class='prix'>" . htmlspecialchars($row["prix"]) . "€</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>Aucun produit trouvé pour votre recherche.</p>";
            }
    
            echo "</div>"; // Fermer le container des produits
            $stmt->close();
        } else {
            echo "Erreur lors de la préparation de la requête.";
        }
    } else {
        // Si aucune recherche n'a été effectuée, afficher tous les produits
        echo "<h1>Produits</h1>";
        echo "<div class='produits-container'>";
    
        $sql = "SELECT id_article, nom, prix, image, description FROM articles";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='produits' onclick='cookieProduits(" . $row['id_article'] . ")'>";
                echo "<p class='id_article'>" . $row["id_article"] . "</p>";
                echo "<p class='nom'>" . htmlspecialchars($row["nom"]) . "</p>";
                echo "<img class='imageProduit' src='" . htmlspecialchars($row["image"]) . "' alt='Image de " . htmlspecialchars($row["nom"]) . "'>";
                echo "<p class='description'>" . htmlspecialchars($row["description"]) . "</p>";
                echo "<p class='prix'>" . htmlspecialchars($row["prix"]) . "€</p>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucun produit trouvé.</p>";
        }
    
        echo "</div>"; // Fermer le container des produits
    }
    ?>
    <?php
    if ((time() - $_SESSION['last_activity']) > $inactive) {
        session_unset();
        session_destroy();
        header('Location: connexion.html');
        exit;
    }
    ?>

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
                    <p id="popup-price"></p>
                    <form id="popup-form" action="PHP/panier.php" method="get">
                        <label for="quantite">Quantité:</label>
                        <input type="number" id="quantite" name="quantite" min="1" max="3" value="1">
                        <input type="number" id="id_article" name="id_article">
                        <input type="submit" id="submit-popup" value="Ajouter au panier">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="JS/PagePrincipale.js"></script>
</body>

</html>