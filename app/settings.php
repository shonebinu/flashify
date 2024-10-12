<?php
require_once '../includes/database.php';
require_once '../includes/app/settings.php';

session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: /login.php");
  exit;
}

$db = new Database();

$change_name_success_message = "";
$change_password_error_message = "";
$change_password_success_message = "";

if (isset($_SESSION['change_name_success_message'])) {
  $change_name_success_message = $_SESSION['change_name_success_message'];
  unset($_SESSION['change_name_success_message']);
}

if (isset($_SESSION['change_password_success_message'])) {
  $change_password_success_message = $_SESSION['change_password_success_message'];
  unset($_SESSION['change_password_success_message']);
}

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