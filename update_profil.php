<?php
include '../composant/connect.php';

session_start();
if(!isset($_SESSION['admin_id'])){
    header('location:admin_login.php');
    exit();
}   

$admin_id = $_SESSION['admin_id'];

$select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
$select_profile->execute([$admin_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $select_old_password = $conn->prepare("SELECT password FROM `admins` WHERE id = ?");
    $select_old_password->execute([$admin_id]);
    $fetch_prev_password = $select_old_password->fetch(PDO::FETCH_ASSOC);
    $prev_password = $fetch_prev_password['password'];

    if(empty($name)){
        $message[] = 'Please enter a username.';
    } elseif(!preg_match('/^[a-zA-Z0-9]+$/', $name)){
        $message[] = 'Username can only contain letters and numbers.';
    }

    if(empty($old_password)){
        $message[] = 'Please enter your old password.';
    } elseif(!password_verify($old_password, $prev_password)){
        $message[] = 'Old password is incorrect.';
    }

    if(empty($new_password)){
        $message[] = 'Please enter a new password.';
    } elseif(!preg_match('/^(?=.[a-z])(?=.[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $new_password)){
        $message[] = 'Password must be at least 8 characters and contain at least one lowercase letter, one uppercase letter, and one digit.';
    }

    if($new_password !== $confirm_password){
        $message[] = 'New password and confirmation password do not match.';
    }

    if(empty($message)){
        $update_profile = $conn->prepare("UPDATE admins SET name = ? WHERE id = ?");
        $update_profile->execute([$name, $admin_id]);

        if(!empty($new_password)){
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $update_password = $conn->prepare("UPDATE admins SET password = ? WHERE id = ?");
            $update_password->execute([$new_password_hash, $admin_id]);
        }

        $message[] = 'Profile updated successfully!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile update</title>

    <!--font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!--custom css file link-->
    
</head>
<body>
<?php include '../composant/admin_header.php'?>

   
    <section class="form-container">
    <form action="" method="post">
        <h3>update profile</h3>
        
        <input type="text" name="name" maxlength="10" required placeholder="Enter your username" class="box" oninput="this.value=this.value.replace(/\s/g,'')" value="<?= isset($fetch_profile['name']) ? $fetch_profile['name'] : '' ?>" >
        <input type="password" name="old_password" maxlength="20" required placeholder="Enter your old password" class="box" oninput="this.value=this.value.replace(/\s/g,'')" >
        <input type="password" name="new_password" maxlength="20" required placeholder="Enter your new password" class="box" oninput="this.value=this.value.replace(/\s/g,'')" >
        <input type="password" name="confirm_password" maxlength="20" required placeholder="confirm your new password" class="box" oninput="this.value=this.value.replace(/\s/g,'')" >

        <input type="submit" value="update Now" name="submit" class="btn">
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
  max-width: 450px;
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
</html>
