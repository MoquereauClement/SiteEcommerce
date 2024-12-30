<?php

include '../composant/connect.php';

session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

if(isset($_POST['submit'])){
    $name = $_POST['name']; 
    $name = filter_var($name,FILTER_SANITIZE_STRING);
    $password = sha1($_POST['password']); 
    $password = filter_var($password,FILTER_SANITIZE_STRING);
   
    $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
    $select_admin->execute([$name,$password]);

    if ($select_admin->rowCount() > 0){
        $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
        $_SESSION['admin_id'] = $fetch_admin_id['id'];
        header('Location: dashbord.php');
    }else{
        $message[]='Incorrect username or password!';
    }
}

// Ajout d'un nouvel administrateur avec le nom d'utilisateur "admin" et le mot de passe "admin"
//$insert_admin = $conn->prepare("INSERT INTO admins (name, password) VALUES (?, ?)");
//$insert_admin->execute(["admin", sha1("admin")]);
?>

<!Doctype html>
<html lang="en">

    <head>
        <meta charset="Utf_8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name ="viewport" content="width=device-width,initial-scale=1.0">
        <title>login</title>

        <!--font awesome cdn link -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <!--custom css file link-->
        
    </head>
    <body>

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

    <!--admin login form section start-->
    <section class="form-container">
        <form action="" method="post">
            <h3>Login Now</h3>
            <p>Default username=<span>admin </span> & password = <span>admin</span></p>
            <input type="text" name="name" maxlength="20" required placeholder="Enter your username" class="box" oninput="this.value=this.value.replace(/\s/g,'')" >
            <input type="password" name="password" maxlength="20" required placeholder="Enter your password" class="box" oninput="this.value=this.value.replace(/\s/g,'')" >
            <input type="submit" value="Login Now" name="submit" class="btn">
        </form>
    </section>
    <!--admin login form section end-->
    </body>
    <style>
        /* Global Styles */
body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  margin: 0;
  padding: 0;
}

.form-container {
  width: 100%;
  max-width: 400px;
  margin: 100px auto;
  background-color: #fff;
  padding: 30px;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.form-container h3 {
  text-align: center;
  font-size: 24px;
  color: #333;
  margin-bottom: 20px;
}

.form-container p {
  text-align: center;
  font-size: 14px;
  color: #666;
  margin-bottom: 30px;
}

.form-container .box {
  width: 100%;
  padding: 12px;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 16px;
  color: #333;
  transition: border-color 0.3s ease;
}

.form-container .box:focus {
  outline: none;
  border-color: #4CAF50;
}

.form-container .btn {
  width: 100%;
  padding: 12px;
  background-color: #1565c0;
  color: white;
  border: none;
  border-radius: 6px;
  font-size: 18px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.form-container .btn:hover {
  background-color: #004ba0;
}

.message {
  background-color: #ffeb3b;
  padding: 10px;
  margin-bottom: 20px;
  border-radius: 5px;
  text-align: center;
  color: #333;
  font-size: 14px;
}

.message i {
  cursor: pointer;
  color: #333;
  font-size: 18px;
  margin-left: 10px;
}

/* Media Query for Mobile */
@media (max-width: 480px) {
  .form-container {
    width: 90%;
    padding: 20px;
  }

  .form-container h3 {
    font-size: 22px;
  }

  .form-container p {
    font-size: 12px;
  }
}

    </style>
</html>
