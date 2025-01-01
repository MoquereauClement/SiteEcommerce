<?php
include '../composant/connect.php';

session_start();
if (!isset($_SESSION['admin_id'])) {
    header('location:admin_login.php');
    exit();
}

$admin_id = $_SESSION['admin_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<?php include '../composant/admin_header.php'; ?>

<section class="dashboard">
    <h1 class="heading">Dashboard</h1>

    <div class="box-container">

        <div class="box">
            <?php 
                $select_products = $conn->prepare("SELECT * FROM products");
                $select_products->execute();
                $numbers_of_products = $select_products->rowCount();
            ?>
            <h3><?= $numbers_of_products; ?></h3>
            <p>Products added</p>
            <a href="products.php" class="btn">See products</a>
        </div>

        <div class="box">
            <?php
                $select_users = $conn->prepare("SELECT * FROM `users`");
                $select_users->execute();
                $numbers_of_users = $select_users->rowCount();
            ?>
            <h3><?= $numbers_of_users; ?></h3>
            <p>Users accounts</p>
            <a href="user_accounts.php" class="btn">See users</a>
        </div>

        <div class="box">
            <?php
                $select_admins = $conn->prepare("SELECT * FROM `admins`");
                $select_admins->execute();
                $numbers_of_admins = $select_admins->rowCount();
            ?>
            <h3><?= $numbers_of_admins; ?></h3>
            <p>Admins</p>
            <a href="admin_accounts.php" class="btn">See admins</a>
        </div>

        <div class="box">
            <?php
                $select_messages = $conn->prepare("SELECT * FROM `messages`");
                $select_messages->execute();
                $numbers_of_messages = $select_messages->rowCount();
            ?>
            <h3><?= $numbers_of_messages; ?></h3>
            <p>New messages</p>
            <a href="messages.php" class="btn">See messages</a>
        </div>

    </div>
</section>

<script src="../js/admin_script.js"></script>
</body>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f0f0f0;
        margin: 0;
        padding: 0;
    }
    .dashboard {
        padding: 20px;
        max-width: 1200px;
        margin: auto;
    }
    .dashboard .heading {
        font-size: 24px;
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }
    .box-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }
    .box {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        text-align: center;
        width: 300px;
    }
    .box h3 {
        font-size: 22px;
        color: #1565c0;
        margin: 10px 0;
    }
    .box p {
        font-size: 16px;
        color: #555;
    }
    .btn {
        display: inline-block;
        margin-top: 10px;
        padding: 10px 20px;
        background: #1565c0;
        color: #fff;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        font-size: 16px;
    }
    .btn:hover {
        background: #003c8f;
    }
</style>

</html>
