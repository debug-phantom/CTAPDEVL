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

<p><a href='create.php'>Add a New User</a></p>

<?php
// IMPORTANT: Select all columns EXCEPT 'password' for security
$sql = "SELECT id, name, email, age, city_address FROM users";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>";
    echo "<tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>City Address</th>
            <th>Actions</th>
          </tr>";

    // Output data of each row
    while($row = mysqli_fetch_assoc($result)) { // Corrected function call
        echo "<tr>";
        echo "<td>" . $row["id"]. "</td>";
        echo "<td>" . $row["name"]. "</td>";
        echo "<td>" . $row["email"]. "</td>";
        echo "<td>" . $row["age"]. "</td>";
        echo "<td>" . $row["city_address"]. "</td>";
        echo "<td>";
        // Links for Update and Delete
        echo "<a href='update.php?id=" . $row["id"] . "'>Edit</a> | ";
        echo "<a href='delete.php?id=" . $row["id"] . "' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results found in the database. <a href='create.php'>Add one now!</a>";
}

mysqli_close($conn);
?>

</body>
</html>