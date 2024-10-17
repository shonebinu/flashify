<?php
require_once '../includes/database.php';
require_once '../includes/app/settings.php';
require_once '../includes/app/decks.php';
require_once '../includes/app/cards.php';

session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: /login.php");
  exit;
}

$db = new Database();

$change_name_success_message = "";
$change_password_error_message = "";
$change_password_success_message = "";
$deck_import_success_message = "";
$deck_import_error_message = "";

if (isset($_SESSION['change_name_success_message'])) {
  $change_name_success_message = $_SESSION['change_name_success_message'];
  unset($_SESSION['change_name_success_message']);
}

if (isset($_SESSION['change_password_success_message'])) {
  $change_password_success_message = $_SESSION['change_password_success_message'];
  unset($_SESSION['change_password_success_message']);
}

if (isset($_SESSION['deck_import_success_message'])) {
  $deck_import_success_message = $_SESSION['deck_import_success_message'];
  unset($_SESSION['deck_import_success_message']);
}

$user_decks = getDecks($_SESSION['user_id'], "", $db);

if (isset($_POST['update_name'])) {
  $new_user_name = $_POST['new_user_name'];
  updateUserName($_SESSION['user_id'], $new_user_name, $db);
  $_SESSION['user_name'] = $new_user_name;
  $_SESSION['change_name_success_message'] = "Name has been updated successfully";
  header("Location: " . $_SERVER['PHP_SELF']);
}

if (isset($_POST['update_password'])) {
  $old_password = $_POST['old_password'];
  $new_password = $_POST['new_password'];

  $change_password_result = updateUserPassword($_SESSION['user_id'], $old_password, $new_password, $db);

  if ($change_password_result == false) {
    $change_password_error_message = "The current password you entered is wrong";
  } else {
    $_SESSION['change_password_success_message'] = "Password updated successfully";
    header("Location: " . $_SERVER['PHP_SELF']);
  }
}


if (isset($_POST['import_csv'])) {
  $deck_name = $_POST['deck_name'];
  $file = $_FILES['csv_file'];

  if ($file['type'] != 'text/csv') {
    $import_error = "Please upload a CSV file.";
  } else {
    $db->beginTransaction();

    $deck_id = array_filter($user_decks, fn($deck) => $deck['name'] == $deck_name)[0]['id'] ?? null;

    if ($deck_id == null) {
      addDeck($_SESSION['user_id'], $deck_name, "", 0, $db);
      $deck_id = $db->lastInsertId();
    }

    $imported_count = 0;

    if (($handle = fopen($file['tmp_name'], "r")) !== FALSE) {
      fgetcsv($handle);
      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if (count($data) == 2) {
          $question = trim($data[0]);
          $answer = trim($data[1]);
          if (!empty($question) && !empty($answer)) {
            $question = htmlspecialchars($question, ENT_QUOTES, 'UTF-8');
            $answer = htmlspecialchars($answer, ENT_QUOTES, 'UTF-8');
            addCard($deck_id, $question, $answer, $_SESSION['user_id'], $db);
            $imported_count++;
          }
        }
      }
      fclose($handle);
      $_SESSION['deck_import_success_message'] = "CSV imported successfully! Imported $imported_count cards. ";
      $db->commit();
      header("Location: " . $_SERVER['PHP_SELF']);
    } else {
      $import_error = "Error reading CSV file.";
      $db->rollBack();
    }
  }
}

if (isset($_POST['export_deck'])) {
  $deck_id = $_POST['deck_id'];

  $deck_name = array_filter($user_decks, fn($deck) => $deck['id'] == $deck_id)[0]['name'] ?? null;

  $cards = getCards($deck_id, $_SESSION['user_id'], $db);

  header('Content-Type: text/csv');
  header('Content-Disposition: attachment; filename="deck_' . $deck_name . '.csv"');

  $output = fopen('php://output', 'w');

  fputcsv($output, array('question', 'answer'));

  foreach ($cards as $card) {
    fputcsv($output, array($card['question'], $card['answer']));
  }

  fclose($output);
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flashify | Settings</title>
  <link rel="icon" type="image/x-icon" href="/assets/flash-card.png">
  <link rel="stylesheet" href="/styles/app/settings.css">
</head>

<body>
  <?php require_once 'components/nav.php' ?>
  <?php require_once 'components/bubbles.php' ?>
  <main>
    <section class="section">
      <h2>Change Name</h2>
      <p><span class="success"><?= $change_name_success_message ?></span></p>
      <form method="POST">
        <label>
          <p>New Name:</p>
          <input type="text" name="new_user_name" value="<?= $_SESSION['user_name'] ?>" required>
        </label>
        <button class="button" name="update_name">Update Name</button>
      </form>
    </section>
    <section class="section">
      <h2>Change Password</h2>
      <p><span class="success"><?= $change_password_success_message ?></span></p>
      <p><span class="error"><?= $change_password_error_message ?></span></p>
      <form method="POST">
        <label>
          <p>Current Password:</p>
          <input type="password" name="old_password" placeholder="Enter Old Password" required>
        </label>
        <label>
          <p>New Password:</p>
          <input type="password" name="new_password" placeholder="Enter New Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
            title="Password must be at least 8 characters long, include at least one number, one uppercase letter, and one lowercase letter." required>
        </label>
        <label>
          <p>Confirm New Password:</p>
          <input type="password" name="confirm_password" placeholder="Enter New Password" required>
        </label>
        <button class="button" name="update_password">Update Password</button>
      </form>
    </section>
    <section class="section">
      <h2>Import CSV</h2>
      <p><span class="error"><?= $deck_import_error_message ?></span></p>
      <p><span class="success"><?= $deck_import_success_message ?></span></p>
      <span class="info">This operation populates a new deck with the data taken from the CSV file. To extend an existing deck with this data, type in the current deck's name</span>
      <p><span class="info"><b>The CSV file should have two fields: 'question' and 'answer'</b></span></p>
      <form method="POST" enctype="multipart/form-data">
        <label>
          <p>Deck Name (new or existing):</p>
          <input type="text" name="deck_name" required>
        </label>
        <label>
          <p>Select CSV File:</p>
          <input type="file" name="csv_file" accept=".csv" required>
        </label>
        <button class="button" name="import_csv">Import CSV</button>
      </form>
    </section>
    <section class="section">
      <h2>Export Deck</h2>
      <span class="info">This operation exports the selected deck as a CSV file</span>
      <form method="POST">
        <label>
          <p>Select Deck to Export:</p>
          <select name="deck_id" required>
            <option value="" disabled selected>Select a deck</option>
            <?php foreach ($user_decks as $deck): ?>
              <option value="<?= $deck['id'] ?>"><?= htmlspecialchars($deck['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <button class="button" name="export_deck">Export as CSV</button>
      </form>
    </section>
  </main>
  <script>
    const confirmPassword = document.querySelector("[name='confirm_password']");
    const password = document.querySelector("[name='new_password']");

    confirmPassword.addEventListener("input", () => {
      if (password.value != confirmPassword.value) {
        confirmPassword.setCustomValidity("Passwords don't match");
      } else {
        confirmPassword.setCustomValidity("");
      }
    });

    document.querySelector("button").addEventListener("submit", (e) => {
      if (!confirmPassword.checkValidity()) {
        e.preventDefault();
      }
    });
  </script>
</body>

</html>