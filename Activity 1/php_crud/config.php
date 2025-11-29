<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // Check if your WAMP username is 'root'
$password = "";     // Check if your WAMP password is empty
$dbname = "test_db";
$port = 3306; // Default MySQL port

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname, $port);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>