// Fonction pour afficher les détails du vol lorsqu'un utilisateur clique sur un élément de résultat de vol
function showFlightDetails(event) {
    // Récupère l'ID du vol à partir de l'attribut 'data-flight-id' de l'élément sur lequel l'utilisateur a cliqué
    const flightId = event.currentTarget.getAttribute('data-flight-id');

    // Sélectionne l'élément HTML contenant les détails du vol correspondant à l'ID du vol récupéré
    const flightDetails = document.getElementById(`flightDetails-${flightId}`);

    // Sélectionne l'élément HTML qui servira de conteneur pour afficher les détails du vol sélectionné
    const flightDetailsContainer = document.getElementById('selected-flight-details');

    // Copie le contenu HTML des détails du vol sélectionné dans le conteneur des détails du vol
    flightDetailsContainer.innerHTML = flightDetails.innerHTML;

    // Modifie la propriété 'display' du conteneur des détails du vol pour qu'il soit visible
    flightDetailsContainer.style.display = 'block';

    // Ajoute la classe 'resultCardSelected' à la carte sélectionnée et la supprime des autres cartes
    const allCards = document.getElementsByClassName('resultCard');
    for (let i = 0; i < allCards.length; i++) {
        allCards[i].classList.remove('resultCardSelected');
    }
    event.currentTarget.classList.add('resultCardSelected');
}

function closeFlightDetails() {
    // Sélectionne l'élément HTML qui sert de conteneur pour afficher les détails du vol sélectionné
    const flightDetailsContainer = document.getElementById('selected-flight-details');

    // Vide le contenu du conteneur des détails du vol
    flightDetailsContainer.innerHTML = '';

    // Supprime la classe 'resultCardSelected' de toutes les cartes
    const allCards = document.getElementsByClassName('resultCard');
    for (let i = 0; i < allCards.length; i++) {
        allCards[i].classList.remove('resultCardSelected');
    }
}

//-------------------------------------fonction Booking

function redirectToBooking(flightId) {
    console.log('redirectToBooking called with flightId:', flightId);
    document.location.href = `http://localhost:8000/booking/${flightId}`;
}