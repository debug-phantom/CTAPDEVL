<?php
include 'config.php';

// --- Part 1: Handle Form Submission (POST Request) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // SQL to update a record
    $sql = "UPDATE users SET name='$name', email='$email' WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully! <a href='display.php'>Go back to list</a>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

// --- Part 2: Display Update Form (GET Request) ---
} elseif (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch the current record data
    $sql = "SELECT id, name, email FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $current_name = $row['name'];
        $current_email = $row['email'];

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

                <label for="name">Name:</label><br>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($current_name); ?>" required><br><br>

                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($current_email); ?>" required><br><br>

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