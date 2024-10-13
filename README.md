# Flashify

Flashify is a minimal, beautiful, and responsive web-based flashcard application built using the LAMP stack as part of a college mini-project.

![Flashify Landing Page](./landing-page.png)

## Features

- Organizes content with decks, cards, and favorites
- Implements spaced repetition and active recall techniques for effective learning
- Orders cards based on past review sessions for optimized studying
- Enforces a one-hour delay between deck reviews to enhance retention
- Provides a GitHub-like activity chart to track daily card review progress
- Offers a marketplace for users to share and clone decks
- Allows users to publish their decks to the marketplace
- Includes a "like" system for public decks to help users find popular content.

## Run Locally

### Via Docker

The easiest way to run this project locally is with Docker and Docker Compose.

#### Prerequisites

1. Ensure Docker and Docker Compose are installed on your system.

#### Setup

1. Copy `.env.example` to `.env` and set up the database credentials.
2. Copy `SECRETS.php.example` to `SECRETS.php` (no need to edit, leave as is).

#### Run the Application

1. Open a terminal and navigate to the project directory.
2. Run the following command:
  
    ```bash
    sudo docker-compose up
    ```

#### Access the Application

- Main application:
  - If running locally: http://localhost
  - If running on a server: Use the server's IP address

- phpMyAdmin:
  - Access via http://localhost:8080
  - Use the credentials specified in the .env file