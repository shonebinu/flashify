<?php
require_once '../includes/database.php';
require_once '../includes/app/decks.php';

session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: /login.php");
  exit;
}

$db = new Database();
$user_success_message = "";
$user_error_message = "";
$search_term = "";

if (isset($_SESSION['success_message'])) {
  $user_success_message = $_SESSION['success_message'];
  unset($_SESSION['success_message']);
}

if (isset($_GET['search'])) {
  $search_term = $_GET['search'];
}

$current_decks = getDecks($_SESSION['user_id'], $search_term, $db);

if (isset($_POST['add_deck'])) {
  $user_id = $_SESSION['user_id'];
  $deck_name = $_POST['deck_name'];
  $deck_description = $_POST['deck_description'];
  $deck_fav = $_POST['deck_is_fav'] ? 1 : 0;

  $add_deck_result = addDeck($user_id, $deck_name, $deck_description, $deck_fav, $db);

  if ($add_deck_result == false) {
    $user_error_message = "Duplicate names found. Please try again with an unique name for your deck.";
  } else {
    $_SESSION['success_message'] = "Deck added successfully";
    header("Location: " . $_SERVER['PHP_SELF']);
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
          echo $user_error_message;
          ?>
        </span>
        <span class="success">
          <?php
          echo $user_success_message;
          ?>
        </span>
        <button class="button" name="add_deck">Add</button>
      </form>
    </section>

    <section class="section">
      <h2>Current Decks</h2>
      <form class="search">
        <input type="search" placeholder="Search" name="search" value="<?php echo $search_term ?>">
        <button title="Go">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
            <path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
          </svg>
        </button>
      </form>
      <p>
        <span class="info">
          Sorted based on favorite and created at
        </span>
      </p>
      <?php
      if (count($current_decks) === 0) {
        echo "No decks available. Create a new Deck.";
      } else {
        echo "<div class='cards-container'>";
        foreach ($current_decks as $deck) {
          echo "<div class='card'>" . $deck['name'] . "</div>";
        }
        echo "</div>";
      }
      ?>
    </section>
    <?php require_once 'components/bubbles.php' ?>
  </main>
</body>

</html>