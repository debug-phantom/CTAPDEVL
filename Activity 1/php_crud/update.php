<?php
include 'config.php';

// --- Part 1: Handle Form Submission (POST Request) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $role_id = mysqli_real_escape_string($conn, $_POST['role_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $city_address = mysqli_real_escape_string($conn, $_POST['city_address']);
    $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $password = $_POST['password']; 

    // --- Validation Checks ---
    if (!preg_match('/^[a-zA-Z0-9-]+$/', $role_id)) {
        echo "<span style='color: red;'>Error: Role ID can only contain letters, numbers, and hyphens.</span> <p><a href='display.php'>Go back to list</a></p>";
        mysqli_close($conn);
        exit;
    } elseif (!in_array($role, ['Student', 'Faculty'])) {
        echo "<span style='color: red;'>Error: Role must be 'Student' or 'Faculty'.</span> <p><a href='display.php'>Go back to list</a></p>";
        mysqli_close($conn);
        exit;
    }

    // Start building the SQL query
    $sql = "UPDATE users SET role_id='$role_id', name='$name', email='$email', age='$age', city_address='$city_address', birthdate='$birthdate', role='$role'";

    // Handle password update ONLY if a new password was provided
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql .= ", password='$hashed_password'";
    }
    
    // Finish the query, ensuring only the current record is updated
    $sql .= " WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully! <p><a href='display.php'>Go back to list</a></p>";
    } else {
        echo "Error updating record: " . mysqli_error($conn) . " <p><a href='display.php'>Go back to list</a></p>";
    }

// --- Part 2: Display Update Form (GET Request) ---
} elseif (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch the current record data
    $sql = "SELECT id, role_id, name, email, age, city_address, birthdate, role FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $current_role_id = $row['role_id'];
        $current_name = $row['name'];
        $current_email = $row['email'];
        $current_age = $row['age'];
        $current_city_address = $row['city_address'];
        $current_birthdate = $row['birthdate'];
        $current_role = $row['role'];

        // Display the form
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Update Record</title>
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
                <h1>Update User Record</h1>
                <form method="POST" action="update.php">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">

                    <label for="role_id">Role ID:</label>
                    <input type="text" id="role_id" name="role_id" value="<?php echo htmlspecialchars($current_role_id); ?>" required>

                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($current_name); ?>" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($current_email); ?>" required>
                    
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($current_age); ?>" required>
                    
                    <label for="city_address">City Address:</label>
                    <input type="text" id="city_address" name="city_address" value="<?php echo htmlspecialchars($current_city_address); ?>" required>
                    
                    <label for="birthdate">Birthdate:</label>
                    <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($current_birthdate); ?>" required>

                    <label for="role">Role:</label>
                    <select id="role" name="role" required>
                        <option value="Student" <?php if ($current_role == 'Student') echo 'selected'; ?>>Student</option>
                        <option value="Faculty" <?php if ($current_role == 'Faculty') echo 'selected'; ?>>Faculty</option>
                    </select>

                    <label for="password">New Password (Leave blank to keep current):</label>
                    <input type="password" id="password" name="password">

                    <input type="submit" value="Update Record">
                </form>
                <p><a href='display.php'>Cancel and go back to list</a></p>
            </div>
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
