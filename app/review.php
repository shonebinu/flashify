<?php
require_once '../includes/database.php';
require_once '../includes/app/decks.php';

session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: /login.php");
  exit;
}

$db = new Database();

$current_decks = getDecks($_SESSION['user_id'], $search_term = "", $db);
$selected_deck = $_GET['deck_id'] ?? null;
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
  <?php require_once 'components/nav.php' ?>
  <?php require_once 'components/bubbles.php' ?>
  <main>
    <section class="section">
      <h2>Select a Deck</h2>
      <?php
      if (empty($current_decks)) {
        echo "<p>No Decks Available. Create a <a href='decks.php'>deck</a> to access card operations.</p>";
        exit;
      }
      ?>
      <p><span class="info">To search and navigate, visit <a href="decks.php">decks</a></span></p>
      <p><span class="info">Sorted based on favorite and created at</span></p>
      <form>
        <select class="deck-select" name="deck_id" required onchange="this.form.submit()">
          <option selected disabled value="">Select a deck</option>
          <?php
          foreach ($current_decks as $deck) {
            $selected = ($selected_deck == $deck['id']) ? 'selected' : '';
            echo "<option value='{$deck['id']}' $selected>{$deck['name']}</option>";
          }
          ?>
        </select>
      </form>
    </section>
    <section class="section">

    </section>
  </main>
</body>

</html>