
# PalDeals - Game Store Website

Welcome! **PalDeals** is a website where you can browse video games and build your personal game library, just like online stores such as Steam or Epic Games.

## What Can You Do?

- **Browse Games** - See all available games with prices and details
- **Add to Cart** - Click the "Add to Cart" button to purchase games
- **Create Account** - Sign up and set up your profile
- **Manage Your Library** - Keep track of games you've purchased
- **Search & Filter** - Find games by name, platform, or developer

---

## Requirements (What You Need)

Before you start, make sure you have these installed on your computer:

### **Option 1: Easy Setup (Recommended)**
You only need **PHP** and nothing else!

### **Option 2: Manual Setup**
- **PHP** (download from php.net or use your system package manager)
- **SQLite** (comes with most systems)
- **Composer** (optional, for managing PHP libraries)

**Don't know if you have PHP?** Open your terminal/command prompt and type:
```
php -v
```
If you see a version number, you're good to go!

---

## How to Run (Step by Step)

### **Step 1: Download the Project**

Get the project files from GitHub or download the ZIP file. Extract it to a folder on your computer.

### **Step 2: Open Terminal/Command Prompt**

- **Windows:** Right-click in the project folder → "Open PowerShell here" or "Open Command Prompt here"
- **Mac/Linux:** Open Terminal and navigate to the project folder with: `cd path/to/PalDeals`

### **Step 3: Set Up the Database**

Copy the configuration file:
```bash
copy config/example.config.php config/config.php
```
(On Mac/Linux, use `cp` instead of `copy`)

### **Step 4: Start the Server**

Run this command in your terminal:
```bash
php -S localhost:3000 -t public
```

You should see a message saying the server is running.

### **Step 5: Open the Website**

Open your web browser and go to:
```
http://localhost:3000
```

You should see the PalDeals homepage with games!

---

## How to Use the Website

### **Home Page**
1. See all available games
2. Click on a game to view details
3. Click **"Add to Cart"** to purchase

### **Cart Page**
Click the **"Cart"** button in the top right to see your purchases

### **Profile Page**
Click the **profile icon** (👤) in the top right to view your library

---

## If Something Goes Wrong

### **"Command not found: php"**
→ PHP is not installed. Download and install it from [php.net](https://www.php.net/downloads)

### **"Port 3000 is already in use"**
→ Change the port number in the command:
```bash
php -S localhost:3001 -t public
```
Then visit `http://localhost:3001`

### **"Database error" on the website**
→ The database hasn't been set up. Contact a developer or follow the "Advanced Setup" section below.

---

## Advanced Setup (If You Know What You're Doing)

If you're familiar with terminal commands:

```bash
# Install dependencies
composer install

# Initialize the database (SQLite)
sqlite3 database/paldeals.db < database/schema.sqlite.sql

# Run the development server
php -S localhost:3000 -t public
```

---

## Project Structure

```
PalDeals/
├── public/              ← Website files (CSS, JavaScript, images)
├── src/                 ← Core application code
│   ├── Controllers/     ← Handles user actions
│   └── Views/           ← Website pages
├── database/            ← Database files
├── config/              ← Configuration settings
└── README.md           ← This file!
```

---

## Support

If you encounter issues:
1. Make sure you followed all steps in "How to Run"
2. Check that PHP is installed: `php -v`
3. Make sure the terminal is in the correct folder
4. Try using a different port (3001, 3002, etc.) if you get a "port in use" error

---

## License

This project is for educational purposes.

Enjoy browsing games!
