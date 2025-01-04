<?php
$host_name = 'localhost';
$db_name = 'site';
$user_name = 'root';
$user_password = '';

$conn = new PDO("mysql:host=$host_name;dbname=$db_name", $user_name, $user_password);
?>
