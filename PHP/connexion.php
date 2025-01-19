<?php
session_start();
require '../PHP/connectBDD.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['password'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "SELECT id_users, nom, prenom, email FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['id'] = $user['id_users'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['email'] = $user['email'];

            if (isset($_POST['souvenir'])) {
                setcookie("id", $_SESSION['id'], time() + (86400 * 30), '/');
                setcookie("nom", $_SESSION['nom'], time() + (86400 * 30), '/');
                setcookie("prenom", $_SESSION['prenom'], time() + (86400 * 30), '/');
                setcookie("email", $_SESSION['email'], time() + (86400 * 30), '/');
            }

            header("Location: ../index.php");
            exit;
        } else {
            header("Location: ../connexion.html?error=1");
            exit;
        }

        $stmt->close();
    } else {
        echo "Erreur de préparation de la requête.";
    }
}

$conn->close();
?>
