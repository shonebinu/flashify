<?php
require_once '../includes/database.php';
require_once '../includes/app/stats.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: /login.php");
  exit;
}

$db = new Database();

$default_start_date = date('Y-01-01');
$default_end_date = date('Y-12-31');

$start_date = isValidDate($_GET['start-date'] ?? '') ? $_GET['start-date'] : $default_start_date;
$end_date = isValidDate($_GET['end-date'] ?? '') ? $_GET['end-date'] : $default_end_date;

function isValidDate($date)
{
  $d = DateTime::createFromFormat('Y-m-d', $date);
  return $d && $d->format('Y-m-d') === $date;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flashify | Stats</title>
  <link rel="icon" type="image/x-icon" href="/assets/flash-card.png">
  <link rel="stylesheet" href="/styles/app/stats.css">
</head>

<body>
  <?php require_once 'components/nav.php' ?>
  <?php require_once 'components/bubbles.php' ?>
  <main>
    <section class="section">
      <h2>Statistics</h2>
      <form method="GET">
        <label>
          <p>Start Date:</p>
          <input type="date" name="start-date" value="<?php echo htmlspecialchars($start_date); ?>">
        </label>
        <label>
          <p>End Date:</p>
          <input type="date" name="end-date" value="<?php echo htmlspecialchars($end_date); ?>">
        </label>
        <button class="button">Go</button>
      </form>
    </section>
  </main>
</body>

</html>