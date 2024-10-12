<?php
$currentURL = $_SERVER['REQUEST_URI'];

preg_match('/\/app\/([^\/\?\.\&]+)/', $currentURL, $matches);

$stringAfterApp = $matches[1];
?>

<aside>
  <nav class="app-nav">
    <h1>
      <div>
        Flashify
        <img src="/assets/flash-card.png" alt="Flashify logo">
      </div>
      <button class="hamburger-menu">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <title>menu</title>
          <path d="M3,6H21V8H3V6M3,11H21V13H3V11M3,16H21V18H3V16Z" />
        </svg>
      </button>
    </h1>

    <div class="extended-nav">

      <hr>

      <a href="./" <?php echo $stringAfterApp == "" || $stringAfterApp == "index" ? 'class=active' : '' ?>>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <title>view-dashboard</title>
          <path d="M13,3V9H21V3M13,21H21V11H13M3,21H11V15H3M3,13H11V3H3V13Z" />
        </svg>
        Home</a>

      <hr>

      <a href="decks.php" <?php echo $stringAfterApp == "decks" ? 'class=active' : '' ?>>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <title>layers</title>
          <path d="M12,16L19.36,10.27L21,9L12,2L3,9L4.63,10.27M12,18.54L4.62,12.81L3,14.07L12,21.07L21,14.07L19.37,12.8L12,18.54Z" />
        </svg>
        Decks
      </a>

      <a href="cards.php" <?php echo $stringAfterApp == "cards" ? 'class=active' : '' ?>>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <title>cards</title>
          <path d="M21.47,4.35L20.13,3.79V12.82L22.56,6.96C22.97,5.94 22.5,4.77 21.47,4.35M1.97,8.05L6.93,20C7.24,20.77 7.97,21.24 8.74,21.26C9,21.26 9.27,21.21 9.53,21.1L16.9,18.05C17.65,17.74 18.11,17 18.13,16.26C18.14,16 18.09,15.71 18,15.45L13,3.5C12.71,2.73 11.97,2.26 11.19,2.25C10.93,2.25 10.67,2.31 10.42,2.4L3.06,5.45C2.04,5.87 1.55,7.04 1.97,8.05M18.12,4.25A2,2 0 0,0 16.12,2.25H14.67L18.12,10.59" />
        </svg>
        Cards</a>

      <a href="stats.php" <?php echo $stringAfterApp == "stats" ? 'class=active' : '' ?>>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <title>google-analytics</title>
          <path d="M15.86 4.39V19.39C15.86 21.06 17 22 18.25 22C19.39 22 20.64 21.21 20.64 19.39V4.5C20.64 2.96 19.5 2 18.25 2S15.86 3.06 15.86 4.39M9.61 12V19.39C9.61 21.07 10.77 22 12 22C13.14 22 14.39 21.21 14.39 19.39V12.11C14.39 10.57 13.25 9.61 12 9.61S9.61 10.67 9.61 12M5.75 17.23C7.07 17.23 8.14 18.3 8.14 19.61C8.14 20.93 7.07 22 5.75 22S3.36 20.93 3.36 19.61C3.36 18.3 4.43 17.23 5.75 17.23Z" />
        </svg>
        Stats</a>

      <hr>

      <a href="publish.php" <?php echo $stringAfterApp == "publish" ? 'class=active' : '' ?>>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <title>earth</title>
          <path d="M17.9,17.39C17.64,16.59 16.89,16 16,16H15V13A1,1 0 0,0 14,12H8V10H10A1,1 0 0,0 11,9V7H13A2,2 0 0,0 15,5V4.59C17.93,5.77 20,8.64 20,12C20,14.08 19.2,15.97 17.9,17.39M11,19.93C7.05,19.44 4,16.08 4,12C4,11.38 4.08,10.78 4.21,10.21L9,15V16A2,2 0 0,0 11,18M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
        </svg>
        Publish</a>

      <a href="market.php" <?php echo $stringAfterApp == "market" ? 'class=active' : '' ?>>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <title>store</title>
          <path d="M12,18H6V14H12M21,14V12L20,7H4L3,12V14H4V20H14V14H18V20H20V14M20,4H4V6H20V4Z" />
        </svg>
        Market</a>

      <hr>

      <a href="logout.php" <?php echo $stringAfterApp == "logout" ? 'class=active' : '' ?>>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <title>logout</title>
          <path d="M17 7L15.59 8.41L18.17 11H8V13H18.17L15.59 15.58L17 17L22 12M4 5H12V3H4C2.9 3 2 3.9 2 5V19C2 20.1 2.9 21 4 21H12V19H4V5Z" />
        </svg>
        Logout</a>

      <a href="settings.php" <?php echo $stringAfterApp == "settings" ? 'class=active' : '' ?>>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <title>cog</title>
          <path d="M12,15.5A3.5,3.5 0 0,1 8.5,12A3.5,3.5 0 0,1 12,8.5A3.5,3.5 0 0,1 15.5,12A3.5,3.5 0 0,1 12,15.5M19.43,12.97C19.47,12.65 19.5,12.33 19.5,12C19.5,11.67 19.47,11.34 19.43,11L21.54,9.37C21.73,9.22 21.78,8.95 21.66,8.73L19.66,5.27C19.54,5.05 19.27,4.96 19.05,5.05L16.56,6.05C16.04,5.66 15.5,5.32 14.87,5.07L14.5,2.42C14.46,2.18 14.25,2 14,2H10C9.75,2 9.54,2.18 9.5,2.42L9.13,5.07C8.5,5.32 7.96,5.66 7.44,6.05L4.95,5.05C4.73,4.96 4.46,5.05 4.34,5.27L2.34,8.73C2.21,8.95 2.27,9.22 2.46,9.37L4.57,11C4.53,11.34 4.5,11.67 4.5,12C4.5,12.33 4.53,12.65 4.57,12.97L2.46,14.63C2.27,14.78 2.21,15.05 2.34,15.27L4.34,18.73C4.46,18.95 4.73,19.03 4.95,18.95L7.44,17.94C7.96,18.34 8.5,18.68 9.13,18.93L9.5,21.58C9.54,21.82 9.75,22 10,22H14C14.25,22 14.46,21.82 14.5,21.58L14.87,18.93C15.5,18.67 16.04,18.34 16.56,17.94L19.05,18.95C19.27,19.03 19.54,18.95 19.66,18.73L21.66,15.27C21.78,15.05 21.73,14.78 21.54,14.63L19.43,12.97Z" />
        </svg>
        Settings</a>
    </div>
  </nav>
</aside>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const dropDownButton = document.querySelector(".hamburger-menu");
    const extendedNav = document.querySelector(".extended-nav");

    dropDownButton.addEventListener("click", () => {
      extendedNav.classList.toggle("active");
    })
  })
</script>