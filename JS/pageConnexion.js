const params = new URLSearchParams(window.location.search);
if (params.has('error') && params.get('error') == '1') {
    document.getElementById('erreur-message').style.display = 'contents';
}
    
document.getElementById('inscriptionform').addEventListener('submit', function(event) {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const prenom = document.getElementById('prenom').value;
    const nom = document.getElementById('nom').value;

    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z]+\.[a-zA-Z]{2,}$/;
    const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d).{8,}$/;
    const nomPattern = /^[A-ZÀ-Ÿ][a-zà-ÿ]+$/;

    if (!emailPattern.test(email)) {
        event.preventDefault();
        alert('Veuillez entrer une adresse email valide.');
        document.getElementById('email').style.backgroundColor = 'palepink';
        return;
    }

    if (!passwordPattern.test(password)) {
        event.preventDefault();
        alert('Le mot de passe doit contenir au moins 8 caractères, dont une lettre et un chiffre.');
        document.getElementById('password').style.backgroundColor = 'palepink';
        return;
    }

    if (!nomPattern.test(prenom)) {
        event.preventDefault();
        alert('Veuillez entrer un prénom valide.');
        document.getElementById('prenom').style.backgroundColor = 'palepink';
        return;
    }

    if (!nomPattern.test(nom)) {
        event.preventDefault();
        alert('Veuillez entrer un nom valide.');
        document.getElementById('nom').style.backgroundColor = 'palepink';
        return;
    }
});
