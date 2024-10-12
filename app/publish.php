<?php
require_once '../includes/database.php';
require_once '../includes/app/publish.php';
require_once '../includes/app/decks.php';

session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: /login.php");
  exit;
}

$db = new Database();

$user_decks = getDecks($_SESSION['user_id'], "", $db);
$user_published_decks = getPublishedDecks($_SESSION['user_id'], $db);
$user_unpublished_decks = getUnpublishedDecks($user_decks, $user_published_decks);

$publish_deck_success_message = "";
$publish_deck_error_message = "";
$unpublish_deck_success_message = "";

if (isset($_SESSION['publish_deck_success_message'])) {
  $publish_deck_success_message = $_SESSION['publish_deck_success_message'];
  unset($_SESSION['publish_deck_success_message']);
}

if (isset($_SESSION['unpublish_deck_success_message'])) {
  $unpublish_deck_success_message = $_SESSION['unpublish_deck_success_message'];
  unset($_SESSION['unpublish_deck_success_message']);
}

if (isset($_POST['publish_deck'])) {
  $deck_id = $_POST['deck_id'];
  $publish_deck_result = publishDeck($_SESSION['user_id'], $deck_id, uniqid(), $db);

  if ($publish_deck_result == false) {
    $publish_deck_error_message = "This deck is already published before";
  } else {
    $_SESSION['publish_deck_success_message'] = "Deck has been published successfully";
    header("Location: " . $_SERVER['PHP_SELF']);
  }
}

if (isset($_POST['unpublish_deck'])) {
  $deck_link_id = $_POST['deck_link_id'];
  unPublishDeck($_SESSION['user_id'], $deck_link_id, $db);

  $_SESSION['unpublish_deck_success_message'] = "Deck has been unpublished successfully";
  header("Location: " . $_SERVER['PHP_SELF']);
}

function getUnpublishedDecks($user_decks, $user_published_decks)
{
  $user_unpublished_decks = [];

  foreach ($user_decks as $deck) {
    $exists = false;
    foreach ($user_published_decks as $published_deck) {
      if ($deck['name'] == $published_deck['name']) {
        $exists = true;
        break;
      }
    }
    if (!$exists)
      array_push($user_unpublished_decks, $deck);
  }

  return $user_unpublished_decks;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flashify | Publish</title>
  <link rel="icon" type="image/x-icon" href="/assets/flash-card.png">
  <link rel="stylesheet" href="/styles/app/publish.css">
</head>

<body>
  <?php require_once 'components/nav.php' ?>
  <?php require_once 'components/bubbles.php' ?>
  <main>
    <section class="section">
      <h2>Publish a Deck</h2>
      <?php
      if (empty($user_unpublished_decks)) {
        if (count($user_decks) === 0)
          echo "You haven't created any decks yet. Create a <a href='./decks.php'>deck</a> to get started!";
        else
          echo "<p>You don't have any unpublished decks. All your decks are already public!</p>";
      } else {
      ?>
        <p><span class="info">Only unpublished decks shows in this dropdown</span></p>
        <p><span class="info">Sorted based on favorite and created at</span></p>
        <form method="POST">
          <select class="deck-select" name="deck_id" required>
            <option selected disabled value="">Select a deck</option>
            <?php
            foreach ($user_unpublished_decks as $deck) {
              echo "<option value='{$deck['id']}'>" . htmlspecialchars($deck['name']) . "</option>";
            }
            ?>
          </select>
          <button class="button" name="publish_deck">Publish</button>
        </form>
      <?php
      }
      ?>
      <p><span class="error"><?= $publish_deck_error_message ?></span></p>
      <p><span class="success"><?= $publish_deck_success_message ?></span></p>
    </section>
    <section class="section">
      <h2>Published Decks</h2>
      <span class="info">All your published decks will be readable by others through the <a href="./market.php">market</a></span>
      <p><span class="success"><?= $unpublish_deck_success_message ?></span></p>
      <div>
        <table class="published-decks">
          <tr>
            <th>Name</th>
            <th>Description</th>
            <th>URL</th>
            <th>Actions</th>
          </tr>
          <?php
          if (empty($user_published_decks)) echo "<td colspan=4 align=center>No published decks</td>"
          ?>
          <?php foreach ($user_published_decks as $deck) : ?>
            <tr>
              <td><?= $deck['name']; ?></td>
              <td><?= $deck['description']; ?></td>
              <td>
                <a target="_blank" href="./market.php?code=<?= $deck['link_code']; ?>">
                  <?= $_SERVER['SERVER_NAME'] ?>/app/market.php?code=<?= $deck['link_code']; ?>
                </a>
              </td>
              <td>
                <form class="action" method="POST">
                  <input type="hidden" name="deck_link_id" value="<?= $deck['id']; ?>">
                  <button class="button" name="unpublish_deck">Unpublish</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </section>
  </main>
</body>

</html>