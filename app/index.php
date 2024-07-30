<?php

require_once '../includes/database.php';

session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: /login.php");
    exit;
}


echo "Welcome";
