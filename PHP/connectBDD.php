<?php
$servername = "localhost";
$username = "e2405490";
$password = "Mcy922gb";
$dbname = "e2405490";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn -> set_charset('utf8mb4');

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}
?>