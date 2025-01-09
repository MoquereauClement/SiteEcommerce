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
    
    // Supprimer le panier associé
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart->execute([$delet_id]);

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
   
</head>


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
                        <p> User ID: <span><?= $fetch_accounts['id_users']; ?></span> </p>
                        <p> Username: <span><?= $fetch_accounts['nom']; ?></span> </p>
                        <a href="user_accounts.php?delete=<?= $fetch_accounts['id_users']; ?>" class="delete-btn" onclick="return confirm('Delete this account?');">Delete</a>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">No accounts available</p>';
            }
            ?>
        </div>
    </section>
   
</body>
<style>
  
body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  margin: 0;
  padding: 0;
}

h1 {
  text-align: center;
  margin-top: 20px;
  font-size: 28px;
  color: #333;
}

/* Container for User Accounts */
.box-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  margin: 20px;
}

.box {
  background-color: #fff;
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 20px;
  margin: 10px;
  width: 48%;
  box-sizing: border-box;
  transition: box-shadow 0.3s ease;
}

.box:hover {
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.box p {
  font-size: 16px;
  color: #333;
}

.box span {
  font-weight: bold;
  color: #555;
}

.delete-btn {
  display: inline-block;
  background-color: #f44336;
  color: white;
  padding: 8px 15px;
  border-radius: 5px;
  text-decoration: none;
  font-size: 14px;
  margin-top: 10px;
  transition: background-color 0.3s ease;
}

.delete-btn:hover {
  background-color: #d32f2f;
}

.empty {
  text-align: center;
  font-size: 18px;
  color: #777;
}

/* Media Query for Mobile */
@media (max-width: 768px) {
  .box-container {
    flex-direction: column;
    align-items: center;
  }

  .box {
    width: 90%;
  }
}

  </style>
</html>
