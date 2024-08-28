<?php
require_once '../includes/database.php';
require_once '../includes/app/decks.php';

session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: /login.php");
  exit;
}

$db = new Database();
$user_warning = "";

if (isset($_POST['add_deck'])) {
  $user_id = $_SESSION['user_id'];
  $deck_name = $_POST['deck_name'];
  $deck_description = $_POST['deck_description'];
  $deck_fav = $_POST['deck_is_fav'] ? 1 : 0;

  $add_deck_result = addDeck($user_id, $deck_name, $deck_description, $deck_fav, $db);

  if ($add_deck_result == false) {
    $user_warning = "Duplicate names found. Please try again with an unique name for your deck.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flashify | Decks</title>
  <link rel="icon" type="image/x-icon" href="/assets/flash-card.png">
  <link rel="stylesheet" href="/styles/app/decks.css">
</head>

<body>
  <?php require_once 'components/nav.php' ?>
  <main>
    <section class="section add">
      <h2>Add a new Deck</h2>
      <form method="POST">
        <label>
          <p>
            Name of the Deck:
          </p>
          <input type="text" name="deck_name" placeholder="Name" required>
        </label>
        <label>
          <p>
            Description of the Deck:
          </p>
          <textarea name="deck_description" placeholder="Description"></textarea>
        </label>
        <label>
          <p>
            Favorite the Deck:
            <input type="checkbox" name="deck_is_fav">
          </p>
        </label>
        <span class="error">
          <?php
          echo $user_warning;
          ?>
        </span>
        <button name="add_deck">Add</button>
      </form>
    </section>
    <?php require_once 'components/bubbles.php' ?>
  </main>
</body>

</html>