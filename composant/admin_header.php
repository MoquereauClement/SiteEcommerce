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
    
    
</head>

<body class="no-bg">
    <header class="header">
        <section class="flex">
            <a href="dashbord.php" class="logo">Admin<span>Panel</span></a>
            <nav class="navbar">
                <a href="dashbord.php">Home</a>
                <a href="Products.php">Products</a>
              
                <a href="admin_accounts.php">Admins</a>
                <a href="user_accounts.php">Users</a>
                
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

            
        </section>
    </header>
    
    
</body>
<style>
    /* Global Styles */
body {
  font-family: Arial, sans-serif;
  background-color: #f8f8f8;
  margin: 0;
  padding: 0;
}

header {
  background-color: #87CEEB;
  color: white;
  padding: 15px 0;
}

header .flex {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 20px;
}

header .logo {
  font-size: 24px;
  font-weight: bold;
  color: #fff;
  text-decoration: none;
}

header .logo span {
  color: #f0a500;
}

header .navbar a {
  color: white;
  text-decoration: none;
  margin: 0 15px;
  font-size: 16px;
  transition: color 0.3s ease;
}

header .navbar a:hover {
  color: #f0a500;
}

header .dropdown {
  position: relative;
  display: inline-block;
}

header .dropbtn {
  background-color: #333;
  color: white;
  padding: 10px 20px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

header .dropbtn:hover {
  background-color: #444;
}

header .dropdown-content {
  display: none;
  position: absolute;
  background-color: #333;
  min-width: 160px;
  box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
  z-index: 1;
}

header .dropdown-content a {
  color: white;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

header .dropdown-content a:hover {
  background-color: #f0a500;
}

header .dropdown:hover .dropdown-content {
  display: block;
}

header .icons {
  display: flex;
  align-items: center;
}

header .icons .fas {
  font-size: 24px;
  color: white;
  margin-left: 20px;
  cursor: pointer;
}

header .icons .fas:hover {
  color: #f0a500;
}

.message {
  background-color: #f44336;
  color: white;
  padding: 10px;
  margin: 20px 0;
  border-radius: 5px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.message span {
  font-size: 16px;
}

.message i {
  cursor: pointer;
  font-size: 20px;
}

.message i:hover {
  color: #ccc;
}

/* Media Queries for Responsiveness */
@media (max-width: 768px) {
  header .navbar a {
    font-size: 14px;
    margin: 0 10px;
  }

  header .dropdown-content {
    min-width: 140px;
  }

  header .icons .fas {
    font-size: 20px;
  }
}

    </style>
   
</html><?php
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

            
        </section>
    </header>
    
    
</body>
<style>
    /* Global Styles */
body {
  font-family: Arial, sans-serif;
  background-color: #f8f8f8;
  margin: 0;
  padding: 0;
}

header {
  background-color: #87CEEB;
  color: white;
  padding: 15px 0;
}

header .flex {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 20px;
}

header .logo {
  font-size: 24px;
  font-weight: bold;
  color: #fff;
  text-decoration: none;
}

header .logo span {
  color: #f0a500;
}

header .navbar a {
  color: white;
  text-decoration: none;
  margin: 0 15px;
  font-size: 16px;
  transition: color 0.3s ease;
}

header .navbar a:hover {
  color: #f0a500;
}

header .dropdown {
  position: relative;
  display: inline-block;
}

header .dropbtn {
  background-color: #333;
  color: white;
  padding: 10px 20px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

header .dropbtn:hover {
  background-color: #444;
}

header .dropdown-content {
  display: none;
  position: absolute;
  background-color: #333;
  min-width: 160px;
  box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
  z-index: 1;
}

header .dropdown-content a {
  color: white;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

header .dropdown-content a:hover {
  background-color: #f0a500;
}

header .dropdown:hover .dropdown-content {
  display: block;
}

header .icons {
  display: flex;
  align-items: center;
}

header .icons .fas {
  font-size: 24px;
  color: white;
  margin-left: 20px;
  cursor: pointer;
}

header .icons .fas:hover {
  color: #f0a500;
}

.message {
  background-color: #f44336;
  color: white;
  padding: 10px;
  margin: 20px 0;
  border-radius: 5px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.message span {
  font-size: 16px;
}

.message i {
  cursor: pointer;
  font-size: 20px;
}

.message i:hover {
  color: #ccc;
}

/* Media Queries for Responsiveness */
@media (max-width: 768px) {
  header .navbar a {
    font-size: 14px;
    margin: 0 10px;
  }

  header .dropdown-content {
    min-width: 140px;
  }

  header .icons .fas {
    font-size: 20px;
  }
}

    </style>
   
</html>
