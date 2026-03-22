<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Check if the ID is valid
    if (empty($id) || !is_numeric($id)) {
        echo "Invalid ID provided.";
        exit();
    }

    // Delete query
    $sql = "DELETE FROM expenses WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Expense deleted successfully.";
    } else {
        echo "Error deleting expense: " . $conn->error;
    }

    // Redirect back to the expense list
    header("Location: DBMS.php");
    exit();
} else {
    echo "No ID specified.";
    exit();
}
?>
