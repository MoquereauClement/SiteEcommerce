document.querySelectorAll('.close').forEach(closeButton => {
    closeButton.addEventListener('click', function () {
        const article = this.parentElement;

        const nom = article.querySelector('.nom').textContent;
        const quantite = article.querySelector('.quantitenombre').textContent;

        window.location.href = 'panier.php?nom=' + nom + '&quantite=' + quantite;
    });
});

document.getElementById('commander').addEventListener('click', function(){
    document.getElementById('commander').textContent = "Et si on allait voir plutôt le meilleur LinkedIn";
    document.getElementById('commander').addEventListener('click', function(){
        window.location.href = 'https://www.linkedin.com/in/corentin-coupry-1141b0b9/'
        
    });
});

