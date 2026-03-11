
# PalDeals

PalDeals is a simple web application for managing a game library, inspired by e-commerce platforms like Amazon. Users can browse games, add them directly to their personal library, and view their collection on their profile page. The project is built with PHP, SQLite, and follows a basic MVC structure.

## Features

- **Game Listing:** Browse available games on the home page.
- **Add to Library:** Add games to your personal library with a single click.
- **Profile Page:** View all games in your library.
- **Database Management:** Uses SQLite for storing users, games, and user-game relationships.
- **MVC Structure:** Organized into Models, Views, and Controllers for maintainability.

## Project Structure

```
PalDeals/
├── composer.json
├── README.md
├── config/
│   ├── config.php
│   └── example.config.php
├── database/
│   ├── paldeals.db
│   ├── schema.sqlite.sql
│   ├── migrations/
│   └── seeders/
├── public/
│   ├── index.php
│   └── assets/
│       ├── css/
│       ├── images/
│       └── js/
├── src/
│   ├── Application.php
│   ├── Controllers/
│   ├── Models/
│   └── Views/
```

## Setup Instructions

1. **Clone the repository:**
	```bash
	git clone <repo-url>
	cd PalDeals
	```

2. **Install dependencies:**
	If you use Composer for PHP dependencies:
	```bash
	composer install
	```

3. **Configure the database:**
	- The default database is SQLite. The schema is defined in `database/schema.sqlite.sql`.
	- To initialize the database:
	  ```bash
	  sqlite3 database/paldeals.db < database/schema.sqlite.sql
	  ```
	- Seeders and migrations are available in `database/seeders/` and `database/migrations/`.

4. **Configure the application:**
	- Copy `config/example.config.php` to `config/config.php` and update settings as needed.

5. **Run the application:**
	- Use PHP's built-in server for local development:
	  ```bash
	  php -S localhost:8000 -t public
	  ```
	- Visit [http://localhost:8000](http://localhost:8000) in your browser.

## Usage

- **Home Page:**
  - Lists all available games.
  - Click "Add to Library" to add a game to your profile.

- **Profile Page:**
  - Shows all games you have added to your library.

## Database Schema

- **users**: Stores user information.
- **games**: Stores game details (title, image, etc).
- **user_game**: Maps users to games in their library.

## MVC Overview

- **Controllers:** Handle requests and business logic (e.g., `LoginController`, `LibraryController`).
- **Models:** Represent data and interact with the database.
- **Views:** Render HTML pages (e.g., `home.php`, `profile.php`).

## Customization

- Add new games by updating the `games` table or using seeders.
- Modify styles in `public/assets/css/`.
- Update views in `src/Views/` for custom layouts.

## Troubleshooting

- If you see database errors, ensure `paldeals.db` is created and matches the schema.
- Check file permissions for the `database/` folder.
- Review logs for PHP errors in your web server or terminal.

## License

This project is for educational purposes. See LICENSE for details.

## Credits

Developed by Ynov students. Inspired by e-commerce and game library platforms.