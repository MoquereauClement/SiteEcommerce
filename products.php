<?php
include '../composant/connect.php';

session_start();
if (!isset($_SESSION['admin_id'])) {
    header('location:admin_login.php');
}

$admin_id = $_SESSION['admin_id'];

// Ajouter un nouveau produit
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);

    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);
    
    $image_01 = $_FILES['image_01']['name'];
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
    $image_01_size = $_FILES['image_01']['size'];
    $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
    $image_01_folder = '../uploaded_img/'.$image_01;

    $image_02 = $_FILES['image_02']['name'];
    $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
    $image_02_size = $_FILES['image_02']['size'];
    $image_02_tmp_name = $_FILES['image_02']['tmp_name'];
    $image_02_folder = '../uploaded_img/'.$image_02;

    $image_03 = $_FILES['image_03']['name'];
    $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
    $image_03_size = $_FILES['image_03']['size'];
    $image_03_tmp_name = $_FILES['image_03']['tmp_name'];
    $image_03_folder = '../uploaded_img/'.$image_03;


    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
    $select_products->execute([$name]);

    if ($select_products->rowCount() > 0) {
        $message[] = 'Product name already exists!';
    } else {
        if ($image_01_size > 2000000 || $image_02_size > 2000000 || $image_03_size > 2000000) {
            $message[] = 'Image size is too large';
        } else {
            move_uploaded_file($image_01_tmp_name, $image_01_folder);
            move_uploaded_file($image_02_tmp_name, $image_02_folder);
            move_uploaded_file($image_03_tmp_name, $image_03_folder);

            $insert_product = $conn->prepare("INSERT INTO `products` (name, details, price, image_01, image_02, image_03) VALUES (?,?,?,?,?,?)");
            $insert_product->execute([$name, $details, $price, $image_01, $image_02, $image_03]);

            $message[] = 'New product added!';
        }
    }
}

if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
  $delete_product_image->execute([$delete_id]);
  $fetch_deleted_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
  unlink('../uploaded_img/'.$fetch_deleted_image['image_01']);
  unlink('../uploaded_img/'.$fetch_deleted_image['image_02']);
  unlink('../uploaded_img/'.$fetch_deleted_image['image_03']);
  $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
  $delete_product->execute([$delete_id]);
  $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ? ");
  $delete_cart->execute([$delete_id]);
  $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ? ");
  $delete_wishlist->execute([$delete_id]);
  header('location:products.php');
}

                
            
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="style.css" rel="stylesheet">

    <!--font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!--custom css file link-->
    <link rel="stylesheet" href="../css/admin_style.css" >
    <style>
 
/* General Styles */
.add-products {
  max-width: 600px;
  margin: 0 auto;
  padding: 40px;
  background-color: #f7f7f7;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.add-products .heading {
  text-align: center;
  font-size: 28px;
  margin-bottom: 30px;
  color: #333;
  text-transform: uppercase;
  letter-spacing: 2px;
  font-weight: bold;
}

.add-products .flex {
  display: flex;
  flex-wrap: wrap;
  margin-bottom: 20px;
}

.add-products .inputBox {
  width: 100%;
  margin-bottom: 20px;
}

.add-products .inputBox span {
  display: block;
  font-size: 16px;
  margin-bottom: 10px;
  color: #666;
}

.add-products .box {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 16px;
  color: #333;
  transition: border-color 0.3s ease;
}

.add-products .box:focus {
  outline: none;
  border-color: #4CAF50;
}

.add-products .input {
  margin-bottom: 20px;
}

.add-products label {
  display: block;
  font-size: 16px;
  margin-bottom: 10px;
  color: #666;
}

.add-products textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 16px;
  color: #333;
  resize: vertical;
  transition: border-color 0.3s ease;
}

.add-products textarea:focus,
.add-products .box:focus {
  outline: none;
  border-color: #4CAF50;
}

.add-products .btn {
  display: inline-block;
  padding: 12px 20px;
  background-color: #1565c0;
  color: #fff;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 18px;
  transition: background-color 0.3s ease;
}

.add-products .btn:hover {
  background-color: #DD0000;
}

.add-products .btn-red {
  background-color: #e53935;
}

.add-products .btn-grey {
  background-color: #bdbdbd;
  color: #333;
}

.add-products p {
  font-size: 14px;
  color: #666;
}

