document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    const messageBox = document.getElementById('messageBox');
    const errorBox = document.getElementById('errorBox');

    fetch('modifier_mdp.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.trim() === 'success') {
            window.location.href = 'index.html'; // Redirection vers index.html
        } else {
            errorBox.textContent = data;
            errorBox.style.display = 'block';
            messageBox.style.display = 'none';
        }
    })
    .catch(error => {
        errorBox.textContent = 'Erreur : ' + error;
        errorBox.style.display = 'block';
        messageBox.style.display = 'none';
    });
});