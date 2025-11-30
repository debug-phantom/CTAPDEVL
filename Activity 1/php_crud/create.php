<?php
include 'config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Get and sanitize input data
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $city_address = mysqli_real_escape_string($conn, $_POST['city_address']);
    $password = $_POST['password']; 

    // --- Student ID Validation Check (Allows hyphens) ---
    // This pattern allows letters, numbers, and hyphens (-)
    if (!preg_match('/^[a-zA-Z0-9-]+$/', $student_id)) {
        $message = "Error: Student ID can only contain letters, numbers, and hyphens.";
    } else {
        // Validation passed, proceed with hashing and insertion

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // 2. SQL to insert all records. Note: created_at is handled by MySQL.
        $sql = "INSERT INTO users (student_id, name, email, age, city_address, password) 
                VALUES ('$student_id', '$name', '$email', '$age', '$city_address', '$hashed_password')";

        if (mysqli_query($conn, $sql)) {
            $message = "New record created successfully! <a href='display.php'>View List</a>";
        } else {
            // Error handling for duplicate student_id or other issues
            $message = "Error: " . mysqli_error($conn); 
        }
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create New Record</title>
</head>
<body>

<h1>Add New User</h1>

<p style="color: green;"><?php echo $message; ?></p>

<form method="POST" action="create.php">
    <label for="student_id">Student ID (e.g., S2025-001):</label><br>
    <input type="text" id="student_id" name="student_id" required><br><br>
    
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="age">Age:</label><br>
    <input type="number" id="age" name="age" required><br><br>

    <label for="city_address">City Address:</label><br>
    <input type="text" id="city_address" name="city_address" required><br><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Submit">
</form>

<p><a href='display.php'>View All Records</a></p>

</body>
</html>
