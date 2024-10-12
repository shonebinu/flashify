<?php
require_once '../includes/database.php';
require_once '../includes/gravatar.php';
require_once '../includes/app/decks.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit;
}

$gravatar_url = get_gravatar($_SESSION['user_email']);

$db = new Database();

$current_decks = getDecks($_SESSION['user_id'], $search_term = "", $db);
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
    <?php require_once 'components/bubbles.php' ?>
    <main>
        <section class="section welcome-user">
            <img src=<?php echo $gravatar_url ? $gravatar_url : "/assets/avatar.svg" ?> alt="Avatar image">
            <div class="greetings-div">
                <h1><span class="greeting"></span> <?php echo $_SESSION['user_name'] ?></h1>
                <p>We hope you have a productive session.</p>
            </div>
        </section>
        <section class="section">
            <h2>Review Cards</h2>
            <?php
            if (empty($current_decks)) {
                echo "<p>No Decks Available. Create a <a href='decks.php'>deck</a> to access card operations.</p>";
                exit;
            }
            ?>
            <p><span class="info">To search and navigate, visit <a href="decks.php">decks</a></span></p>
            <p><span class="info">Sorted based on favorite and created at</span></p>
            <form method="GET" action="review.php">
                <select class="deck-select" name="deck_id" required>
                    <option selected disabled value="">Select a deck</option>
                    <?php
                    foreach ($current_decks as $deck) {
                        echo "<option value='{$deck['id']}'>{$deck['name']}</option>";
                    }
                    ?>
                </select>
                <button class="button">Review</button>
            </form>
        </section>
    </main>

    <script>
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