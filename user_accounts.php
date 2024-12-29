<?php
include '../composant/connect.php';

session_start();
if (!isset($_SESSION['admin_id'])) {
    header('location:admin_login.php');
    exit();
}

$admin_id = $_SESSION['admin_id'];

if (isset($_GET['delete'])) {
    $delet_id = $_GET['delete'];

    // Supprimer l'utilisateur
    $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
    $delete_users->execute([$delet_id]);

    // Supprimer les commandes associées
    $delete_order = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
    $delete_order->execute([$delet_id]);

    // Supprimer le panier associé
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart->execute([$delet_id]);

    // Supprimer la liste de souhaits associée
    $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
    $delete_wishlist->execute([$delet_id]);

    // Supprimer les messages associés
    $delete_messages = $conn->prepare("DELETE FROM `messages` WHERE user_id = ?");
    $delete_messages->execute([$delet_id]);

    header('location:user_accounts.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Accounts</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<style>
/* Styles pour la section accounts */
.accounts {
  margin-top: 30px;
}

.heading {
  text-align: center;
  font-size: 24px;
  color: white;
  margin-bottom: 20px;
  text-transform: uppercase;
}

.box-container {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 15px;
}

.box {
  background-color: #f2f2f2;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 10px;
  color: #333;
  font-size: 14px;
  font-family: Arial, sans-serif;
}

.box p {
  margin: 0;
  margin-bottom: 10px;
}

.box p span {
  font-weight: bold;
}

.delete-btn {
  display: inline-block;
  padding: 5px 10px;
  background-color: #e53935;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-family: Arial, sans-serif;
  font-size: 14px;
  text-decoration: none;
}

.empty {
  text-align: center;
  margin-top: 20px;
  font-style: italic;
}
</style>

<body>
    <?php include '../composant/admin_header.php'; ?>

    <!-- User Accounts Section Starts -->
    <section class="accounts">
        <h1 class="heading">User Accounts</h1>

        <div class="box-container">
            <?php
            $select_account = $conn->prepare("SELECT * FROM `users`");
            $select_account->execute();
            if ($select_account->rowCount() > 0) {
                while ($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <div class="box">
                        <p> User ID: <span><?= $fetch_accounts['id']; ?></span> </p>
                        <p> Username: <span><?= $fetch_accounts['name']; ?></span> </p>
                        <a href="user_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('Delete this account?');">Delete</a>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">No accounts available</p>';
            }
            ?>
        </div>
    </section>
    <!-- User Accounts Section Ends -->

    <!-- Custom JS File Link -->
    <script src="../js/admin_script.js"></script>
</body>
</html>
