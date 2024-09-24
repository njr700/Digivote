document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    const messageBox = document.getElementById('messageBox');
    const errorBox = document.getElementById('errorBox');

    fetch('login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.trim() === 'candidat') {
            window.location.href = 'pages/electeur/menu_electeur.html';
        } 
        else if (data.trim() === 'electeur') {
            window.location.href = 'pages/electeur/menu_electeur.html';
        } 
        else if (data.trim() === 'admin') {
            window.location.href = 'pages/admin/menu_admin.html';
        }
        else if (data.trim() === 'staff') {
            window.location.href = 'pages/staff/menu_staff.html';
        }
        else {
            errorBox.textContent = data;
            errorBox.style.display = 'block';
            messageBox.style.display = 'none';
        }
    })
    .catch(error => {
        errorBox.textContent = 'Error: ' + error;
        errorBox.style.display = 'block';
        messageBox.style.display = 'none';
    });
});