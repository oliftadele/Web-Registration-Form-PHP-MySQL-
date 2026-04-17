# Premium Web Registration Form (PHP/MySQL)

A sleek, modern registration form featuring a robust PHP backend and MySQL data storage. Designed with a focus on user experience, real-time feedback, and high-end aesthetics.

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![PHP](https://img.shields.io/badge/PHP-8.x-777bb4.svg)
![MySQL](https://img.shields.io/badge/MySQL-8.x-4479a1.svg)

## ✨ Features

- **Premium Design**: Modern, responsive UI with glassmorphism effects and smooth transitions.
- **Real-time Validation**: Instant feedback on form fields with error shaking animations.
- **Data Persistence**: Automatically saves drafts to `localStorage` so users don't lose their data.
- **PHP Backend**: Secure data processing using PHP 8.x and PDO.
- **MySQL Storage**: Persistent storage with a dedicated `registrations` table.
- **Admin View**: Built-in dashboard (`view.php`) to view and manage submitted registrations.
- **Success Animations**: Visual celebration using `canvas-confetti` upon successful registration.
- **One-Click Setup**: Automated shell script for easy environment installation on Linux.

## 🛠️ Tech Stack

- **Frontend**: HTML5, Vanilla CSS, Vanilla JavaScript
- **Backend**: PHP (PDO for secure database interaction)
- **Database**: MySQL / MariaDB
- **Libraries**: [Canvas Confetti](https://github.com/catdad/canvas-confetti) for animations.

## 🚀 Getting Started

### Prerequisites

This project is designed to run on a Linux environment (Ubuntu, Linux Mint, Debian, etc.). You will need `sudo` privileges for the initial setup.

### Installation

1.  **Clone the repository**:
    ```bash
    git clone https://github.com/your-username/web-form.git
    cd web-form
    ```

2.  **Run the automated setup**:
    This script will install PHP, MariaDB, and configure the database users and tables.
    ```bash
    bash setup.sh
    ```

3.  **Start the development server**:
    ```bash
    php -S localhost:8000
    ```

## 📖 Usage

-   Open your browser and go to `http://localhost:8000` to fill out the form.
-   Upon clicking **Register**, the data is sent to `submit.php` and saved to the database.
-   Visit `http://localhost:8000/view.php` to see all stored registrations.

## 📁 Project Structure

```text
├── index.html      # Main registration form
├── style.css       # Premium styling and animations
├── script.js      # Frontend logic (validation, draft, fetch)
├── config.php      # Database connection configuration
├── submit.php      # Backend form submission handler
├── view.php        # Admin dashboard to view submissions
├── db_setup.sql    # Database schema and user setup
└── setup.sh        # Automated environment installer
```

## 🔒 Security

-   Uses **PDO Prepared Statements** to prevent SQL Injection.
-   Inputs are sanitized using `filter_var` before processing.
-   Dedicated database user (`form_admin`) with limited privileges.

## 📄 License

This project is licensed under the MIT License - see the `LICENSE` file for details.

