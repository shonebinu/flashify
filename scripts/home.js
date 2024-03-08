"use strict"

fetch('../modules/home.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `user_id=${getCookie('user_id')}`,
})
    .then(response => response.json())
    .then(data => {
        // Insert the Gravatar HTML into the container
        document.getElementById('gravatar-container').innerHTML = data.img;
        document.getElementById('user-name').textContent = data.name;
        updateCardsContainer(data.cards);
    })
    .catch(error => console.error('Error:', error));

// Function to get cookie value by name
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

document.getElementById("log-out").addEventListener("click", () => {
    document.cookie = "user_id" + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';    
    window.location.href = "../index.html";
});


const openButton = document.querySelector("[data-open-modal]");
const closeButton = document.querySelector("[data-close-modal]");
const modal = document.querySelector("[data-modal]");
const confirmButton = document.querySelector("[data-confirm-modal]");

openButton.addEventListener("click", () => {
  modal.showModal();
});

closeButton.addEventListener("click", () => {
  modal.close();
});

confirmButton.addEventListener("click", () => {
    const questionInput = document.querySelector("input[name='question']").value;
    const answerInput = document.querySelector("input[name='answer']").value;

    if (questionInput && answerInput) {

        fetch('../modules/add_card.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `user_id=${getCookie('user_id')}&question=${questionInput}&answer=${answerInput}`,
            })
            .then(response => response.json())
            .then(data => {
                // Handle the response, you can update the page or show a message
                updateCardsContainer(data.updatedCards);
            })
            .catch(error => console.error('Error:', error));

        }

    document.querySelector("input[name='question']").value = "";
    document.querySelector("input[name='answer']").value = "";

    modal.close();
});

function updateCardsContainer(cards) {
    const container = document.querySelector("#cards-container");

    // Clear existing content
    container.innerHTML = "";

    if (!cards.length) {
        const h4 = document.createElement("h4");
        h4.textContent = "You don't have any cards. Add some cards.";
        container.appendChild(h4);
        container.classList.toggle("center");
    } else {
        cards.forEach(card => {
            const cardElement = document.createElement("article");
            cardElement.classList.add("card");

            const questionElement = document.createElement("p");
            questionElement.textContent = card.question;

            // Add more elements or styling as needed

            cardElement.appendChild(questionElement);
            container.appendChild(cardElement);
        });
    }
}
    
