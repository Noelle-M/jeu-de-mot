var temps = 60;
var timer = setInterval('CompteaRebour()', 1000);

function CompteaRebour() {
    temps--;
    s = parseInt((temps % 3600) % 60);
    if (s > 0) {
        document.getElementById('secondes').innerHTML = (s < 10 ? "0" + s : s) + ' s ';
    } else {
        document.getElementById('secondes').innerHTML = "Terminé !";
    }

    if ((s == 0)) {
        clearInterval(timer);
        url = 'index.php?action=timeOut';
        Redirection(url)
    }
}

function Redirection(url) {
    setTimeout("window.location=url", 500)
}

/**Lancer la partie */
/**Ecoute de l'événement au clic sur le bouton "Partez" */
function start() {
    url1 = 'index.php?action=start';
    Redirection(url1);
    window.location = url1;
}

/**Verification de la réponse */
function verifForm() {
    var input_reponse = document.querySelector('.input_reponse');
    var reponse_joueur = document.getElementById('reponse_joueur').value;
    var reponse = document.getElementById('reponse').value;

    if (reponse == reponse_joueur) {
        input_reponse.style.border = "green 1px solid";
        input_reponse.style.background = "#9FF781";
    } else {
        input_reponse.style.border = "red 1px solid";
        input_reponse.style.background = "pink";
    }
}