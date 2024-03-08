<?php
require_once 'db_connect.php';

$conn = db_connect();

$user_id = $_POST['user_id'];
$userResult = mysqli_query($conn, "SELECT * FROM users WHERE uid='$user_id'");

if (!$userResult) {
    die("User query failed: " . mysqli_error($conn));
}

$userRow = mysqli_fetch_assoc($userResult);

// Retrieve cards information
$cardsQuery = mysqli_query($conn, "SELECT * FROM cards WHERE uid='$user_id'");

if (!$cardsQuery) {
    die("Cards query failed: " . mysqli_error($conn));
}

$cardsArray = array(); // Container array for cards

while ($cardRow = mysqli_fetch_assoc($cardsQuery)) {
    $cardsArray[] = $cardRow;
}

mysqli_close($conn);

// Prepare the response
$response = array(
    "img" => get_gravatar($userRow["email"]),
    "name" => $userRow["name"],
    "cards" => $cardsArray
);

// Send JSON response
echo json_encode($response);

function get_gravatar($email, $s = 80, $d = 'mp', $r = 'g', $img = true, $atts = array()) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    $url .= "?s=$s&d=$d&r=$r";
    
    if ($img) {
        $url = '<img src="' . $url . '"';
        foreach ($atts as $key => $val) {
            $url .= ' ' . $key . '="' . $val . '"';
        }
        $url .= ' />';
    }

    return $url;
}
?>
