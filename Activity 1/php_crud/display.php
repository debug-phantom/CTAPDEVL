<?php
include 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Display All Records</title>
</head>
<body>

<h1>User Records</h1>

<?php
$sql = "SELECT id, name, email FROM users";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Actions</th></tr>";

    // Output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["id"]. "</td>";
        echo "<td>" . $row["name"]. "</td>";
        echo "<td>" . $row["email"]. "</td>";
        echo "<td>";
        // Link to update the record, passing the ID
        echo "<a href='update.php?id=" . $row["id"] . "'>Edit</a> | ";
        // Link to delete the record, passing the ID
        echo "<a href='delete.php?id=" . $row["id"] . "' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results found in the database.";
}

mysqli_close($conn);
?>

</body>
</html>