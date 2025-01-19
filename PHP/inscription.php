<?php
require 'PHP/connectBDD.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['password'])) {
    $email = trim($_POST['email']);
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            header("Location: ../inscription.html?error=1");
            exit;
        }
        $stmt->close();
    } else {
        echo "Erreur lors de la préparation de la requête.";
        exit;
    }

    $sql = "INSERT INTO users (email, nom, prenom, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssss", $email, $nom, $prenom, $password);

        if ($stmt->execute()) {
            header("Location: ../connexion.html");
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
