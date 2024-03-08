<?php
require_once 'db_connect.php';

$conn = db_connect();

$user_id = $_POST['user_id'];

$result = mysqli_query($conn, "SELECT * FROM users WHERE uid='$user_id'");

$userRow = mysqli_fetch_assoc($result); // fetch_assoc returns associate array

$response = array("img" => get_gravatar($userRow["email"]), "name" => $userRow["name"]); 

echo json_encode($response);

mysqli_close($conn);

function get_gravatar( $email, $s = 80, $d = 'mp', $r = 'g', $img = true, $atts = array() ) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}
?>


