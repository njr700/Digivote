document.getElementById('continueButton').addEventListener('click', function() {
    window.location.href = 'enrolement_elect.html'; 
});

// Fonction pour imprimer la carte d'identité
function imprimerCarte() {
    const cardContent = document.getElementById('cardContent');
    const printButton = document.querySelector('.print-button');

    printButton.classList.add('hide');

    const options = {
        margin: 10,
        filename: 'carte_identite.pdf',
        image: { type: 'jpeg', quality: 1 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    // Utilisation de html2pdf pour générer et sauvegarder le PDF
    html2pdf().from(cardContent).set(options).save()
        .then(() => {
            // Une fois l'impression terminée, montrer à nouveau le bouton d'impression
            printButton.classList.remove('hide');
        })
        .catch((error) => {
            console.error('Erreur lors de l\'impression :', error);
            // Assurez-vous que le bouton d'impression est montré même en cas d'erreur
            printButton.classList.remove('hide');
        });
}