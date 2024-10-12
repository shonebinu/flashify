<?php
require_once '../includes/database.php';
require_once '../includes/app/market.php';

session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: /login.php");
  exit;
}

$db = new Database();

$search_term = "";
$link_code = "";

$clone_success_message = "";
$clone_error_message = "";

if (isset($_SESSION['clone_success_message'])) {
  $clone_success_message = $_SESSION['clone_success_message'];
  unset($_SESSION['clone_success_message']);
}

if (isset($_SESSION['clone_error_message'])) {
  $clone_error_message = $_SESSION['clone_error_message'];
  unset($_SESSION['clone_error_message']);
}

if (isset($_GET['search'])) {
  $search_term = $_GET['search'];
}

if (isset($_GET['code'])) {
  $link_code = $_GET['code'];
}

$published_decks = getAllPublishedDecks($search_term, $db);

$dialog_content = [];

if ($link_code) {
  $deck;

  foreach ($published_decks as $d) {
    if ($d['link_code'] == $link_code) $deck = $d;
  }

  if ($deck) {
    $dialog_content['deck_name'] = $deck['deck_name'];
    $dialog_content['deck_description'] = $deck['deck_description'];
    $dialog_content['publisher'] = $deck['user_name'];
    $dialog_content['like_count'] = $deck['like_count'];
    $dialog_content['user_like_status'] = getUserLikedStatus($link_code, $_SESSION['user_id'], $db);
    $dialog_content['cards'] = getCardsFromDeckCode($link_code, $db);
  }
}

if (isset($_POST['clone_deck'])) {
  $deck_code = $_POST['deck_code'];
  $clone_result = cloneDeck($link_code, $_SESSION['user_id'], $dialog_content['deck_name'] . " Cloned: " . $link_code, $dialog_content['deck_description'], $db);
  if ($clone_result == false) {
    $_SESSION['clone_error_message'] = "A deck with same name and signature exists in your workplace. Please change the existing deck's name or remove it before cloning again.";
  } else {
    $_SESSION['clone_success_message'] = "Deck has been successfully cloned";
  }
  header("Location: " . $_SERVER['PHP_SELF']);
}

if (isset($_POST['deck_like_toggle'])) {
  if ($_POST['user_like_status']) {
    dislikePublishedDeck($link_code, $_SESSION['user_id'], $db);
  } else {
    likePublishedDeck($link_code, $_SESSION['user_id'], $db);
  }
  header("Location: " . $_SERVER['REQUEST_URI']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flashify | Market</title>
  <link rel="icon" type="image/x-icon" href="/assets/flash-card.png">
  <link rel="stylesheet" href="/styles/app/market.css">
</head>

<body>
  <?php require_once 'components/nav.php' ?>
  <?php require_once 'components/bubbles.php' ?>
  <main>
    <section class="section">
      <h2>Marketplace</h2>
      <form class="search">
        <input type="search" placeholder="Search" name="search" value=<?= $search_term ?>>
        <button title="Go">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
            <path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
          </svg>
        </button>
      </form>
      <p>
        <span class="info">You can clone any of this public deck to your own workspace by clicking on View More -> Clone</span>
      </p>
      <p><span class="success"><?= $clone_success_message ?></span></p>
      <p><span class="error"><?= $clone_error_message ?></span></p>
      <div class="container">
        <?php foreach ($published_decks as $deck) : ?>
          <div class="card">
            <div>
              <p class="title">
                <span>
                  <?= $deck['deck_name'] ?>
                  <span class="count" title="Number of cards inside the deck">( <?= $deck['card_count'] ?> )</span>
                </span>
                <span class="likes" title="Number of likes">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <title>heart</title>
                    <path d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z" />
                  </svg>
                  <?= $deck['like_count'] ?>
                </span>
              </p>
              <p class="description">
                <?= $deck['deck_description'] ?>
              </p>
            </div>
            <p class="owner" title="Publisher">
              Pub: <?= $deck['user_name'] ?>
            </p>
            <form>
              <!-- To not lose the search context when clicking on View More button -->
              <input type="hidden" name="search" value="<?= $search_term ?>">
              <button class="button" name="code" value="<?= $deck['link_code'] ?>">View More</button>
            </form>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  </main>

  <?php if (!empty($dialog_content)): ?>

    <dialog id="deck-dialog">
      <h3>
        <span>
          <?= $dialog_content['deck_name'] ?><span class="count"> ( <?= count($dialog_content['cards']) ?> )</span>
        </span>
        <form method="post">
          <input type="hidden" name="user_like_status" value=<?= $dialog_content['user_like_status'] ?>>
          <button name="deck_like_toggle">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="<?= $dialog_content['user_like_status'] ? "liked" : "" ?>">
              <title>Like/Dislike</title>
              <path d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z" />
            </svg>
          </button>
        </form>
      </h3>
      <p><?= $dialog_content['deck_description'] ?></p>
      <table class="metadata">
        <tr>
          <td>Publisher:</td>
          <td><?= $dialog_content['publisher'] ?></td>
        </tr>
        <tr>
          <td>Likes:</td>
          <td><?= $dialog_content['like_count'] ?></td>
        <tr>
      </table>
      <span class="info">You can appreciate the work of this publisher by giving love!</span>
      <table class="cards">
        <tr>
          <th>Question</th>
          <th>Answer</th>
        </tr>
        <?php foreach ($dialog_content['cards'] as $card) : ?>
          <tr>
            <td>
              <?= $card['question'] ?>
            </td>
            <td>
              <?= $card['answer'] ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
      <div class="actions">
        <button id="close-dialog" class="button">Close</button>
        <form method="POST">
          <input type="hidden" name="deck_code" value="<?= $link_code ?>">
          <button class="button" name="clone_deck"
            onclick="return confirm('This operation will clone this deck and its content to your personal workplace. Do you want to continue?');">
            Clone</button>
        </form>
      </div>
    </dialog>

    <script>
      const dialog = document.getElementById('deck-dialog');
      const closeButton = document.getElementById('close-dialog');

      dialog.showModal();

      closeButton.addEventListener('click', () => {
        dialog.close();
      });
    </script>

  <?php endif; ?>

</body>

</html>