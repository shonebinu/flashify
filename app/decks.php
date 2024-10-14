<?php
require_once '../includes/database.php';
require_once '../includes/app/decks.php';

session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: /login.php");
  exit;
}

$db = new Database();
$user_deck_add_success_message = "";
$user_deck_add_error_message = "";
$user_deck_update_success_message = "";
$user_deck_update_error_message = "";
$user_deck_delete_success_message = "";
$user_deck_delete_error_message = "";
$search_term = "";

if (isset($_SESSION['deck_add_success_message'])) {
  $user_deck_add_success_message = $_SESSION['deck_add_success_message'];
  unset($_SESSION['deck_add_success_message']);
}

if (isset($_SESSION['deck_update_success_message'])) {
  $user_deck_update_success_message = $_SESSION['deck_update_success_message'];
  unset($_SESSION['deck_update_success_message']);
}

if (isset($_SESSION['deck_delete_success_message'])) {
  $user_deck_delete_success_message = $_SESSION['deck_delete_success_message'];
  unset($_SESSION['deck_delete_success_message']);
}

if (isset($_GET['search'])) {
  $search_term = $_GET['search'];
}

$current_decks = getDecks($_SESSION['user_id'], $search_term, $db);

if (isset($_POST['add_deck'])) {
  $deck_name = $_POST['deck-name'];
  $deck_description = $_POST['deck-description'];
  $deck_fav = $_POST['deck-is-fav'] ?? null ? 1 : 0;

  $add_deck_result = addDeck($_SESSION['user_id'], $deck_name, $deck_description, $deck_fav, $db);

  if ($add_deck_result == false) {
    $user_deck_add_error_message = "Duplicate names found. Please try again with an unique name for your deck.";
  } else {
    $_SESSION['deck_add_success_message'] = "Deck added successfully";
    header("Location: " . $_SERVER['PHP_SELF']);
  }
}

if (isset($_POST['deck-edit-modal'])) {
  $deck_id = $_POST['deck-id'];
  $deck_name = $_POST['deck-name'];
  $deck_description = $_POST['deck-description'];
  $deck_fav = $_POST['deck-is-fav'] ?? null ? 1 : 0;

  $edit_deck_result = updateDeck($_SESSION['user_id'], $deck_id, $deck_name, $deck_description, $deck_fav, $db);

  if ($edit_deck_result == false) {
    $user_deck_update_error_message = "Duplicate names found. Please try updating again with a unique deck name.";
  } else {
    $_SESSION['deck_update_success_message'] = "Deck updated successfully";
    header("Location: " . $_SERVER['PHP_SELF']);
  }
}

if (isset($_POST['deck-delete'])) {
  deleteDeck($_SESSION['user_id'], $_POST['deck-id'], $db);
  $_SESSION['deck_delete_success_message'] = "Deck deleted successfully";
  header("Location: " . $_SERVER['PHP_SELF']);
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
  <?php require_once 'components/bubbles.php' ?>
  <main>
    <section class="section add">
      <h2>Add a new Deck</h2>
      <form method="POST">
        <label>
          <p>
            Name of the Deck:
          </p>
          <input type="text" name="deck-name" placeholder="Name" required>
        </label>
        <label>
          <p>
            Description of the Deck:
          </p>
          <textarea name="deck-description" placeholder="Description"></textarea>
        </label>
        <label>
          <p>
            Favorite the Deck:
            <input type="checkbox" name="deck-is-fav">
          </p>
        </label>
        <span class="error">
          <?= $user_deck_add_error_message; ?>
        </span>
        <span class="success">
          <?= $user_deck_add_success_message; ?>
        </span>
        <button class="button" name="add_deck">Add</button>
      </form>
    </section>

    <section class="section">
      <h2>Current Decks</h2>
      <form class="search">
        <input type="search" placeholder="Search" name="search" value="<?= $search_term ?>">
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

      <span class="error"><?= $user_deck_update_error_message; ?></span>
      <span class="success"><?= $user_deck_update_success_message; ?></span>
      <span class="success"><?= $user_deck_delete_success_message; ?></span>

      <?php
      if (empty($current_decks)) {
        if ($search_term == "")
          echo "<p>No decks available. Create a new Deck.</p>";
        else
          echo "<p>No decks available with the given search term.</p>";
      } else {
        echo "<div class='cards-container'>";
        foreach ($current_decks as $deck) {
      ?>
          <div class="card" title="Click on the deck name to view cards of this same">
            <div class="title">
              <div>
                <a href="cards.php?deck_id=<?= $deck['id'] ?>" class="deck-name" title="View Cards">
                  <?= htmlspecialchars($deck['name']) ?>
                </a>
                <span class="info" title="Number of cards inside the deck">
                  (
                  <?= htmlspecialchars($deck['card_count']) ?>
                  )
                </span>
              </div>
              <?php if ($deck['is_favorite']): ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                  <title>Edit the deck to remove favorite</title>
                  <path d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z" />
                </svg>
              <?php endif; ?>
            </div>
            <div class="description"><?= htmlspecialchars($deck['description']) ?></div>
            <div class="actions">
              <form method="POST">
                <input type="hidden" name="deck-id" value="<?= $deck['id'] ?>">
                <button type="button" class="deck-edit" data-deck-data='<?= htmlspecialchars(json_encode($deck)) ?>'>Edit</button>
                <button name="deck-delete" onclick="return confirmDelete()">Delete</button>
                <button type="button" onclick="window.location.href='review.php?deck_id=<?= $deck['id'] ?>'">Review</button>
              </form>
            </div>
          </div>
      <?php
        }
        echo "</div>";
      }
      ?>
      <dialog>
        <form method="POST">
          <h3>Edit Deck</h3>
          <input type="hidden" name="deck-id">

          <label>
            <p>Name of the Deck:</p>
            <input type="text" name="deck-name">
          </label>

          <label>
            <p>Description:</p>
            <textarea name="deck-description"></textarea>
          </label>

          <label>
            <p>Favorite:
              <input type="checkbox" name="deck-is-fav">
            </p>
          </label>

          <p class="created-at">Created at: <span></span></p>

          <div class="actions">
            <button class="button close-modal" type="button">Close</button>
            <button class="button" name="deck-edit-modal" type="submit">Save</button>
          </div>
        </form>
      </dialog>
    </section>
  </main>
  <script>
    function confirmDelete() {
      return confirm('Are you sure you want to delete this deck and the cards contained in this deck?\n\nThis action will also remove this deck from the public market.');
    }

    const deleteButtons = document.querySelectorAll("button[name='deck-delete']");
    const editDeckButtons = document.querySelectorAll("button.deck-edit");
    const editDeckModal = document.querySelector("dialog");
    const closeModalButton = editDeckModal.querySelector("button.close-modal");

    editDeckButtons.forEach(button => {
      button.addEventListener("click", () => {
        const deckData = JSON.parse(button.getAttribute("data-deck-data"));

        editDeckModal.querySelector('[name="deck-id"]').value = deckData.id;
        editDeckModal.querySelector('[name="deck-name"]').value = deckData.name;
        editDeckModal.querySelector('[name="deck-description"]').value = deckData.description;
        editDeckModal.querySelector('[name="deck-is-fav"]').checked = deckData.is_favorite;
        editDeckModal.querySelector('.created-at span').textContent = deckData.created_at;

        editDeckModal.showModal();
      });
    });

    closeModalButton.addEventListener("click", () => {
      editDeckModal.close();
    });
  </script>
</body>

</html>