<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete query
    $sql = "DELETE FROM budgets WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Budget deleted successfully.";
    } else {
        echo "Error deleting budget: " . $conn->error;
    }
}

header("Location: DBMS.php"); // Redirect back to the budget list
exit();
?>
