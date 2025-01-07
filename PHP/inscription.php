<?php
require 'PHP/connectBDD.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        header("Location: ../inscription.html?error=1");
        exit;
    }
    $sql = "INSERT INTO users (email, nom, prenom, password)
        VALUES ('$email', '$nom', '$prenom', '$password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../connexion.html");
        exit;
    }
}
$conn->close();