<?php
// add_expense.php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $expense_name = $_POST['expense_name'];
    $amount = $_POST['amount'];
    $expense_date = $_POST['expense_date'];
    $category = $_POST['category'];

    $sql = "INSERT INTO expenses (expense_name, amount, expense_date, category) VALUES ('$expense_name', '$amount', '$expense_date', '$category')";

    if ($conn->query($sql) === TRUE) {
        header("Location: DBMS.php#expense-list");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
