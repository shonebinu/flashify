<?php

function updateUserName($user_id, $user_name, $db)
{
  return $db->execute("UPDATE users SET name = :user_name WHERE id = :user_id", ["user_name" => $user_name, "user_id" => $user_id]);
}

function updateUserPassword($user_id, $old_password, $new_password, $db)
{
  $user = $db->fetch("SELECT * FROM users WHERE id = :user_id", ['user_id' => $user_id]);

  if (!password_verify($old_password, $user['password'])) {
    return false;
  }

  $hashedNewPassword = password_hash($new_password, PASSWORD_BCRYPT);

  return $db->execute(
    "UPDATE users SET password = :password WHERE id = :user_id",
    ['password' => $hashedNewPassword, 'user_id' => $user_id]
  );
}
