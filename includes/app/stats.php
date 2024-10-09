<?php

function getActivityData($user_id, $start_date, $end_date, $db)
{
  $query = "
        SELECT DATE(time) as date, COUNT(*) as count
        FROM statistics
        WHERE user_id = :user_id
        AND DATE(time) BETWEEN DATE(:start_date) AND DATE(:end_date)
        GROUP BY DATE(time)
    ";

  return $db->fetchAll($query, [
    ':user_id' => $user_id,
    ':start_date' => $start_date,
    ':end_date' => $end_date
  ]);
}

function getUserRegisteredTime($user_id, $db)
{
  return $db->fetch("SELECT created_at FROM users WHERE id = :user_id", [':user_id' => $user_id]);
}
