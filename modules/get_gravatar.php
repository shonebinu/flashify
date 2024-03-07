<?php
require_once 'db_connect.php';

function get_gravatar($userId, $s = 80, $d = 'mp', $r = 'g', $img = true, $atts = array()) {
    $conn = db_connect();
    // Retrieve email from the database using user ID
    $result = mysqli_query($conn, "SELECT email FROM users WHERE uid='$userId'");


    if (mysqli_num_rows($result) > 0) {
        $userRow = mysqli_fetch_assoc($result); // fetch_assoc returns associate array
        $email = $userRow["email"];
    
        // Use the retrieved email to generate the Gravatar
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        
        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val)
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }

        echo $url;
    } else {
        echo ''; // If user not found or no email, you can handle it as needed
    }

    mysqli_close($conn);
}

// Example usage with user ID from the POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    get_gravatar($user_id, 80, 'mp', 'g', true, array('class' => 'avatar'));
} else {
    echo ''; // If user ID not provided, you can handle it as needed
}
?>

