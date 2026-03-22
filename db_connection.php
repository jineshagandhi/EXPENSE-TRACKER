<?php
// db_connection.php
$servername = "localhost"; // Your server name
$username = "root"; // Your MySQL username
$password = "welcome"; // Your MySQL password
$dbname = "expense_tracker"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
// } else {
//     echo "Connection successful!"; // Success message
}
?>
