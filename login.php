<?php
require_once 'includes/register-login.php';
require_once 'includes/database.php';

session_start();

if (isset($_SESSION['user_id'])) {
  header("Location: /app");
  exit;
}

$db = new Database();
$user_error_message = "";

if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (loginUser($email, $password, $db)) {
    header("Location: /app");
    exit;
  } else {
    $user_error_message = "Incorrect email or password.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flashify | Sign In</title>
  <link rel="icon" type="image/x-icon" href="/assets/flash-card.png">
  <link rel="stylesheet" href="/styles/register-login.css">
</head>

<body>
  <main>
    <img src="assets/flash-card.png">
    <h2>Welcome back!</h2>
    <p>Don't have an account? <a href="register.php">Sign Up</a></p>
    <span class="error">
      <?php
      echo $user_error_message;
      ?>
    </span>
    <form method="POST">
      <label for="email">Email Address:</label>
      <input type="email" id="email" name="email" placeholder="Enter your email" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" placeholder="Enter your password" required>

      <button type="submit" name="login">Sign In</button>
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

</html>