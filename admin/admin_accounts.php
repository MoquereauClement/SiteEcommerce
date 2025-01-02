<?php
include '../composant/connect.php';

session_start();
if(!isset($_SESSION['admin_id'])){
    header('location:admin_login.php');
}
$admin_id = $_SESSION['admin_id'];

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_admin = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
    $delete_admin->execute([$delete_id]);
    header('location:admin_accounts.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin accounts </title>

    <!--font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!--custom css file link-->
    
</head>
<body>    
    <?php include '../composant/admin_header.php'; ?>
    <!-- admin account section starts -->
    <br><section class="accounts">
        <h1 class="heading">admins accounts</h1>
        <div class="box-container">
            <div class="box">
                <p>register new admin</p>
                <a href="register_admin.php" class="option-btn">register</a>
            </div>
            <?php
            $select_account = $conn->prepare("SELECT * FROM `admins`");
            $select_account->execute();
            if($select_account->rowCount() > 0) {
                while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <div class="box">
                        <p> admin id : <span><?= $fetch_accounts['id'];?></span> </p>
                        <p> username : <span><?= $fetch_accounts['Name'];?></span> </p>
                        <div class="flex-btn">
                            <?php
                            if($fetch_accounts['id'] == $admin_id){
                                echo '<a href="update_profile.php" class="option-btn">update</a>';
                            }
                            ?>
                            <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn"
                               onclick="return confirm('delete this account?')">delete</a>
                        </div>
                    </div>
                    <?php
                }
            }else{
                echo '<p class="empty">no accounts available </p>';
            }
            ?>
        </div>
    </section>
    <!-- admin account section ends -->
    <!-- custom js file link -->
    <script src="../js/admin_script.js"></script>

</body>
<style>
    /* Global Styles */
body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  margin: 0;
  padding: 0;
}

.accounts {
  width: 90%;
  max-width: 1200px;
  margin: 30px auto;
  background: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.accounts .heading {
  text-align: center;
  font-size: 30px;
  margin-bottom: 20px;
  color: #333;
}

.box-container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: space-between;
}

.box {
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 20px;
  width: 23%;
  text-align: center;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.box p {
  font-size: 16px;
  color: #666;
  margin-bottom: 10px;
}

.box span {
  font-weight: bold;
  color: #333;
}

.box .option-btn,
.box .delete-btn {
  padding: 8px 16px;
  font-size: 14px;
  text-decoration: none;
  border-radius: 5px;
  margin-top: 10px;
  display: inline-block;
  width: 100%;
  text-align: center;
  transition: background-color 0.3s ease;
}

.box .option-btn {
  background-color: #4CAF50;
  color: white;
}

.box .option-btn:hover {
  background-color: #45a049;
}

.box .delete-btn {
  background-color: #f44336;
  color: white;
}

.box .delete-btn:hover {
  background-color: #d32f2f;
}

.box .flex-btn {
  display: flex;
  justify-content: space-between;
}

.empty {
  font-size: 16px;
  color: #999;
  text-align: center;
  margin-top: 20px;
}

/* Media Query for Mobile */
@media (max-width: 768px) {
  .box {
    width: 48%;
  }
}

@media (max-width: 480px) {
  .box {
    width: 100%;
  }
  .accounts {
    width: 95%;
    padding: 15px;
  }
}

</style>
</html>
