let chronoInterval;
let countdownInterval;
let startTime;

function demarrerVote() {
  const dateDebut = document.getElementById("dateDebut").value;
  const heureDebut = document.getElementById("heureDebut").value;
  const heureFin = document.getElementById("heureFin").value;
  const messageBox = document.getElementById("messageBox");
  messageBox.textContent = "";

  if (dateDebut && heureDebut && heureFin) {
    const debutVote = new Date(`${dateDebut}T${heureDebut}`);
    const finVote = new Date(`${dateDebut}T${heureFin}`);
    const maintenant = new Date();

    if (debutVote < maintenant) {
      messageBox.textContent = "Heure du début dépassée.";
      setTimeout(() => {
        messageBox.textContent = "";
      }, 2000);
      return;
    }

    if (finVote <= debutVote) {
      messageBox.textContent =
        "L'heure de fin doit être après l'heure de début.";
      setTimeout(() => {
        messageBox.textContent = "";
      }, 2000);
      return;
    }

    countdownInterval = setInterval(() => {
      const now = new Date();
      const timeLeft = debutVote - now;

      if (timeLeft <= 0) {
        clearInterval(countdownInterval);
        document.getElementById("messageBox").textContent = "Début du vote.";
        document.getElementById("messageBox").classList.add("success-message");
        setTimeout(() => {
          messageBox.textContent = "";
        }, 2000);
        startVote();
        return;
      }

      const heures = String(Math.floor(timeLeft / 3600000)).padStart(2, "0");
      const minutes = String(Math.floor((timeLeft % 3600000) / 60000)).padStart(
        2,
        "0"
      );
      const secondes = String(Math.floor((timeLeft % 60000) / 1000)).padStart(
        2,
        "0"
      );

      messageBox.textContent = `Le vote débute dans : ${heures}:${minutes}:${secondes}`;
    }, 1000);
  } else {
    messageBox.textContent =
      "Veuillez remplir la date, l'heure de début et de fin du vote.";
    setTimeout(() => {
      messageBox.textContent = "";
    }, 2000);
  }
}

function updateChrono() {
  const now = new Date();
  const diff = now - startTime;
  const heures = String(Math.floor(diff / 3600000)).padStart(2, "0");
  const minutes = String(Math.floor((diff % 3600000) / 60000)).padStart(2, "0");
  const secondes = String(Math.floor((diff % 60000) / 1000)).padStart(2, "0");

  document.getElementById(
    "chrono"
  ).textContent = `${heures}:${minutes}:${secondes}`;

  const heureFin = document.getElementById("heureFin").value;
  if (heureFin && now.getHours() >= parseInt(heureFin.split(":")[0])) {
    arreterVote();
  }
}

function arreterVote() {
  clearInterval(chronoInterval);
  clearInterval(countdownInterval);
  const finVote = new Date();
  const diff = finVote - startTime;
  const heures = String(Math.floor(diff / 3600000)).padStart(2, "0");
  const minutes = String(Math.floor((diff % 3600000) / 60000)).padStart(2, "0");
  const secondes = String(Math.floor((diff % 60000) / 1000)).padStart(2, "0");

  document.getElementById(
    "chrono"
  ).textContent = `${heures}:${minutes}:${secondes}`;
  document.getElementById(
    "finVote"
  ).innerHTML = `Vote terminé à : ${finVote.toLocaleString()}<br>Durée du vote : ${heures}:${minutes}:${secondes}`;
  document.getElementById("arreterVoteBtn").disabled = true;
  document.getElementById("demarrerVoteBtn").disabled = true;

  // Mise à jour de la base de données
  const voteNom = document.getElementById("vote-select").value;
  const heureDebut = document.getElementById("heureDebut").value;
  const heureFin = document.getElementById("heureFin").value;

  fetch("update_vote_times.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: new URLSearchParams({
      nom: voteNom,
      heureDebut: heureDebut,
      heureFin: heureFin,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        console.log("Vote times updated successfully.");
      } else {
        console.error("Error updating vote times:", data.message);
      }
    })
    .catch((error) => console.error("Fetch error:", error));
}

function startVote() {
  startTime = new Date();
  chronoInterval = setInterval(updateChrono, 1000);
  document.getElementById("demarrerVoteBtn").disabled = true;
  document.getElementById("arreterVoteBtn").disabled = false;
}

function setMinDateTime() {
  const dateInput = document.getElementById("dateDebut");
  const timeInput = document.getElementById("heureDebut");
  const now = new Date();
  const year = now.getFullYear();
  const month = String(now.getMonth() + 1).padStart(2, "0");
  const day = String(now.getDate()).padStart(2, "0");
  const hours = String(now.getHours()).padStart(2, "0");
  const minutes = String(now.getMinutes()).padStart(2, "0");

  dateInput.min = `${year}-${month}-${day}`;
  timeInput.min = `${hours}:${minutes}`;
}

window.addEventListener("load", setMinDateTime);

document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("arreterVoteBtn").disabled = true;
  document.getElementById("demarrerVoteBtn").disabled = false;
});
