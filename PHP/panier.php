<?php
session_start();
require 'PHP/connectBDD.php';
if(!isset($_SESSION['id'])){
    header("Location: ../connexion.html");
    exit;
}
$id_user = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['quantite']) && isset($_GET['id_article'])) {
    $quantite = $_GET['quantite'];
    $id_article = $_GET['id_article'];
    
    $sql = "INSERT INTO panier (id_user, id_article, quantite)
        VALUES ('$id_user', '$id_article', '$quantite')";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../index.php");
        exit();
    } else {
        
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}
