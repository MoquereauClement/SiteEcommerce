// Fonction pour ouvrir le pop-up avec les détails du produit
function openPopup(id, name, price, image, description) {
    // Modifier les éléments du pop-up avec les informations du produit
    document.getElementById("popup-title").textContent = name;
    document.getElementById("popup-price").textContent = "Prix: " + price + "€";
    document.getElementById("popup-image").src = image;
    document.getElementById("popup-description").textContent =description;
    document.getElementById("id_article").value = id;
    // Afficher le pop-up
    document.getElementById("popup").style.display = "block";
}

// Fermer le pop-up lorsqu'on clique sur le bouton de fermeture (X)
document.getElementById("close-popup").addEventListener("click", function() {
    document.getElementById("popup").style.display = "none";
});

// Fermer le pop-up lorsqu'on clique en dehors du pop-up
window.addEventListener("click", function(event) {
    if (event.target === document.getElementById("popup")) {
        document.getElementById("popup").style.display = "none";
    }
});
