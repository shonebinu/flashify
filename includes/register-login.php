<?php
function loginUser($email, $password, $db)
{
  $user = $db->fetch("SELECT id, name, password FROM users WHERE email = :email", ['email' => $email]);

  if ($user && password_verify($password, $user['password'])) {
    session_start();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_email'] = $email;
    return true;
  }
  return false;
}

function registerUser($name, $email, $password, $db)
{
  $existingUser = $db->fetch("SELECT * FROM users WHERE email = :email", ['email' => $email]);

  if ($existingUser) {
    return "This Email exists in our database.";
  }

  $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
  $db->execute("INSERT INTO users(name, email, password) VALUES(:name, :email, :password)", [
    "name" => $name,
    "email" => $email,
    "password" => $hashedPassword
  ]);

  session_start();
  $_SESSION['user_id'] = $db->lastInsertId();
  $_SESSION['user_name'] = $name;
  $_SESSION['user_email'] = $email;

  return true;
}
