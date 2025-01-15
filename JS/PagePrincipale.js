document.querySelectorAll('.produits').forEach(productElement => {
    productElement.addEventListener("click", function () {
        const idArticle = productElement.querySelector('.id_article').textContent;
        const nom = productElement.querySelector('.nom').textContent;
        const prix = productElement.querySelector('.prix').textContent;
        const image = productElement.querySelector('.imageProduit').src;
        const description = productElement.querySelector('.description').textContent;

        openPopup(idArticle, nom, prix, image, description);
    });
});

function openPopup(id, name, price, image, description) {
    document.getElementById("popup-title").textContent = name;
    document.getElementById("popup-price").textContent = "Prix: " + price;
    document.getElementById("popup-image").src = image;
    document.getElementById("popup-description").textContent = description;
    document.getElementById("id_article").value = id;
    document.getElementById("popup").style.display = "block";
}


document.getElementById("close-popup").addEventListener("click", function () {
    document.getElementById("popup").style.display = "none";
});

window.addEventListener("click", function (event) {
    if (event.target === document.getElementById("popup")) {
        document.getElementById("popup").style.display = "none";
    }
});

function cookieProduits(id_ProduitsRecent) {
    document.cookie = "recent_product=" + id_ProduitsRecent + "; path=/";
    reloadProducts();
}

// Fonction pour recharger le contenu de #productsrecent
function reloadProducts() {
    $('#productsrecent').load('index.php #productsrecent');
}


