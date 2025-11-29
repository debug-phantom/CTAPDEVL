<?php
include 'config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Get and sanitize input data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $city_address = mysqli_real_escape_string($conn, $_POST['city_address']);
    
    // 2. Hash the password before storing it securely
    $password = $_POST['password']; // Get the plain text password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // 3. SQL to insert ALL records
    $sql = "INSERT INTO users (name, email, age, city_address, password) 
            VALUES ('$name', '$email', '$age', '$city_address', '$hashed_password')";

    if (mysqli_query($conn, $sql)) {
        $message = "New record created successfully!";
    } else {
        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
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