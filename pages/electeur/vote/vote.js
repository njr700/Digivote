document.getElementById('numero').addEventListener('input', function() {
    var identityNumber = document.getElementById('numero').value;
    var identityMessage = document.getElementById('identityMessage');
    if (identityNumber === ""){
        identityMessage.style.display = 'none';
        document.getElementById('generateCodeButton').disabled = true;
        document.getElementById('optionsFieldset').disabled = true;
        resetUniqueCode();
        checkFormValidity()
        return;
    }
    
    fetch('vote.php?action=check_identity', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'identityNumber=' + encodeURIComponent(identityNumber),
    })
    .then(response => response.json())
    .then(data => {
        if (data.valid) {
            identityMessage.style.display = 'none';
            document.getElementById('generateCodeButton').disabled = false;
            document.getElementById('optionsFieldset').disabled = false;
        } else {
            identityMessage.style.display = 'block';
            document.getElementById('generateCodeButton').disabled = true;
            document.getElementById('optionsFieldset').disabled = true;
            resetUniqueCode();
        }
        checkFormValidity();
    });
});

function resetUniqueCode() {
    document.getElementById('uniqueCodeDisplay').innerText = "";
    delete document.getElementById('uniqueCodeDisplay').dataset.uniqueCode;
}

document.getElementById('generateCodeButton').addEventListener('click', function(e) {
    e.preventDefault();
    
    fetch('vote.php?action=generate_code')
        .then(response => response.json())
        .then(data => {
            document.getElementById('uniqueCodeDisplay').innerText = "Votre numéro jeton : " + data.uniqueCode;
            document.getElementById('uniqueCodeDisplay').dataset.uniqueCode = data.uniqueCode;
            checkFormValidity();
        });
});

document.getElementById('voteForm').addEventListener('change', function() {
    checkFormValidity();
});

document.getElementById('voteForm').addEventListener('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    var uniqueCode = document.getElementById('uniqueCodeDisplay').dataset.uniqueCode;
    var identityNumber = document.getElementById('numero').value;
    formData.append('uniqueCode', uniqueCode);
    formData.append('identityNumber', identityNumber);

    fetch('vote.php?action=vote', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        var messageContainer = document.createElement('div');
        messageContainer.classList.add('message-box');

        if (data.success) {
            document.getElementById('uniqueCodeDisplay').innerText = "";
            delete document.getElementById('uniqueCodeDisplay').dataset.uniqueCode;
            messageContainer.textContent = "Votre vote a été enregistré avec succès.";
        } else {
            messageContainer.classList.add('error-box');
            messageContainer.textContent = data.message;
        }

        var votingContainer = document.querySelector('.voting-container');
        votingContainer.insertBefore(messageContainer, document.getElementById('voteForm'));

        setTimeout(function() {
            messageContainer.remove();
        }, 2000);

        resetForm();
        loadResults();
    });
});

function checkFormValidity() {
    var uniqueCode = document.getElementById('uniqueCodeDisplay').dataset.uniqueCode;
    var selectedOption = document.querySelector('input[name="option"]:checked');
    var voteButton = document.querySelector('#voteForm button[type="submit"]');
    var identityNumber = document.getElementById('numero').value;

    if (uniqueCode && selectedOption && identityNumber) {
        voteButton.disabled = false;
    } else {
        voteButton.disabled = true;
    }
}

function resetForm() {
    document.getElementById('numero').value = "";
    var options = document.querySelectorAll('input[name="option"]');
    options.forEach(option => option.checked = false);
    resetUniqueCode();
    document.getElementById('generateCodeButton').disabled = true;
    document.getElementById('optionsFieldset').disabled = true;
    checkFormValidity();
}



function loadResults() {
    fetch('vote.php?action=results')
        .then(response => response.json())
        .then(data => {
            var resultsChart = document.getElementById('resultsChart').getContext('2d');

            var options = Object.keys(data.votes);
            var votes = Object.values(data.votes);
            var totalVotes = data.totalVotes;
            var totalVoters = data.totalVoters;

            var percentages = [];
            if (totalVotes > 0) {
                percentages = votes.map(v => ((v / totalVotes) * 100).toFixed(2));
            } else {
                percentages = Array(options.length).fill('0');
            }

            var chartData = {
                labels: options.map((option, index) => `${option} : ${percentages[index]}%`),
                datasets: [{
                    data: votes,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                    hoverOffset: 30,
                    borderWidth: 0
                }]
            };

            if (window.myPieChart) {
                window.myPieChart.destroy(); 
            }

            window.myPieChart = new Chart(resultsChart, {
                type: 'pie',
                data: chartData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `${tooltipItem.label} : ${tooltipItem.raw} vote(s)`;
                                }
                            }
                        }
                    }
                }
            });

            var resultsContainer = document.getElementById('resultsContainer');
            var infoDiv = document.createElement('div');
            infoDiv.classList.add('additional-info');
            infoDiv.innerHTML = `
                <h3>Informations supplémentaires</h3>
                Nombre total de votes : ${totalVotes}</br>
                Nombre total d'électeurs : ${totalVoters}</br>
                Nombre de votes restants : ${totalVoters - totalVotes}
            `;

            var oldInfo = resultsContainer.querySelector('.additional-info');
            if (oldInfo) {
                resultsContainer.removeChild(oldInfo);
            }

            resultsContainer.appendChild(infoDiv);
        });
}

loadResults();



