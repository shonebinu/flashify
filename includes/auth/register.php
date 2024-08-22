<?php
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
    $_SESSION['user_name'] = $name;
    $_SESSION['user_email'] = $email;

    return true;
}
