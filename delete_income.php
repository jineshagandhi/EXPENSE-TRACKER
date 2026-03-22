<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete query
    $sql = "DELETE FROM income WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Income deleted successfully.";
    } else {
        echo "Error deleting income: " . $conn->error;
    }
}

header("Location: DBMS.php"); // Redirect back to the income list
exit();
?>

