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
    width: 100%;
    max-width: 600px;
    margin: 40px auto;
    padding: 30px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}


.add-products .heading {
    text-align: center;
    font-size: 28px;
    margin-bottom: 20px;
    color: #333;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: bold;
}


.add-products .flex {
    display: flex;
    flex-direction: column;
    align-items: center; 
    margin-bottom: 20px;
    gap: 20px; /* Espacement uniforme entre les sections */
}


.add-products .inputBox {
    width: 100%;
    max-width: 500px; 
    text-align: left;
}

/* Style des champs de saisie */
.add-products .box {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
    color: #333;
    margin-bottom: 15px;
    box-sizing: border-box;
}

/* Style du bouton de soumission */
.add-products .btn {
    padding: 12px 20px;
    background: #1565c0;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 18px;
    width: 100%; /* Bouton qui occupe toute la largeur */
    transition: 0.3s;
}

/* survol du bouton */
.add-products .btn:hover {
    background: #DD0000;
}







    .show-products {
        max-width: 1200px; 
        margin: 20px auto; 
        padding: 20px;
        text-align: center;
    }

    
    .show-products .heading {
        font-size: 28px;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
        text-transform: uppercase;
    }

    
    .swiper-wrapper {
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
        gap: 20px; 
        justify-items: center; 
    }

    
    .swiper-slide {
        width: 100%; 
        display: flex;
        justify-content: center;
    }

    .box {
        background: #f9f9f9; 
        border: 1px solid #ddd; 
        border-radius: 8px; 
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
        padding: 20px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease; 
        max-width: 300px; 
    }

    .box:hover {
        transform: translateY(-5px); 
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
    }

    .box img {
        max-width: 100%; 
        height: auto;
        border-radius: 6px; 
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
        color: #1565c0; 
        margin-bottom: 10px;
    }

    .box .details {
        font-size: 14px;
        color: #666; 
        margin-bottom: 15px;
    }

    .box .flex-btn {
        display: flex;
        justify-content: space-between; /* Boutons alignés à gauche et à droite */
        gap: 10px; /* Espacement entre les boutons */
    }

    .box .option-btn, .box .delete-btn {
        flex: 1; 
        padding: 10px 15px;
        border-radius: 4px;
        color: #fff;
        font-size: 14px;
        text-decoration: none;
        text-align: center;
        transition: background 0.3s ease;
    }

    .box .option-btn {
        background: #4caf50; /* Vert pour l'option */
    }

    .box .option-btn:hover {
        background: #43a047;
    }

    .box .delete-btn {
        background: #f44336; /* Rouge pour la suppression */
    }

    .box .delete-btn:hover {
        background: #e53935;
    }

    /* Message vide */
    .empty {
        font-size: 16px;
        color: #666;
        margin-top: 20px;
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
