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
        <link rel="stylesheet" href="../css/admin_style.css">
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
</html>