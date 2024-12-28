const params = new URLSearchParams(window.location.search);
if (params.has('error') && params.get('error') == '1') {
    document.getElementById('erreur-message').style.display = 'contents';
}