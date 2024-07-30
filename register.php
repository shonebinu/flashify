<?php
require_once 'includes/database.php';

session_start();

if (isset($_SESSION['user_name'])) {
    header("Location: /app");
    exit;
}

$db = new Database();

$user_exists_warning = "";

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($name) || empty($email) || empty($password)) {
        $user_exists_warning = "All fields are required.";
    } else {
        $existingUser = $db->fetch("SELECT * FROM users WHERE email = :email", ['email' => $email]);

        if ($existingUser) {
            $user_exists_warning = "This Email exists in our database.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $db->execute("INSERT INTO users(name, email, password) VALUES(:name, :email, :password)", [
              "name" => $name, "email" => $email, "password" => $hashedPassword
            ]);

            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;

            header("Location: /app");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flashify | Sign Up</title>
  <link rel="icon" type="image/x-icon" href="assets/flash-card.png">
  <link rel="stylesheet" href="./styles/register_login.css">
</head>

<body>
<main>
  <img src="assets/flash-card.png">
  <h2>Welcome to Flashify!</h2>
  <p>Already have an account? <a href="login.php">Sign In</a></p>
  <span class="error">
    <?php
    echo $user_exists_warning;
?>
  </span>
  <form method="POST">
    <label for="name">Full Name:</label>
    <input type="text" id="name" name="name" placeholder="Enter your name" required>

    <label for="email">Email Address:</label>
    <input type="email" id="email" name="email" placeholder="Enter your email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" placeholder="Enter your password" 
       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
       title="Password must be at least 8 characters long, include at least one number, one uppercase letter, and one lowercase letter." 
       required>

    <label for="confirm-password">Confirm Password:</label>
    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password" required>

    <button type="submit" name="register">Sign Up</button>
  </form>
</main>
  <div class="bubbles">
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
  </div>

  <script>
    const confirmPassword = document.querySelector("#confirm-password");
    const password = document.querySelector("#password");

    confirmPassword.addEventListener("input", () => {
      if (password.value != confirmPassword.value) {
        confirmPassword.setCustomValidity("Passwords don't match");
      } else {
        confirmPassword.setCustomValidity("");
      }
    });

    document.querySelector("button").addEventListener("submit", (e) => {
      if (!confirmPassword.checkValidity()) {
        e.preventDefault();
      }
    });
  </script>
</body>

</html>

