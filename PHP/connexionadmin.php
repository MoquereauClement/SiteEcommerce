<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "site";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nom']) && isset($_POST['password'])) {
    $nom = $_POST['nom'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE name='$nom' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        header("Location: ../index.php");
        exit;
    } else {
        header("Location: ../connexionadmin.html?error=1");
        exit;
    }
}
$conn->close();
