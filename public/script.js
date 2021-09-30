/**
 * Modale
 */
var modale = document.getElementById('modale')
modale.style.display = 'none';

/**
 * Bouton supprimer (depuis la page item)
 */
var btnRemove = document.getElementById('btnremove')
btnRemove.addEventListener('click', displayModale )

/**
 * Bouton annuler
 */
var btnCancel = document.getElementById('btncancel')
btnCancel.addEventListener('click', hideModale )

/**
 * Fonction affichant la modale
 */
function displayModale() {
    modale.style.display ='';
}

/**
 * Fonction cachant la modale
 */
function hideModale() {
    modale.style.display ='none';
}