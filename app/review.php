<?php
require_once '../includes/database.php';
require_once '../includes/app/review.php';

session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: /login.php");
  exit;
}

if ((!isset($_GET['deck_id']) && !isset($_POST['card_id']))) {
  header("Location: ./");
  exit;
}

$db = new Database();

$deck_id = $_GET['deck_id'];

$card = getReviewCard($deck_id, $_SESSION['user_id'], $db);

if (isset($_POST['card_difficulty'])) {
  $card_id = $_POST['card_id'];
  $card_score = $_POST['card_score'];
  $card_difficulty = $_POST['card_difficulty'];

  $new_score = calculateScore($card_score, $card_difficulty);
  updateCardScore($card_id, $new_score, $deck_id, $_SESSION['user_id'], $db);
}

function calculateScore($current_score, $card_difficulty)
{
  $difficultyFactors = [
    'easy' => 1.5,
    'good' => 1.0,
    'hard' => 0.5
  ];

  $new_score = $current_score + $difficultyFactors[$card_difficulty];

  return max(0, $new_score);
}
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
    <section class="section">
      <a class="back" href="./">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <title>close</title>
          <path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" />
        </svg>
      </a>
      <div>
        <?php
        if (!$card) {
          echo "Deck doesn't exist or have no cards in it.";
          exit;
        }
        ?>
        <h2 class="qn"><?= $card['question'] ?></h2>
        <button class="show-ans button">Show Answer</button>
        <div class="ans">
          <p>
            <?= $card['answer'] ?>
          </p>
          <form method="POST">
            <div class="actions">
              <input type="hidden" name="card_id" value="<?= $card['id'] ?>">
              <input type="hidden" name="card_score" value="<?= $card['score'] ?>">
              <button class="button" name="card_difficulty" value="easy">Easy</button>
              <button class="button" name="card_difficulty" value="good">Good</button>
              <button class="button" name="card_difficulty" value="hard">Hard</button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>
  <script>
    const showAnsButton = document.querySelector("button.show-ans");
    const answer = document.querySelector(".ans");

    showAnsButton.addEventListener("click", () => {
      showAnsButton.classList.toggle("hide");
      answer.classList.toggle("show");
    })
  </script>
</body>

</html>