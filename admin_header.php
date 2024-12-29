<?php
    if(isset($message)){
        foreach($message as $message){
            echo'
        <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <!--font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!--custom css file link-->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body class="no-bg">
    <header class="header">
        <section class="flex">
            <a href="dashbord.php" class="logo">Admin<span>Panel</span></a>
            <nav class="navbar">
                <a href="dashbord.php">Home</a>
                <a href="Products.php">Products</a>
                <a href="Placed_orders.php">Orders</a>
                <a href="admin_accounts.php">Admins</a>
                <a href="user_accounts.php">Users</a>
                <a href="messages.php">Messages</a>
            </nav>

            <div class="dropdown">
              <button class="dropbtn"><i class="fas fa-user"></i> <?php echo isset($fetch_profile['name']) ? $fetch_profile['name'] : ''; ?></button>
              <div class="dropdown-content">
                <a href="update_profil.php"><i class="fas fa-user-cog"></i> Update profil</a>
                <a href="admin_login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                <a href="register_admin.php"><i class="fas fa-user-plus"></i> Register</a>
                <a href="../composant/admin_logout.php" onclick="return confirm('logout from this website')";><i class="fas fa-sign-out-alt"></i> Logout</a>
              </div>
            </div>

            <div class="icons">
                <div id="menu-btn" class="fas fa-bars"></div>
                <div id="user-btn" class="fas fa-user"></div>
            </div>
        </section>
    </header>
    
    <!--custom js file link -->
    <script src="../js/admin_script.js"></script>
</body>
</html>