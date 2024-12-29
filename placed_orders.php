<?php
include '../composant/connect.php';

session_start();
if(!isset($_SESSION['admin_id'])){
    header('location:admin_login.php');
    exit();
}

$admin_id = $_SESSION['admin_id'];

if(isset($_POST['update_payment'])){
    $order_id = $_POST['order_id'];
    $payment_status = isset($_POST['payment_status']) ? $_POST['payment_status'] : ""; 
    $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
    $update_status->execute([$payment_status, $order_id]);
    $message[] = 'Payment status updated!';
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
    $delete_order->execute([$delete_id]);
    header('location:placed_orders.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placed Orders</title>

    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS file link-->
    <link rel="stylesheet" href="../css/admin_style.css">
    <style>
        /* Styles for Placed Orders section */
        .placed-orders {
  margin: 50px auto;
  max-width: 900px;
  padding: 0 20px;
}

.heading {
  font-size: 30px;
  margin-bottom: 30px;
}

.box {
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  margin-bottom: 20px;
  padding: 20px;
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  grid-template-rows: repeat(5, auto);
  grid-gap: 10px;
}

.box p {
  font-size: 18px;
  margin-bottom: 10px;
  display: flex;
  justify-content: space-between;
  align-items: center; /* ajout d'une propriété pour centrer verticalement les éléments de la ligne */
}

.box p span {
  font-weight: bold;
}

.drop-down {
  margin-right: 10px;
  padding: 5px;
  font-size: 16px;
  transition: background-color 0.3s ease; /* ajout d'une transition sur la couleur de fond */
}

.flex_btn {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.btn {
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  font-size: 16px;
  cursor: pointer;
  margin-right: 10px; /* ajout d'une marge pour l'espacement entre les boutons */
  transition: background-color 0.3s ease; /* ajout d'une transition sur la couleur de fond */
}

.btn:hover {
  background-color: #3e8e41; /* couleur de fond au survol */
}

.delete-btn {
  background-color: #f44336;
  border: none;
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease; /* ajout d'une transition sur la couleur de fond */
}

.delete-btn:hover {
  background-color: #c62828; /* couleur de fond au survol */
}

.empty {
  font-size: 20px;
  text-align: center;
  margin-top: 50px;
}

        </style>
</head>
<body>
    <?php include '../composant/admin_header.php'; ?>

    <!-- Placed Orders section starts -->
    <section class="placed-orders">
        <h1 class="heading">Placed Orders</h1>
        <?php
        $select_orders = $conn->prepare("SELECT * FROM `orders`");
        $select_orders->execute();
        if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
        ?>
        <div class="box">
            <p>User ID :<span><?= $fetch_orders['user_id'];?></span></p>
            <p> Name :<span><?= $fetch_orders['Name'] ;?></span></p>           
             <p>Email :<span><?= $fetch_orders['email'];?></span></p>
            <p>Number :<span><?= $fetch_orders['number'];?></span></p>
            <p> Address : <span><?= $fetch_orders['adress'] ;?></span></p>
            <p>Total Products : <span><?= $fetch_orders['total_products'];?></span></p>
            <p>Total Price : <span><?= $fetch_orders['total_price'];?>/-</span></p></br>
            <p> Payment Method : <span><?= $fetch_orders['payment_status'];?></span></p>
            <form action="" method="post">
                <input type="hidden" name="order_id" value="<?= $fetch_orders['id'];?>">
                <select name="payment_status" class="drop-down">
                    <option value="<?= $fetch_orders['payment_status'];?>" selected disabled><?= $fetch_orders['payment_status'];?></option>
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
                <div class="flex_btn">
    <input type="submit" value="update" class="btn" name="update_payment">
    <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
</div>
</form>


</div>
<?php
 }
}else{
    echo'<p class="empty">no orders placed yet!</p>';

}


?>
</section>



    <!--  placed orders section ends -->