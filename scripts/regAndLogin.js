"use strict"

const mainContent = document.querySelector(".main");
const loginLink = document.querySelector(".login");

loginLink.addEventListener("click", function(event) {
  event.preventDefault();

  mainContent.innerHTML = `
    <section class="login">
        <h2>Login</h2>
        <form id="login-form">
            <label for="login-email">Email:</label>
            <input type="email" name="login-email" id="login-email" required>
            <label for="login-password">Password:</label>
            <input type="password" name="login-password" id="login-password" required>
            <button type="submit">Login</button>
        </form>
    </section>
    <p class="register-link">Not registered yet? <a href="" id="register-link">Register here</a></p>
    `;

    document.getElementById("login-form").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the default form submission

    let loginFormData = new FormData(this);

    fetch("modules/login.php", {
      method: "POST",
      body: loginFormData,
    })
      .then(response => response.json())
      .then(data => {

        if (data.message === "Login successful") {
          window.location.href = "pages/home.html";
        }
        else {
          window.alert(data.message);
        }
      })
      .catch(error => console.error("Error:", error));
  });

  const registerLink = document.getElementById("register-link");
  registerLink.addEventListener("click", function (event) {
    event.preventDefault();
    location.reload();
  })
});

document.getElementById("registration-form").addEventListener("submit", function (event) {
  event.preventDefault(); // Prevent the default form submission

  let formData = new FormData(this);

  // Use fetch to send the form data to the server
  fetch("modules/register.php", {
    method: "POST",
    body: formData,
  })
    .then(response => response.json()) // Assuming the server returns JSON
    .then(data => {
      window.alert(data.message);
    })
    .catch(error => console.error("Error:", error));
});

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}
