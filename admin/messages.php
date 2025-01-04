<?php
include '../composant/connect.php';

session_start();

if(!isset($_SESSION['admin_id'])){
    header('location:admin_login.php');
}

$admin_id = $_SESSION['admin_id'];

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
    $delete_message->execute([$delete_id]);
    header('location:messages.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>

    <!--font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!--custom css file link-->
    
</head>
<style>
    /* Style pour la section messages */

.messages {
    width: 40%;
    margin: 50px auto;
}

.messages .heading {
    font-size: 30px;
    text-align: center;
    margin-bottom: 30px;
}

.box-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.box {
    border: 1px solid #ccc;
    padding: 20px;
}

.box p {
    margin-bottom: 10px;
}

.box span {
    font-weight: bold;
}

.delete-btn {
    display: block;
    width: 25%;
    text-align: center;
    padding: 10px 0;
    background-color: #f44336;
    color: #fff;
    text-transform: uppercase;
    font-weight: bold;
    border: none;
    cursor: pointer;
}

.empty {
    text-align: center;
    font-size: 20px;
    margin-top: 50px;
}
</style>
<body>
    <?php include '../composant/admin_header.php' ?>
    <!-- messages section starts -->
    <section class="messages">
        <h1 class="heading">New Messages</h1>
        <div class="box-container">
            <?php
            $select_messages = $conn->prepare("SELECT * FROM `messages`");
            $select_messages->execute();
            if($select_messages->rowCount() > 0){
                while($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)){
            ?>
            <div class="box">
                <p> User ID: <span><?= htmlspecialchars($fetch_messages['user_id']);?></span></p>
                <p> Name: <span><?= htmlspecialchars($fetch_messages['name']);?></span></p>
                <p> Number: <span><?= htmlspecialchars($fetch_messages['number']);?></span></p>
                <p> Email: <span><?= isset($fetch_messages['Email']) ? htmlspecialchars($fetch_messages['Email']) : '';?></span></p>
                <p> Message: <span><?= htmlspecialchars($fetch_messages['message']);?></span></p>
                <a href="messages.php?delete=<?= $fetch_messages['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this message?');">Delete</a>
            </div>
            <?php
              }
            }else{
                echo '<p class="empty">You have no messages</p>';
            }
            ?>
        </div>
    </section>
    <!-- messages section ends -->
</body>
</html>
