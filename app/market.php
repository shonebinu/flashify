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

if (isset($_GET['search'])) {
  $search_term = $_GET['search'];
}

$published_decks = getAllPublishedDecks($search_term, $db);
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
            <p class="owner">
              <?= $deck['user_name'] ?>
            </p>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  </main>
</body>

</html>