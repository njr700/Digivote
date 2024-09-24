function generateUniqueCode() {
    const uniqueCode = "ID-" + Math.random().toString(36).substr(2, 9).toUpperCase();
    document.getElementById("uniqueCode").value = uniqueCode;
    document.getElementById("defaultPassword").value = "PWD-" + Math.random().toString(36).substr(2, 8);
}

document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("enrolmentForm");
    const messageBox = document.getElementById("messageBox");
    const errorBox = document.getElementById("errorBox");
    const cameraIcon = document.querySelector(".camera-icon");
    const profilePictureInput = document.getElementById("profilePicture");

    cameraIcon.addEventListener("click", function() {
        profilePictureInput.click();
    });

    form.addEventListener("submit", function(event) {
        event.preventDefault();

        const formData = new FormData(form);

        fetch("enrolement_candidat.php", {
            method: "POST",
            body: formData,
        })
        .then((response) => response.text())
        .then((data) => {
            if (data.trim() === "success") {
                window.location.href = "enrolement_candidat.html"; 
            } else {
                errorBox.textContent = data;
                errorBox.style.display = "block";
                setTimeout(() => {
                    errorBox.style.display = "none";
                }, 2000);
            }
        })
        .catch((error) => {
            errorBox.textContent = "Error: " + error;
            errorBox.style.display = "block";
            setTimeout(() => {
                errorBox.style.display = "none";
            }, 2000);
        });
    });
});

function previewProfilePicture(event) {
    const preview = document.getElementById('profilePicturePreview');
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onloadend = function() {
        preview.src = reader.result;
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "";
    }
}