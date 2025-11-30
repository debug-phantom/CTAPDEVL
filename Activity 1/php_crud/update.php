<?php
include 'config.php';

// --- Part 1: Handle Form Submission (POST Request) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $city_address = mysqli_real_escape_string($conn, $_POST['city_address']);
    $password = $_POST['password']; 

    // --- Student ID Validation Check (Allows hyphens) ---
    if (!preg_match('/^[a-zA-Z0-9-]+$/', $student_id)) {
        echo "Error: Student ID can only contain letters, numbers, and hyphens. <a href='display.php'>Go back</a>";
        mysqli_close($conn);
        exit;
    }

    // Start building the SQL query
    $sql = "UPDATE users SET student_id='$student_id', name='$name', email='$email', age='$age', city_address='$city_address'";

    // Handle password update ONLY if a new password was provided
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql .= ", password='$hashed_password'";
    }
    
    // Finish the query, ensuring only the current record is updated
    $sql .= " WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully! <a href='display.php'>Go back to list</a>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

// --- Part 2: Display Update Form (GET Request) ---
} elseif (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch the current record data
    $sql = "SELECT id, student_id, name, email, age, city_address FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $current_student_id = $row['student_id'];
        $current_name = $row['name'];
        $current_email = $row['email'];
        $current_age = $row['age'];
        $current_city_address = $row['city_address'];

        // Display the form
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Update Record</title>
        </head>
        <body>
            <h1>Update User Record</h1>
            <form method="POST" action="update.php">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <label for="student_id">Student ID:</label><br>
                <input type="text" id="student_id" name="student_id" value="<?php echo htmlspecialchars($current_student_id); ?>" required><br><br>

                <label for="name">Name:</label><br>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($current_name); ?>" required><br><br>

                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($current_email); ?>" required><br><br>
                
                <label for="age">Age:</label><br>
                <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($current_age); ?>" required><br><br>
                
                <label for="city_address">City Address:</label><br>
                <input type="text" id="city_address" name="city_address" value="<?php echo htmlspecialchars($current_city_address); ?>" required><br><br>

                <label for="password">New Password (Leave blank to keep current):</label><br>
                <input type="password" id="password" name="password"><br><br>

                <input type="submit" value="Update Record">
            </form>
            <p><a href='display.php'>Cancel and go back to list</a></p>
        </body>
        </html>
        <?php
    } else {
        echo "Record not found.";
    }
} else {
    echo "No valid ID specified for update.";
}

mysqli_close($conn);
?>