.add-products span {
  font-weight: bold;
  color: #333;
  font-style: italic;
}

.add-products .flex::after {
  content: "";
  flex: auto;
}


/* Media Queries */
@media screen and (max-width: 768px) {
  .inputBox {
    width: 100%;
  }
}

@media screen and (max-width: 480px) {
  .heading {
    font-size: 24px;
  }
}
.box {
  width: 300px;
  background-color: #fff;
  border: 1px solid #ccc;
  padding: 20px;
  margin-bottom: 20px;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.box img {
  width: 100%;
  height: auto;
  margin-bottom: 10px;
}

.box .name {
  font-size: 18px;
  font-weight: bold;
  color: #333;
  margin-bottom: 10px;
}

.box .price {
  font-size: 16px;
  color: #666;
  margin-bottom: 10px;
}

.box .details {
  font-size: 14px;
  color: #999;
  margin-bottom: 10px;
}

.box .flex-btn {
  display: flex;
  justify-content: space-between;
}

.box .option-btn {
  padding: 8px 16px;
  background-color: #4caf50;
  color: #fff;
  text-decoration: none;
  border-radius: 4px;
  transition: background-color 0.3s ease;
}

.box .option-btn:hover {
  background-color: #45a049;
}

.box .delete-btn {
  padding: 8px 16px;
  background-color: #f44336;
  color: #fff;
  text-decoration: none;
  border-radius: 4px;
  transition: background-color 0.3s ease;
}

.box .delete-btn:hover {
  background-color: #d32f2f;
}

 


</style>
</head>




<body>
    <?php include '../composant/admin_header.php'; ?>

    <!-- add products section starts -->
    <br><section class="add-products">
        <h1 class="heading">Add Products</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="flex">
                <div class="inputBox">
                    <span>Product Name (required)</span>
                    <input type="text"  name="name" required placeholder="Enter product name" maxlength="100" class="box" >
                </div>
                <div class="inputBox">
                    <span>Product Price (required)</span>
                    <input type="number"  name="price" required placeholder="Enter product price" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" class="box" >
                </div>
                <div class="inputBox">
    <span>image 01(required)</span>
    <input type="file" name="image_01" class="box" accept="image/jpg, image/jpeg, image/webp, image/png" required>
</div>
<div class="inputBox">
    <span>image 02(required)</span>
    <input type="file" name="image_02" class="box" accept="image/jpg, image/jpeg, image/webp, image/png" required>
</div>
<div class="inputBox">
    <span>image 03(required)</span>
    <input type="file" name="image_03" class="box" accept="image/jpg, image/jpeg, image/webp, image/png" required>
</div>

            </div>
            <div class="input">
                <label for="details">Product Details</label>
                <textarea  name="details" class="box" placeholder="Enter product details" required maxlength="500" cols="30" rows="10" ></textarea>
            </div>
            <input type="submit" value="Add Product" name="add_product" class="btn">
        </form>
    </section>
    <!-- add products section ends -->
<!-- show products section starts-->
<section class="show-products">
  <div class="swiper-container">
    <h1 class="heading">Show Products</h1>
    <div class="swiper-wrapper">
      <?php 
        $show_products = $conn->prepare("SELECT * FROM `products`");
        $show_products->execute();
        if($show_products->rowCount() > 0){
            while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="swiper-slide">
        <div class="box">
          <img src="../uploaded_img/<?php echo $fetch_products['image_01'];?>" alt="">
          <div class="name"><?php echo $fetch_products['Name']; ?></div>
          <div class="price">DH<?php echo $fetch_products['Price']; ?>/-</div>
          <div class="details"><?php echo $fetch_products['details']; ?></div>
          <div class="flex-btn">
            <a href="update_product.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">update</a>
            <a href="products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?')">delete</a>
          </div>
        </div>
      </div>
      <?php
          }
        }else{
          echo'<p class="empty">no products added yet!</p>';
        }
      ?>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  </div>
</section>
<!-- show products section ends-->
<!-- swiper JS -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
  var swiper = new Swiper('.swiper-container', {
    slidesPerView: 1,
    spaceBetween: 30,
    breakpoints: {
      640: {
        slidesPerView: 2,
        spaceBetween: 30,
      },
      768: {
        slidesPerView: 3,
        spaceBetween: 30,
      },
      1024: {
        slidesPerView: 4,
        spaceBetween: 30,
      },
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });
</script>
</body>
</html>