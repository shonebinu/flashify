<?php
require 'db_connect.php';

$conn = db_connect();

$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];


$sql = "INSERT INTO users(name, password, email) VALUES('$username', '$password', '$email')";

if (mysqli_num_rows(mysqli_query($conn, "SELECT email FROM users WHERE email='$email'")) > 0) {
    $response = array("message" => "This email already exists. Please log in.");
}
else if (mysqli_query($conn, $sql)) {
    $response = array("message" => "Your account has been registered. You can log in now.");
} 

echo json_encode($response);

mysqli_close($conn);
?>
