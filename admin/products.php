<?php
include '../composant/connect.php';

session_start();
if (!isset($_SESSION['admin_id'])) {
    header('location:admin_login.php');
}

$admin_id = $_SESSION['admin_id'];

// Ajouter un nouvel product
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS);

    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_SPECIAL_CHARS);

    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_SPECIAL_CHARS);

    $image = $_FILES['image_01']['name'];
    $image = filter_var($image, FILTER_SANITIZE_SPECIAL_CHARS);
    $image_size = $_FILES['image_01']['size'];
    $image_tmp_name = $_FILES['image_01']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;

    $select_products = $conn->prepare("SELECT * FROM `articles` WHERE nom = ?");
    $select_products->execute([$name]);

    if ($select_products->rowCount() > 0) {
        $message[] = 'Le nom de l\'article existe déjà !';
    } else {
        if ($image_size > 2000000) {
            $message[] = 'La taille de l\'image est trop grande.';
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);

            $insert_product = $conn->prepare("INSERT INTO `articles` (nom, prix, image, description) VALUES (?,?,?,?)");
            $insert_product->execute([$name, $price, $image, $details]);

            $message[] = 'Nouvel article ajouté avec succès !';
        }
    }
}

// Supprimer un article
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_product_image = $conn->prepare("SELECT * FROM `articles` WHERE id_article = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_deleted_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('../uploaded_img/' . $fetch_deleted_image['image']);
    $delete_product = $conn->prepare("DELETE FROM `articles` WHERE id_article = ?");
    $delete_product->execute([$delete_id]);
    header('location:products.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .add-products {
            max-width: 600px;
            margin: auto;
            padding: 40px;
            background: #f7f7f7;
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
        .add-products .box, .add-products .inputBox {
            width: 100%;
            margin-bottom: 20px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            color: #333;
        }
        .add-products .btn {
            padding: 12px 20px;
            background: #1565c0;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 18px;
            transition: 0.3s;
        }
        .add-products .btn:hover {
            background: #DD0000;
        }
        .box {
            width: 300px;
            background: #fff;
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
        .box .price, .box .details {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }
        .box .flex-btn {
            display: flex;
            justify-content: space-between;
        }
        .box .option-btn, .box .delete-btn {
            padding: 8px 16px;
            border-radius: 4px;
            color: #fff;
            text-decoration: none;
            transition: 0.3s;
        }
        .box .option-btn {
            background: #4caf50;
        }
        .box .delete-btn {
            background: #f44336;
        }
    </style>
</head>
<body>
    <?php include '../composant/admin_header.php'; ?>

    <!-- Ajouter des articles -->
    <section class="add-products">
        <h1 class="heading">Ajouter un Article</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="flex">
                <div class="inputBox">
                    <span>Nom de l'Article (requis)</span>
                    <input type="text" name="name" required placeholder="Entrez le nom de l'article" maxlength="100" class="box">
                </div>
                <div class="inputBox">
                    <span>Prix de l'Article (requis)</span>
                    <input type="number" name="price" required placeholder="Entrez le prix de l'article" min="0" max="9999999999" class="box">
                </div>
                <div class="inputBox">
                    <span>Image de l'Article (requis)</span>
                    <input type="file" name="image_01" class="box" accept="image/jpg, image/jpeg, image/webp, image/png" required>
                </div>
            </div>
            <div class="input">
                <label for="details">Description de l'Article</label>
                <textarea name="details" class="box" placeholder="Entrez les détails de l'article" required maxlength="500" cols="30" rows="10"></textarea>
            </div>
            <input type="submit" value="Ajouter l'Article" name="add_product" class="btn">
        </form>
    </section>

    <!-- Afficher les articles -->
    <section class="show-products">
        <h1 class="heading">Afficher les Articles</h1>
        <div class="swiper-wrapper">
            <?php
            $show_products = $conn->prepare("SELECT * FROM `articles`");
            $show_products->execute();
            if ($show_products->rowCount() > 0) {
                while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="swiper-slide">
                <div class="box">
                    <img src="../uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                    <div class="name"><?php echo $fetch_products['nom']; ?></div>
                    <div class="price">DH<?php echo $fetch_products['prix']; ?>/-</div>
                    <div class="details"><?php echo $fetch_products['description']; ?></div>
                    <div class="flex-btn">
                        <a href="update_product.php?update=<?php echo $fetch_products['id_article']; ?>" class="option-btn">Mettre à jour</a>
                        <a href="products.php?delete=<?php echo $fetch_products['id_article']; ?>" class="delete-btn" onclick="return confirm('Supprimer cet article ?')">Supprimer</a>
                    </div>
                </div>
            </div>
            <?php
                }
            } else {
                echo '<p class="empty">Aucun article ajouté pour le moment !</p>';
            }
            ?>
        </div>
    </section>
</body>
</html>
