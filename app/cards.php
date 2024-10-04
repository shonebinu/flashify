<?php
require_once '../includes/database.php';
require_once '../includes/app/decks.php';
require_once '../includes/app/cards.php';

session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: /login.php");
  exit;
}

$db = new Database();

$current_decks = getDecks($_SESSION['user_id'], $search_term = "", $db);
$selected_deck = $_GET['deck_id'] ?? null;
$selected_deck_name;
$selected_deck_description;
$selected_deck_is_fav;
$selected_deck_cards_count;

$deck_cards;
$user_card_add_success_message = "";
$user_card_update_success_message = "";
$user_card_delete_success_message = "";

if (isset($_SESSION['card_add_success_message'])) {
  $user_card_add_success_message = $_SESSION['card_add_success_message'];
  unset($_SESSION['card_add_success_message']);
}

if (isset($_SESSION['card_update_success_message'])) {
  $user_card_update_success_message = $_SESSION['card_update_success_message'];
  unset($_SESSION['card_update_success_message']);
}

if (isset($_SESSION['card_delete_success_message'])) {
  $user_card_delete_success_message = $_SESSION['card_delete_success_message'];
  unset($_SESSION['card_delete_success_message']);
}

if ($selected_deck) {
  foreach ($current_decks as $deck) {
    if ($deck['id'] == $selected_deck) {
      $selected_deck_name = $deck['name'];
      $selected_deck_description = $deck['description'];
      $selected_deck_is_fav = $deck['is_favorite'];
      $selected_deck_cards_count = $deck['card_count'];

      break;
    }
  }
}

if ($selected_deck_name) {
  $deck_cards = getCards($selected_deck, $_SESSION['user_id'], $db);
}

if (isset($_POST['add-card'])) {
  $card_qn = $_POST['card-qn'];
  $card_ans = $_POST['card-ans'];

  addCard($selected_deck, $card_qn, $card_ans, $_SESSION['user_id'], $db);

  $_SESSION["card_add_success_message"] = "Card added successfully";
  header("Location: " . $_SERVER['REQUEST_URI']);
}

if (isset($_POST['edit-card'])) {
  $card_id = $_POST['card-id'];
  $card_qn = $_POST['card-qn'];
  $card_ans = $_POST['card-ans'];

  updateCard($selected_deck, $card_id, $card_qn, $card_ans, $_SESSION['user_id'], $db);

  $_SESSION["card_update_success_message"] = "Card updated successfully";
  header("Location: " . $_SERVER['REQUEST_URI']);
}

if (isset($_POST['delete-card'])) {
  $card_id = $_POST['card-id'];

  deleteCard($selected_deck, $card_id, $_SESSION['user_id'], $db);

  $_SESSION["card_delete_success_message"] = "Card deleted successfully";
  header("Location: " . $_SERVER['REQUEST_URI']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flashify | Cards</title>
  <link rel="icon" type="image/x-icon" href="/assets/flash-card.png">
  <link rel="stylesheet" href="/styles/app/cards.css">
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
        <select class="deck-select" name="deck_id" onchange="this.form.submit()">
          <option selected disabled>Select a deck</option>
          <?php
          foreach ($current_decks as $deck) {
            $selected = ($selected_deck == $deck['id']) ? 'selected' : '';
            echo "<option value='{$deck['id']}' $selected>{$deck['name']}</option>";
          }
          ?>
        </select>
      </form>
    </section>

    <?php
    if (!$selected_deck || !$selected_deck_name) exit;
    ?>

    <section class="section">
      <h2 class="deck-title">
        <?= $selected_deck_name ?>
        <?php if ($selected_deck_is_fav): ?>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <title>Edit the deck to remove favorite</title>
            <path d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z" />
          </svg>
        <?php endif; ?>
        <span class="card-count">( <?= $selected_deck_cards_count ?> )</span>
      </h2>
      <p><?= $selected_deck_description ?></p>
      <span class="success"><?= $user_card_add_success_message ?></span>
      <span class="success"><?= $user_card_update_success_message ?></span>
      <span class="success"><?= $user_card_delete_success_message ?></span>
      <div class="table-container">
        <table class="cards">
          <tr>
            <th>Question</th>
            <th>Answer</th>
            <th>Actions</th>
          </tr>
          <tr>
            <td colspan="3" class="add-card">
              <button title="Add a new card">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                  <title>plus-circle</title>
                  <path d="M17,13H13V17H11V13H7V11H11V7H13V11H17M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                </svg>
              </button>
            </td>
          </tr>
          <?php foreach ($deck_cards as $card): ?>
            <tr>
              <td class="question"><?= htmlspecialchars($card['question']) ?></td>
              <td class="answer"><?= htmlspecialchars($card['answer']) ?></td>
              <td>
                <form class="actions" method="POST">
                  <input type="hidden" name="card-id" value="<?= $card['id'] ?>">
                  <button type="button" class="edit button" data-card-data='<?= htmlspecialchars(json_encode($card)) ?>'>Edit</button>
                  <button class="button" name="delete-card" onclick="return confirmDelete()">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>

      <dialog class="add-card">
        <form method="POST">
          <h3>Add Card</h3>
          <label>
            <p>Card Question:</p>
            <textarea name="card-qn" placeholder="Question"></textarea>
          </label>
          <label>
            <p>Card Answer:</p>
            <textarea name="card-ans" placeholder="Answer"></textarea>
          </label>
          <div class="actions">
            <button class="button close-modal" type="button">Close</button>
            <button class="button" name="add-card">Add</button>
          </div>
        </form>
      </dialog>

      <dialog class="edit-card">
        <form method="POST">
          <h3>Edit Card</h3>

          <input type="hidden" name="card-id">

          <label>
            <p>Card Question:</p>
            <textarea name="card-qn"></textarea>
          </label>
          <label>
            <p>Card Answer:</p>
            <textarea name="card-ans"></textarea>
          </label>
          <div class="actions">
            <button class="button close-modal" type="button">Close</button>
            <button class="button" name="edit-card">Save</button>
          </div>
        </form>
      </dialog>
    </section>
  </main>
  <script>
    function confirmDelete() {
      return confirm('Are you sure you want to delete this card and its related statistic data.');
    }

    const addCardButton = document.querySelector(".add-card button");
    const addCardDialog = document.querySelector("dialog.add-card");
    const addCardCloseModalButton = addCardDialog.querySelector("button.close-modal");

    const editCardButtons = document.querySelectorAll(".actions .edit");
    const editCardDialog = document.querySelector("dialog.edit-card");
    const editCardCloseModalButton = editCardDialog.querySelector("button.close-modal");

    addCardButton.addEventListener("click", () => {
      addCardDialog.showModal();
    });

    addCardCloseModalButton.addEventListener("click", () => {
      addCardDialog.close();
    });

    editCardButtons.forEach(button => {
      button.addEventListener("click", () => {
        const cardData = JSON.parse(button.getAttribute("data-card-data"));

        editCardDialog.querySelector('[name="card-id"]').value = cardData.id;
        editCardDialog.querySelector('[name="card-qn"]').value = cardData.question;
        editCardDialog.querySelector('[name="card-ans"]').value = cardData.answer;

        editCardDialog.showModal();
      });
    });

    editCardCloseModalButton.addEventListener("click", () => {
      editCardDialog.close();
    });
  </script>
</body>

</html>