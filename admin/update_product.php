<?php
include '../composant/connect.php';

session_start();
$admin_id = $_SESSION['admin_id'];

if (!isset($_SESSION['admin_id'])) {
    header('location:admin_login.php');
    exit();
}

if (isset($_POST['update'])) {
    $id_article = $_POST['id_article'];
    $id_article = filter_var($id_article, FILTER_SANITIZE_SPECIAL_CHARS);
    $nom = $_POST['nom'];
    $nom = filter_var($nom, FILTER_SANITIZE_SPECIAL_CHARS);
    $prix = $_POST['prix'];
    $prix = filter_var($prix, FILTER_SANITIZE_SPECIAL_CHARS);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_SPECIAL_CHARS);

    $update_article = $conn->prepare("UPDATE `articles` SET nom = ?, description = ?, prix = ? WHERE id_rticle = ?");
    $update_article->execute([$nom, $description, $prix, $id_article]);

    $message[] = 'Article updated!';

    $old_image = $_POST['old_image'];
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_SPECIAL_CHARS);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;

    if (!empty($image)) {
        if ($image_size > 2000000) {
            $message[] = 'Image size is too large!';
        } else {
            $update_image = $conn->prepare("UPDATE `articles` SET image = ? WHERE id_rticle = ?");
            $update_image->execute([$image, $id_article]);
            move_uploaded_file($image_tmp_name, $image_folder);
            unlink('../uploaded_img/' . $old_image);
            $message[] = 'Image updated!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Article</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    <section class="update-product">
    <h1 class="heading">Update Article</h1>
    <?php
    $update_id = $_GET['update'];
    $show_articles = $conn->prepare("SELECT * FROM `articles` WHERE id_rticle = ?");
    $show_articles->execute([$update_id]);
    if ($show_articles->rowCount() > 0) {
        while ($fetch_articles = $show_articles->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_article" value="<?= isset($fetch_articles['id_rticle']) ? htmlspecialchars($fetch_articles['id_rticle']) : ''; ?>">
                <input type="hidden" name="old_image" value="<?= isset($fetch_articles['image']) ? htmlspecialchars($fetch_articles['image']) : ''; ?>">
                <label for="nom">Update Name</label>
                <input type="text" name="nom" required placeholder="Enter article name" maxlength="100" class="box" value="<?= isset($fetch_articles['nom']) ? htmlspecialchars($fetch_articles['nom']) : ''; ?>">
                <label for="prix">Update Price</label>
                <input type="number" name="prix" required placeholder="Enter article price" min="0" max="9999999999" class="box" value="<?= isset($fetch_articles['prix']) ? htmlspecialchars($fetch_articles['prix']) : ''; ?>">
                <label for="description">Update Description</label>
                <textarea name="description" class="box" placeholder="Enter article description" required maxlength="500" cols="30" rows="10"><?= isset($fetch_articles['description']) ? htmlspecialchars($fetch_articles['description']) : ''; ?></textarea>
                <label for="image">Update Image</label>
                <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/webp, image/png">
                <div class="flex-btn">
                    <input type="submit" value="Update" class="btn" name="update">
                    <a href="articles.php" class="option-btn">Go back</a>
                </div>
            </form>
    <?php
        }
    } else {
        echo '<p class="empty">No articles found!</p>';
    }
    ?>
</section>
    <script>
        // Custom script if needed
    </script>
</body>
</html>
