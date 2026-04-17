-- Database setup for Registration Form
CREATE DATABASE IF NOT EXISTS web_form_db;
USE web_form_db;

CREATE TABLE IF NOT EXISTS registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    department VARCHAR(50) NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    hobbies TEXT,
    others TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create a dedicated user for the web application
-- This avoids the "Access Denied" error for root on local Linux setups
CREATE USER IF NOT EXISTS 'form_admin'@'localhost' IDENTIFIED BY 'form_password_123';
GRANT ALL PRIVILEGES ON web_form_db.* TO 'form_admin'@'localhost';
FLUSH PRIVILEGES;
