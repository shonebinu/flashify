"use strict"

document.addEventListener("DOMContentLoaded", function () {
    // Fetch Gravatar HTML using JavaScript
    fetch('../modules/get_gravatar.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `user_id=${getCookie('user_id')}`,
    })
        .then(response => response.text())
        .then(html => {
            // Insert the Gravatar HTML into the container
            document.getElementById('gravatar-container').innerHTML = html;
        })
        .catch(error => console.error('Error:', error));

    // Function to get cookie value by name
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }
});
