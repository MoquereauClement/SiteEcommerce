<?php
include '../composant/connect.php';

session_start();
if(!isset($_SESSION['admin_id'])){
    header('location:admin_login.php');
};
if(isset($_POST['submit'])){
    $name = $_POST['name']; 
    $name = filter_var($name,FILTER_SANITIZE_STRING);
    $password = sha1($_POST['password']); 
    $password = filter_var($password,FILTER_SANITIZE_STRING);
    $cpassword = sha1($_POST['cpassword']); 
    $cpassword = filter_var($cpassword,FILTER_SANITIZE_STRING);
   
    $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? ");
    $select_admin->execute([$name]);

    if ($select_admin->rowCount() > 0){
       $message[]='username already exists !';
    }else{
       if($password != $cpassword){
        $message[]='confirm password not matched !';
       }
       else{
        $insert_admin=$conn->preapre("insert into 'admins'(name,password) values(?,?)");
        $insert_admin->execute([$name,$cpassword]);
        $message[] = 'new admin registered !';
       }
    }
}
$admin_id = $_SESSION['admin_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!--font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!--custom css file link-->
    
</head>
<body>
    <?php include '../composant/admin_header.php'?>

  <!--  register admin section starts -->
  <section class="form-container">
        <form action="" method="post">
            <h3>register new</h3>
            <input type="text" name="name" maxlength="20" required placeholder="Enter your username" class="box" oninput="this.value=this.value.replace(/\s/g,'')" >
            <input type="password" name="password" maxlength="20" required placeholder="Enter your password" class="box" oninput="this.value=this.value.replace(/\s/g,'')" >
            <input type="password" name="cpassword" maxlength="20" required placeholder="confirm your password" class="box" oninput="this.value=this.value.replace(/\s/g,'')" >

            <input type="submit" value="register Now" name="submit" class="btn">
        </form>
    </section>

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
}

    </style>
