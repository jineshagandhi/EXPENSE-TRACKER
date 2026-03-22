<?php
// Include database connection file
include 'db_connection.php';

// Check if the ID is passed via GET or POST
if (isset($_GET['id'])) {
    // Get the expense ID from the URL
    $expense_id = $_GET['id'];

    // Fetch the current expense details
    $sql = "SELECT * FROM expenses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $expense_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $expense = $result->fetch_assoc();

    if (!$expense) {
        echo "No expense found with the given ID.";
        exit;
    }
} elseif (isset($_POST['id'])) {
    // Get the expense ID from the POST request after form submission
    $expense_id = $_POST['id'];
    
    // Update the expense details
    $expense_name = $_POST['expense_name'];
    $amount = $_POST['amount'];
    $expense_date = $_POST['expense_date'];
    $category = $_POST['category'];

    // Prepare the SQL statement for updating the record
    $sql = "UPDATE expenses SET expense_name = ?, amount = ?, expense_date = ?, category = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdssi", $expense_name, $amount, $expense_date, $category, $expense_id); // Correct data types: "sdssi" (string, double, string, string, integer)

    if ($stmt->execute()) {
        echo "<div class='message success'><H2> Expense updated successfully.</H2></div>";
        // echo "<br><a class='back-link' href='#expense-list'><H4>Back to Expense List</H4></a>";
    } else {
        echo "<div class='message error'>Error updating expense: " . $conn->error . "</div>";
    }
} else {
    echo "Invalid request.";
    exit;
}
?>

<!-- External CSS link or internal styles -->
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #eaf4fc;
        margin: 0;
        padding: 20px;
        color: #333;
    }

    h2 {
        margin-top: 40px;
        color: #2c3e50;
    }

    form {
        width: 100%;
        max-width: 600px;
        margin: 20px auto;
        background: #ffffff;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    input, select, button {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #b0d4f1;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input:focus, select:focus {
        border-color: #64b5f6;
        outline: none;
    }

    button {
        background-color: #64b5f6;
        color: white;
        cursor: pointer;
        font-size: 16px;
        padding: 12px;
    }

    button:hover {
        background-color: #42a5f5;
    }

    input, select {
        background-color: #f4f9fe;
    }

    button {
        margin-top: 20px;
    }

    .message {
        padding: 10px;
        margin: 10px 0;
        text-align: center;
        border-radius: 4px;
    }

    .success {
        background-color: #d4edda;
        color: #155724;
    }

    .error {
        background-color: #f8d7da;
        color: #721c24;
    }

    .back-link, .home-link {
        display: block;
        margin-top: 20px;
        text-align: center;
        color: #42a5f5;
        text-decoration: none;
    }

    .back-link:hover, .home-link:hover {
        text-decoration: underline;
    }

    /* Table Styling */
    th, td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #d4e9f7;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }
</style>

<!-- <h2>Update Expense</h2> -->
<form action="update_expense.php" method="POST">
    <!-- Hidden input field to pass the ID of the expense -->
    <input type="hidden" name="id" value="<?php echo isset($expense['id']) ? $expense['id'] : ''; ?>">
    
    <label for="expense_name">Expense Name:</label>
    <input type="text" name="expense_name" value="<?php echo isset($expense['expense_name']) ? $expense['expense_name'] : ''; ?>" required>
    
    <label for="amount">Amount:</label>
    <input type="number" name="amount" value="<?php echo isset($expense['amount']) ? $expense['amount'] : ''; ?>" required>
    
    <label for="expense_date">Date:</label>
    <input type="date" name="expense_date" value="<?php echo isset($expense['expense_date']) ? $expense['expense_date'] : ''; ?>" required>
    
    <label for="category">Category:</label>
    <select name="category" required>
        <option value="Groceries" <?php if (isset($expense['category']) && $expense['category'] == 'Groceries') echo 'selected'; ?>>Groceries</option>
        <option value="Transportation" <?php if (isset($expense['category']) && $expense['category'] == 'Transportation') echo 'selected'; ?>>Transportation</option>
        <option value="Utilities" <?php if (isset($expense['category']) && $expense['category'] == 'Utilities') echo 'selected'; ?>>Utilities</option>
        <option value="Entertainment" <?php if (isset($expense['category']) && $expense['category'] == 'Entertainment') echo 'selected'; ?>>Entertainment</option>
    </select>
    
    <button type="submit">Update Expense</button>
    <a href="DBMS.php" class="home-link">Go to Home</a>
</form>
