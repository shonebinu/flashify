<?php
require_once '../includes/database.php';
require_once '../includes/gravatar.php';

session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: /login.php");
    exit;
}

$gravatar_url = get_gravatar($_SESSION['user_email']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flashify | Home</title>
    <link rel="icon" type="image/x-icon" href="/assets/flash-card.png">
    <link rel="stylesheet" href="/styles/app/home.css">
</head>

<body>
    <?php require_once 'components/nav.php' ?>
    <main>
        <section class="section welcome-user">
            <img src=<?php echo $gravatar_url ? $gravatar_url : "/assets/avatar.svg" ?> alt="Avatar image">
            <div class="greetings-div">
                <h1><span class="greeting"></span> <?php echo $_SESSION['user_name'] ?></h1>
                <p>We hope you have a productive session.</p>
            </div>
        </section>
        <?php require_once 'components/bubbles.php' ?>
    </main>

    <script defer>
        const hour = new Date().getHours();

        let greeting;
        if (hour < 12) {
            greeting = "Good Morning,";
        } else if (hour < 18) {
            greeting = "Good Afternoon,";
        } else {
            greeting = "Good Evening,";
        }

        document.querySelector('.greeting').textContent = greeting;
    </script>
</body>

</html>