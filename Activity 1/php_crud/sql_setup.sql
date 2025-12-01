-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS jamescastro_db;

-- Use the database
USE jamescastro_db;

-- Create the users table with all required fields
CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    age INT(3) NULL,
    city_address VARCHAR(100) NULL,
    password VARCHAR(255) NOT NULL, -- 255 for securely stored password hash (e.g., bcrypt)
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

);
