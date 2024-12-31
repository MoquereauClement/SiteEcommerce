<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "site";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id_users, nom, prenom, email FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

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
}

$conn->close();
