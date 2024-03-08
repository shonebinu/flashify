<?php
require_once 'db_connect.php';

$conn = db_connect();

$user_id = $_POST['user_id'];
$question = $_POST['question'];
$answer = $_POST['answer'];

// Perform the insertion into the 'cards' table
$insertQuery = "INSERT INTO cards (uid, question, answer) VALUES ('$user_id', '$question', '$answer')";
$insertResult = mysqli_query($conn, $insertQuery);

// Check if the insertion was successful
if ($insertResult) {
    $updatedCardsQuery = mysqli_query($conn, "SELECT cid, question, answer FROM cards WHERE uid='$user_id'");
    $updatedCards = [];
    while ($cardRow = mysqli_fetch_assoc($updatedCardsQuery)) {
        $updatedCards[] = $cardRow;
    }

    $response = array("message" => "Card added successfully", "updatedCards" => $updatedCards);
} else {
    $response = array("message" => "Failed to add card");
}

echo json_encode($response);

mysqli_close($conn);
?>

