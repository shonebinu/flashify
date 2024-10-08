<?php
require_once '../includes/database.php';
require_once '../includes/app/stats.php';

session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: /login.php");
  exit;
}

$db = new Database();

$end_date = date('Y-m-d 23:59:59');
$start_date = isset($_GET['start_date'])
  ? date('Y-m-d 00:00:00', strtotime($_GET['start_date']))
  : date('Y-m-d 00:00:00', strtotime('-1 year'));


$activity_data = getActivityData($_SESSION['user_id'], $start_date, $end_date, $db);

$activity_by_date = [];
foreach ($activity_data as $day) {
  $activity_by_date[$day['date']] = $day['count'];
}

function generateCalendarHtml($start_date, $end_date, $activity_by_date)
{
  $calendar_html = '';
  $current_date = new DateTime($start_date);
  $end = new DateTime($end_date);

  $start_of_week = clone $current_date;
  $start_of_week->modify('Monday this week');

  while ($start_of_week <= $end) {
    $calendar_html .= '<div class="calendar-row">';

    for ($i = 0; $i < 7; $i++) {
      $date_key = $start_of_week->format('Y-m-d');
      $count = isset($activity_by_date[$date_key]) ? $activity_by_date[$date_key] : 0;
      $level = getActivityLevel($count);

      $calendar_html .= sprintf(
        '<div class="calendar-cell level-%s" data-date="%s" data-count="%d"></div>',
        $level,
        $date_key,
        $count
      );

      $start_of_week->modify('+1 day');
    }

    $calendar_html .= '</div>';
  }

  return $calendar_html;
}

function getActivityLevel($count)
{
  if ($count == 0) return 0;
  if ($count <= 5) return 1;
  if ($count <= 10) return 2;
  if ($count <= 15) return 3;
  return 4;
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
      <div class="date-range-selector">
        <form method="get">
          <label for="start_date">Start Date:</label>
          <input type="date" id="start_date" name="start_date"
            value="<?= htmlspecialchars(date('Y-m-d', strtotime($start_date))) ?>">
          <button type="submit">Update</button>
        </form>
      </div>

      <div class="activity-calendar">
        <div class="tooltip" id="tooltip"></div>
        <?= generateCalendarHtml($start_date, $end_date, $activity_by_date) ?>
      </div>
    </section>
  </main>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const tooltip = document.getElementById('tooltip');
      const cells = document.querySelectorAll('.calendar-cell');

      cells.forEach(cell => {
        cell.addEventListener('mouseover', function(e) {
          const date = this.getAttribute('data-date');
          const count = this.getAttribute('data-count');
          tooltip.innerHTML = `${date}: ${count} reviews`;
          tooltip.style.display = 'block';
          tooltip.style.left = e.pageX + 10 + 'px';
          tooltip.style.top = e.pageY + 10 + 'px';
        });

        cell.addEventListener('mouseout', function() {
          tooltip.style.display = 'none';
        });
      });
    });
  </script>
</body>

</html>