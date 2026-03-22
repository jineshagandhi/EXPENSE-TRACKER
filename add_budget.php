<?php
// add_budget.php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = $_POST['category'];
    $budget_amount = $_POST['budget_amount'];
    $budget_period = $_POST['budget_period'];

    $sql = "INSERT INTO budgets (category, budget_amount, budget_period) VALUES ('$category', '$budget_amount', '$budget_period')";

    if ($conn->query($sql) === TRUE) {
        header("Location: DBMS.php#budgets");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
