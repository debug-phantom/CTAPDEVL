<?php
include 'config.php';

// Check if an ID was passed via the URL (e.g., delete.php?id=123)
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // SQL to delete a record
    $sql = "DELETE FROM users WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully. <a href='display.php'>Go back to list</a>";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "No valid ID specified for deletion.";
}

mysqli_close($conn);
?>