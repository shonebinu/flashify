<?php
require 'db_connect.php';

$conn = db_connect();

$loginEmail = $_POST["login-email"];
$loginPassword = $_POST["login-password"];

$loginQuery = "SELECT * FROM users WHERE email='$loginEmail' AND password='$loginPassword'";
$loginResult = mysqli_query($conn, $loginQuery);

if (mysqli_num_rows($loginResult) > 0) {
    $userRow = mysqli_fetch_assoc($loginResult); // fetch_assoc returns associate array
    $response = array("message" => "Login successful");

    setcookie("user_id", $userRow['uid'], time() + (86400 * 30), "/"); // Cookie expires in 30 days
} else {
    $response = array("message" => "Invalid email or password. Please try again.");
}

echo json_encode($response);

mysqli_close($conn);
?>

