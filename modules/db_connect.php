<?php

require('config.php'); 

function db_connect() {
  global $conn; // Use global variable to access in function

  $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

  if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error());
  }

  return $conn;
}

?>
