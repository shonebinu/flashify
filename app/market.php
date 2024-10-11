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
    $dialog_content['cards'] = getCardsFromDeckCode($link_code, $db);
  }
}

if (isset($_POST['clone_deck'])) {
  $deck_code = $_POST['deck_code'];
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
      <div class="container">
        <?php foreach ($published_decks as $deck) : ?>
          <div class="card">
            <div>
              <p class="title">
                <?= $deck['deck_name'] ?>
                <span title="Number of cards inside the deck">( <?= $deck['card_count'] ?> )</span>
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
      <h3><?= $dialog_content['deck_name'] ?><span class="count"> ( <?= count($dialog_content['cards']) ?> )</span></h3>
      <p><?= $dialog_content['deck_description'] ?></p>
      <p><span class="published">Published by: </span><u><?= $dialog_content['publisher'] ?></u></p>
      <span class="info">You can clone this deck to your own worksplace by clicking on the 'Clone' button down at the bottom</span>
      <table>
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
          <button class="button" name="clone_deck">Clone</button>
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