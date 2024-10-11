function initMap() {
    const mapOptions = {
        center: { lat: 33.5630737, lng: -7.6489399 },
        zoom: 14,
    };

    const map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);

    const marker = new google.maps.Marker({
        position: { lat: 33.5630737, lng: -7.6489399 },
        map: map,
        title: 'Fleuritel Casablanca'
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');

    contactForm.addEventListener('submit', function(event) {
        event.preventDefault();

        // Récupération des valeurs du formulaire
        const fullName = document.getElementById('fullName').value;
        const email = document.getElementById('email').value;
        const message = document.getElementById('message').value;

        // Validation des données (vous pouvez ajouter vos propres validations ici)

        // Envoi du message (simulé ici)
        sendMessage(fullName, email, message);
    });

    function sendMessage(fullName, email, message) {
        // Exemple d'envoi de message (simulé ici)
        console.log(`Nom complet: ${fullName}\nEmail: ${email}\nMessage: ${message}`);
        alert('Message envoyé avec succès ! Nous vous contacterons bientôt.');
    }
});
