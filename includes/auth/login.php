<?php
function loginUser($email, $password, $db)
{
    $user = $db->fetch("SELECT name, password FROM users WHERE email = :email", ['email' => $email]);

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $email;
        return true;
    }
    return false;
}
