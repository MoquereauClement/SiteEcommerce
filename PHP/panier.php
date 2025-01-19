<?php
session_start();
require 'connectBDD.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../connexion.html");
    exit;
}
$id_user = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['quantite']) && isset($_GET['id_article'])) {
    $quantite = intval($_GET['quantite']);
    $id_article = intval($_GET['id_article']);

    $sql = "INSERT INTO panier (id_user, id_article, quantite) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("iii", $id_user, $id_article, $quantite);

        if ($stmt->execute()) {
            header("Location: ../index.php");
            exit;
        } else {
            echo "Erreur lors de l'insertion des données : " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Erreur lors de la préparation de la requête.";
    }
}

$conn->close();
?>
