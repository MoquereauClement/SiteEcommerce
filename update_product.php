<?php
include '../composant/connect.php';

session_start();
$admin_id = $_SESSION['admin_id'];

if (!isset($_SESSION['admin_id'])) {
    header('location:admin_login.php');
    exit();
}

if (isset($_POST['update'])) {
    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);

    $update_product = $conn->prepare("UPDATE `products` SET name = ?, details = ?, price =? WHERE id = ?");
    $update_product->execute([$name, $details, $price, $pid]);

    $message[] = 'Product updated!';

    $old_image_01 = $_POST['old_image_01'];
    $image_01 = $_FILES['image_01']['name'];
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
    $image_01_size = $_FILES['image_01']['size'];
    $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
    $image_01_folder = '../uploaded_img/' . $image_01;

    if (!empty($image_01)) {
        if ($image_01_size > 2000000) {
            $message[] = 'Image size is too large!';
        } else {
            $update_image_01 = $conn->prepare("UPDATE `products` SET image_01 = ? WHERE id = ?");
            $update_image_01->execute([$image_01, $pid]);
            move_uploaded_file($image_01_tmp_name, $image_01_folder);
            unlink('../uploaded_img/' . $old_image_01);
            $message[] = 'Image 01 updated!';
        }
    }

    $old_image_02 = $_POST['old_image_02'];
    $image_02 = $_FILES['image_02']['name'];
    $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
    $image_02_size = $_FILES['image_02']['size'];
    $image_02_tmp_name = $_FILES['image_02']['tmp_name'];
    $image_02_folder = '../uploaded_img/' . $image_02;

    if (!empty($image_02)) {
        if ($image_02_size > 2000000) {
            $message[] = 'Image size is too large!';
        } else {
            $update_image_02 = $conn->prepare("UPDATE `products` SET image_02 = ? WHERE id = ?");
            $update_image_02->execute([$image_02, $pid]);
            move_uploaded_file($image_02_tmp_name, $image_02_folder);
            unlink('../uploaded_img/' . $old_image_02);
            $message[] = 'Image 02 updated!';
        }
    }

    $old_image_03 = $_POST['old_image_03'];
    $image_03 = $_FILES['image_03']['name'];
    $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
    $image_03_size = $_FILES['image_03']['size'];
    $image_03_tmp_name = $_FILES['image_03']['tmp_name'];
    $image_03_folder = '../uploaded_img/' . $image_03;

    if (!empty($image_03)) {
        if ($image_03_size > 2000000) {
            $message[] = 'Image size is too large!';
        } else {
            $update_image_03 = $conn->prepare("UPDATE `products` SET image_03 = ? WHERE id = ?");
            $update_image_03->execute([$image_03, $pid]);
            move_uploaded_file($image_03_tmp_name, $image_03_folder);
            unlink('../uploaded_img/' . $old_image_03);
            $message[] = 'Image 03 updated!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>

    <!--font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!--custom css file link-->
    
</head>

<style>


body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: white;
}

.heading {
  text-align: center;
  margin-top: 0;
}

.update-product {
  max-width: 800px;
  margin: 20px auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.image-container {
  text-align: center;
  margin-bottom: 20px;
}

.main-image img,
.sub-images img {
  width: 200px;
  height: 200px;
}
.sub-images img {
  width: 60px;
  height: 60px;
 
  margin: 0 5px;
  cursor: pointer;
  border: 2px solid transparent;
  transition: border-color 0.3s ease-in-out;
  border-radius: 5px;
  background-color: transparent;
}



.sub-images img:hover {
  border-color: #4CAF50;
}

/* General Styles */
/* General Styles */
label {
  display: block;
  margin-top: 10px;
  font-size: 16px;
  color: white;
}

.box {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-bottom: 10px;
  font-family: Arial, sans-serif;
  font-size: 14px;
  color: #333;
  background-color: #f2f2f2;
  box-sizing: border-box;
  transition: border-color 0.3s ease-in-out;
}

.box:focus {
  outline: none;
  border-color: #4CAF50;
}

.flex-btn {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.btn {
  padding: 10px 20px;
  background-color: #4CAF50;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-family: Arial, sans-serif;
  font-size: 16px;
}

.option-btn {
  padding: 10px 20px;
  background-color: #f2f2f2;
  color: #333;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-family: Arial, sans-serif;
  font-size: 16px;
}

.empty {
  text-align: center;
  margin-top: 20px;
  font-style: italic;
}


/* Responsive styles */
@media (max-width: 480px) {
  .update-product {
    padding: 10px;
  }
  
  .main-image img {
    width: 100%;
  }
  
  .sub-images {
    flex-wrap: wrap;
  }
  
  .sub-images img {
    width: 60px;
    height: 60px;
    margin: 0 3px;
  }
  
  .box {
    font-size: 14px;
  }
  
  .btn {
    font-size: 14px;
  }
}




</style>

<body>
    <?php include '../composant/admin_header.php'; ?>

    <!--section update product starts-->
    <section class="update-product">
    <h1 class="heading">Update Product</h1>
    <?php
    $update_id = $_GET['update'];
    $show_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $show_products->execute([$update_id]);
    if ($show_products->rowCount() > 0) {
        while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="pid" value="<?= isset($fetch_products['id']) ? htmlspecialchars($fetch_products['id']) : ''; ?>">
                <input type="hidden" name="old_image_01" value="<?= isset($fetch_products['image_01']) ? htmlspecialchars($fetch_products['image_01']) : ''; ?>">
                <input type="hidden" name="old_image_02" value="<?= isset($fetch_products['image_02']) ? htmlspecialchars($fetch_products['image_02']) : ''; ?>">
                <input type="hidden" name="old_image_03" value="<?= isset($fetch_products['image_03']) ? htmlspecialchars($fetch_products['image_03']) : ''; ?>">
                <div class="image-container">
                    <div class="main-image">
                        <img src="../uploaded_img/<?= isset($fetch_products['image_01']) ? htmlspecialchars($fetch_products['image_01']) : ''; ?>" alt="">
                    </div>
                    <div class="sub-images">
                        <img src="../uploaded_img/<?= isset($fetch_products['image_01']) ? htmlspecialchars($fetch_products['image_01']) : ''; ?>" alt="">
                        <img src="../uploaded_img/<?= isset($fetch_products['image_02']) ? htmlspecialchars($fetch_products['image_02']) : ''; ?>" alt="">
                        <img src="../uploaded_img/<?= isset($fetch_products['image_03']) ? htmlspecialchars($fetch_products['image_03']) : ''; ?>" alt="">
                    </div>
                </div>
                <label for="name">Update Name</label>
                <input type="text" name="name" required placeholder="Enter product name" maxlength="100" class="box" value="<?= isset($fetch_products['name']) ? htmlspecialchars($fetch_products['name']) : ''; ?>">
                <label for="price">Update Price</label>
                <input type="number" name="price" required placeholder="Enter product price" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" class="box" value="<?= isset($fetch_products['price']) ? htmlspecialchars($fetch_products['price']) : ''; ?>">
                <label for="details">Update Details</label>
                <textarea name="details" class="box" placeholder="Enter product details" required maxlength="500" cols="30" rows="10"><?= isset($fetch_products['details']) ? htmlspecialchars($fetch_products['details']) : ''; ?></textarea>
                <label for="image_01">Update Image 01</label>
                <input type="file" name="image_01" class="box" accept="image/jpg, image/jpeg, image/webp, image/png">
                <label for="image_02">Update Image 02</label>
                <input type="file" name="image_02" class="box" accept="image/jpg, image/jpeg, image/webp, image/png">
                <label for="image_03">Update Image 03</label>
                <input type="file" name="image_03" class="box" accept="image/jpg, image/jpeg, image/webp, image/png">
                <div class="flex-btn">
                    <input type="submit" value="Update" class="btn" name="update">
                    <a href="products.php" class="option-btn">Go back</a>
                </div>
            </form>
    <?php
        }
    } else {
        echo '<p class="empty">No products added yet!</p>';
    }
    ?>
</section>

    <!--section update product ends-->

    <!--custom js file link-->
    <script src="../js/admin_script.js"></script>
    <script>
        subImages = document.querySelectorAll('.update-product .image-container .sub-images img');
        mainImages = document.querySelector('.update-product .image-container .main-image img');

        subImages.forEach(images => {
            images.onclick = () => {
                let src = images.getAttribute('src');
                mainImages.src = src;
            }
        });
    </script>
</body>

</html>
