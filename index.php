<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flashify</title>
  <link rel="icon" type="image/x-icon" href="/assets/flash-card.png">
  <link rel="stylesheet" href="/styles/landing-page.css">
</head>

<body>
  <header>
    <div>
      <div>
        <h3>Flashify</h3>
        <img src="assets/flash-card.png" alt="Flashify Logo" class="logo">
      </div>
    </div>
    <nav>
      <a href="#">Home</a>
      <a href="#features">Features</a>
      <a href="#faq">FAQs</a>
      <a href="login.php" class="sign-in">Sign In</a>
    </nav>
  </header>

  <main>
    <section class="hero">
      <div>
        <h1>Learn the Easy <br>Way!</h1>
        <p>Flashify got you covered, Let's hop in!</p>
        <button onclick="location.href='register.php'">Get Started</button>
        <div class="bubbles">
          <div class="bubble"></div>
          <div class="bubble"></div>
          <div class="bubble"></div>
          <div class="bubble"></div>
          <div class="bubble"></div>
          <div class="bubble"></div>
          <div class="bubble"></div>
          <div class="bubble"></div>
          <div class="bubble"></div>
          <div class="bubble"></div>
        </div>
      </div>
      <img src="assets/talk.png" alt="Teaching Image" class="hero-img">
    </section>
    <section class="features" id="features">
      <h2>Our Best Features</h2>
      <div class="cards">
        <div class="card">
          <img src="assets/easy-to-use.png" alt="Easy to Use">
          <h3>Intuitive Interface</h3>
          <p>Create and review flashcards effortlessly with our user-friendly design.</p>
        </div>
        <div class="card">
          <img src="assets/repeat.png" alt="Spaced repetition">
          <h3>Smart Learning</h3>
          <p>Optimize retention with spaced repetition and track progress with detailed stats.</p>
        </div>
        <div class="card">
          <img src="assets/online-shopping.png" alt="Marketplace">
          <h3>Collaborative Marketplace</h3>
          <p>Share, explore, and collaborate on community-created flashcard decks.</p>
        </div>
      </div>
    </section>

    <section class="faq" id="faq">
      <h2>Our Best Answers</h2>
      <div class="accordion">
        <div class="accordion-item">
          <button class="accordion-btn">What is Flashify?</button>
          <div class="accordion-content">
            <p>Flashify is a digital flashcard application designed to help users learn efficiently. It allows you to create, organize, and review flashcards to enhance your learning experience.</p>
          </div>
        </div>
        <div class="accordion-item">
          <button class="accordion-btn">What are flashcards?</button>
          <div class="accordion-content">
            <p>Flashcards are learning tools with a question or prompt on one side and the answer on the other. They're used to test knowledge and improve memory through repeated practice.</p>
          </div>
        </div>
        <div class="accordion-item">
          <button class="accordion-btn">What is active recall?</button>
          <div class="accordion-content">
            <p>Active recall is a learning technique where you actively try to remember information rather than passively reviewing it. This method strengthens memory and improves long-term retention. Flashcards are an excellent tool for practicing active recall.</p>
          </div>
        </div>
        <div class="accordion-item">
          <button class="accordion-btn">What is spaced repetition?</button>
          <div class="accordion-content">
            <p>Spaced repetition is a learning technique that involves reviewing information at increasing intervals over time. This method takes advantage of the psychological spacing effect to improve long-term retention of information. While Flashify doesn't automatically schedule reviews, users can apply this principle in their study habits.</p>
          </div>
        </div>
        <div class="accordion-item">
          <button class="accordion-btn">How does Flashify improve learning?</button>
          <div class="accordion-content">
            <p>Flashify improves learning by providing a platform for creating and reviewing flashcards, which facilitates active recall. Users can also implement spaced repetition techniques in their study routines. These methods, combined with regular flashcard use, can significantly enhance memory retention and help users master new information more effectively.</p>
          </div>
        </div>
        <div class="accordion-item">
          <button class="accordion-btn">What features does Flashify offer?</button>
          <div class="accordion-content">
            <p>Flashify offers an intuitive interface for creating and reviewing flashcards, supporting both active recall and spaced repetition learning techniques. It also provides basic progress tracking and a marketplace for sharing and discovering flashcard decks. These features combine to create a comprehensive learning tool.</p>
          </div>
        </div>
        <div class="accordion-item">
          <button class="accordion-btn">What is the Flashify marketplace?</button>
          <div class="accordion-content">
            <p>The Flashify marketplace is a platform where users can share their flashcard decks and access decks created by others. It provides a collaborative space for users to expand their learning resources and benefit from the community's knowledge.</p>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <div>
      <div>
        <img src="assets/flash-card.png" alt="Flashify logo" class="logo">
        <p>Flashify</p>
      </div>
      <p>Email: <span class="light">shonebinualias@gmail.com</span></p>
      <div>

        <a href="https://github.com/shonebinu" target="_blank">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <title>github</title>
            <path
              d="M12,2A10,10 0 0,0 2,12C2,16.42 4.87,20.17 8.84,21.5C9.34,21.58 9.5,21.27 9.5,21C9.5,20.77 9.5,20.14 9.5,19.31C6.73,19.91 6.14,17.97 6.14,17.97C5.68,16.81 5.03,16.5 5.03,16.5C4.12,15.88 5.1,15.9 5.1,15.9C6.1,15.97 6.63,16.93 6.63,16.93C7.5,18.45 8.97,18 9.54,17.76C9.63,17.11 9.89,16.67 10.17,16.42C7.95,16.17 5.62,15.31 5.62,11.5C5.62,10.39 6,9.5 6.65,8.79C6.55,8.54 6.2,7.5 6.75,6.15C6.75,6.15 7.59,5.88 9.5,7.17C10.29,6.95 11.15,6.84 12,6.84C12.85,6.84 13.71,6.95 14.5,7.17C16.41,5.88 17.25,6.15 17.25,6.15C17.8,7.5 17.45,8.54 17.35,8.79C18,9.5 18.38,10.39 18.38,11.5C18.38,15.32 16.04,16.16 13.81,16.41C14.17,16.72 14.5,17.33 14.5,18.26C14.5,19.6 14.5,20.68 14.5,21C14.5,21.27 14.66,21.59 15.17,21.5C19.14,20.16 22,16.42 22,12A10,10 0 0,0 12,2Z" />
          </svg>
        </a>

        <a href="https://linkedin.com/in/shonebinu" target="_blank">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <title>linkedin</title>
            <path
              d="M19 3A2 2 0 0 1 21 5V19A2 2 0 0 1 19 21H5A2 2 0 0 1 3 19V5A2 2 0 0 1 5 3H19M18.5 18.5V13.2A3.26 3.26 0 0 0 15.24 9.94C14.39 9.94 13.4 10.46 12.92 11.24V10.13H10.13V18.5H12.92V13.57C12.92 12.8 13.54 12.17 14.31 12.17A1.4 1.4 0 0 1 15.71 13.57V18.5H18.5M6.88 8.56A1.68 1.68 0 0 0 8.56 6.88C8.56 5.95 7.81 5.19 6.88 5.19A1.69 1.69 0 0 0 5.19 6.88C5.19 7.81 5.95 8.56 6.88 8.56M8.27 18.5V10.13H5.5V18.5H8.27Z" />
          </svg>
        </a>

        <a href="https://github.com/shonebinu/flashify" target="_blank">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <title>source-branch</title>
            <path
              d="M13,14C9.64,14 8.54,15.35 8.18,16.24C9.25,16.7 10,17.76 10,19A3,3 0 0,1 7,22A3,3 0 0,1 4,19C4,17.69 4.83,16.58 6,16.17V7.83C4.83,7.42 4,6.31 4,5A3,3 0 0,1 7,2A3,3 0 0,1 10,5C10,6.31 9.17,7.42 8,7.83V13.12C8.88,12.47 10.16,12 12,12C14.67,12 15.56,10.66 15.85,9.77C14.77,9.32 14,8.25 14,7A3,3 0 0,1 17,4A3,3 0 0,1 20,7C20,8.34 19.12,9.5 17.91,9.86C17.65,11.29 16.68,14 13,14M7,18A1,1 0 0,0 6,19A1,1 0 0,0 7,20A1,1 0 0,0 8,19A1,1 0 0,0 7,18M7,4A1,1 0 0,0 6,5A1,1 0 0,0 7,6A1,1 0 0,0 8,5A1,1 0 0,0 7,4M17,6A1,1 0 0,0 16,7A1,1 0 0,0 17,8A1,1 0 0,0 18,7A1,1 0 0,0 17,6Z" />
          </svg>
        </a>
      </div>
    </div>

    <div class="nav">
      <p>Links</p>
      <p class="light"><a href="#">Home</a></p>
      <p class="light"><a href="#features">Features</a></p>
      <p class="light"><a href="#faq">FAQs</a></p>
      <p class="light"><a href="login.php">Sign In</a></p>
      <p class="light"><a href="register.php">Register</a></p>
    </div>
  </footer>
  <script>
    const accordionItems = document.querySelectorAll(".accordion-item");

    accordionItems.forEach(item => {
      const accordionBtn = item.querySelector(".accordion-btn");

      accordionBtn.addEventListener("click", function() {
        item.classList.toggle("active");

        const accordionContent = item.querySelector(".accordion-content");
        if (item.classList.contains("active")) {
          accordionContent.style.display = "block";
        } else {
          accordionContent.style.display = "none";
        }
      });
    });
  </script>
</body>

</html>