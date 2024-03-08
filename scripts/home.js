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
    })
    .catch(error => console.error('Error:', error));

// Function to get cookie value by name
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

document.getElementById("log-out").addEventListener("click", (event) => {
    document.cookie = "user_id" + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';    
    window.location.href = "../index.html";
});
