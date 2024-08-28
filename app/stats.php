<?php
require_once '../includes/database.php';

session_start();

if (!isset($_SESSION['user_name'])) {
  header("Location: /login.php");
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flashify | Stats</title>
  <link rel="icon" type="image/x-icon" href="/assets/flash-card.png">
  <link rel="stylesheet" href="/styles/app/decks.css">
</head>

<body>
  <?php require_once 'components/nav.php' ?>
  <main>
    <?php require_once 'components/bubbles.php' ?>
  </main>
</body>

</html>