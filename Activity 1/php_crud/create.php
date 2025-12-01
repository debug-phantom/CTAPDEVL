<?php
include 'config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Get and sanitize input data
    $role_id = mysqli_real_escape_string($conn, $_POST['role_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $city_address = mysqli_real_escape_string($conn, $_POST['city_address']);
    $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $password = $_POST['password']; 

    // --- Validation Checks ---
    // 1. Role ID (must allow letters, numbers, hyphens)
    if (!preg_match('/^[a-zA-Z0-9-]+$/', $role_id)) {
        $message = "<span style='color: red;'>Error: Role ID can only contain letters, numbers, and hyphens.</span>";
    // 2. Role (must be Student or Faculty)
    } elseif (!in_array($role, ['Student', 'Faculty'])) {
        $message = "<span style='color: red;'>Error: Role must be 'Student' or 'Faculty'.</span>";
    } else {
        // Validation passed, proceed with hashing and insertion
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // 2. SQL to insert all records. Note: created_at is handled by MySQL.
        $sql = "INSERT INTO users (role_id, name, email, age, city_address, birthdate, role, password) 
                VALUES ('$role_id', '$name', '$email', '$age', '$city_address', '$birthdate', '$role', '$hashed_password')";

        if (mysqli_query($conn, $sql)) {
            $message = "<span style='color: green;'>Record created successfully!</span> <a href='display.php'>View List</a>";
        } else {
            // Error handling for unique constraint (duplicate Role ID) or other errors
            $message = "<span style='color: red;'>Error: " . mysqli_error($conn) . "</span>"; 
        }
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create New User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"], input[type="email"], input[type="number"], input[type="password"], input[type="date"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; 
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        p {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Add New User</h1>

    <p><?php echo $message; ?></p>

    <form method="POST" action="create.php">
        <label for="role_id">Role ID:</label> <input type="text" id="role_id" name="role_id" required>
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required>

        <label for="city_address">City Address:</label>
        <input type="text" id="city_address" name="city_address" required>
        
        <label for="birthdate">Birthdate:</label>
        <input type="date" id="birthdate" name="birthdate" required>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="Student">Student</option>
            <option value="Faculty">Faculty</option>
        </select>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Submit">
    </form>

    <p><a href='display.php'>View All Records</a></p>
</div>

</body>
</html>