<?php
require_once '../includes/database.php';
require_once '../includes/app/stats.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: /login.php");
  exit;
}

$db = new Database();

$user_registered_time = getUserRegisteredTime($_SESSION['user_id'], $db)['created_at'] ?? '';

$created_year = date('Y', strtotime($user_registered_time));
$current_year = date('Y');

$available_years = range($created_year, $current_year);

$selected_year = isset($_GET['year']) &&
  is_numeric($_GET['year']) &&
  in_array($_GET['year'], $available_years)
  ? $_GET['year']
  : $current_year;

$start_date = $selected_year . '-01-01';
$end_date = $selected_year . '-12-31';

$activity_data = getActivityData($_SESSION['user_id'], $start_date, $end_date, $db);

$activity_by_date = [];
foreach ($activity_data as $day) {
  $activity_by_date[$day['date']] = $day['count'];
}

function getColor($count)
{
  if ($count === 0) return '#ebedf0';
  if ($count < 5) return '#9be9a8';
  if ($count < 10) return '#40c463';
  if ($count < 15) return '#30a14e';
  return '#216e39';
}

function createCalendar($year, $activity_by_date)
{
  $startDate = new DateTime("$year-01-01");
  $endDate = new DateTime("$year-12-31");
  $calendar = '<div class="calendar">';
  $currentDate = clone $startDate;

  while ($currentDate <= $endDate) {
    if ($currentDate->format('w') === '0' || $currentDate == $startDate) {
      if ($currentDate != $startDate) {
        $calendar .= '</div>';
      }
      $calendar .= '<div class="week">';
    }

    $dateString = $currentDate->format('Y-m-d');
    $count = $activity_by_date[$dateString] ?? 0;
    $color = getColor($count);
    $calendar .= "<div class='day' style='background-color: $color;' data-date='$dateString' data-count='$count'></div>";

    $currentDate->modify('+1 day');
  }
  $calendar .= '</div></div>';
  return $calendar;
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
      <form>
        <label>
          <p>Select a year: </p>
          <select name="year" onchange="this.form.submit()">
            <option disabled>Select a year</option>
            <?php
            foreach (array_reverse($available_years) as $year) {
              $selected = ($selected_year == $year) ? 'selected' : '';
              echo "<option value='{$year}' $selected>{$year}</option>";
            }
            ?>
          </select>
        </label>
      </form>

      <h3>Activity Chart</h3>
      <?= createCalendar($selected_year, $activity_by_date) ?>
      <div id="tooltip" class="tooltip"></div>
    </section>
  </main>

  <script>
    const calendar = document.querySelector('.calendar');
    const tooltip = document.getElementById('tooltip');

    calendar.addEventListener('mouseover', (e) => {
      if (e.target.classList.contains('day')) {
        const date = e.target.getAttribute('data-date');
        const count = e.target.getAttribute('data-count');
        tooltip.textContent = `${date}: ${count} activities`;
        tooltip.style.display = 'block';
        tooltip.style.left = `${e.pageX + 10}px`;
        tooltip.style.top = `${e.pageY + 10}px`;
      }
    });

    calendar.addEventListener('mouseout', (e) => {
      if (e.target.classList.contains('day')) {
        tooltip.style.display = 'none';
      }
    });
  </script>
</body>

</html>