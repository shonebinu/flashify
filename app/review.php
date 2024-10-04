<?php
require_once '../includes/database.php';
require_once '../includes/app/cards.php';

session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: /login.php");
  exit;
}

if (!isset($_GET['deck_id'])) {
  header("Location: ./");
  exit;
}

$db = new Database();

$deck_id = $_GET['deck_id'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flashify | Review</title>
  <link rel="icon" type="image/x-icon" href="/assets/flash-card.png">
  <link rel="stylesheet" href="/styles/app/review.css">
</head>

<body>
  <main>
  </main>
</body>

</html>