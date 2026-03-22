<?php
// add_income.php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $income_source = $_POST['income_source'];
    $income_amount = $_POST['income_amount'];
    $income_date = $_POST['income_date'];

    $sql = "INSERT INTO income (income_source, income_amount, income_date) VALUES ('$income_source', '$income_amount', '$income_date')";

    if ($conn->query($sql) === TRUE) {
        header("Location: DBMS.php#income-list");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
