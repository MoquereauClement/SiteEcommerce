console.log(document.querySelectorAll('.close'));
document.querySelectorAll('.close').forEach(closeButton => {
    closeButton.addEventListener('click', function () {
        const article = this.parentElement;

        const nom = article.querySelector('.nom').textContent;
        const quantite = article.querySelector('.quantitenombre').textContent;

        window.location.href = 'panier.php?nom=' + nom + '&quantite=' + quantite;
    });
});