<?php
include 'db_connection.php';

$successMessage = '';
$errorMessage = '';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure 'id' is set in POST data
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $category = $_POST['category'];
        $budget_amount = $_POST['budget_amount'];
        $budget_period = $_POST['budget_period'];

        // Update query
        $sql = "UPDATE budgets SET category='$category', budget_amount='$budget_amount', budget_period='$budget_period' WHERE id='$id'";
        
        if ($conn->query($sql) === TRUE) {
            $successMessage = "Budget updated successfully.";
        } else {
            $errorMessage = "Error updating budget: " . $conn->error;
        }
    }
}

// Fetch existing budget details for editing
$id = $_GET['id'];
$sql = "SELECT * FROM budgets WHERE id='$id'";
$result = $conn->query($sql);
$budget = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Budget</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #d0e7f9; /* Light blue background */
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        form {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border: 1px solid #b3d3ea;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        select, input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #b3d3ea;
            border-radius: 4px;
            box-sizing: border-box;
        }

        select:focus, input:focus {
            border-color: #007BFF;
            outline: none;
        }

        button {
            background-color: #007BFF; /* Light blue button */
            color: white;
            cursor: pointer;
            font-size: 16px;
            padding: 12px;
        }

        button:hover {
            background-color: #0056b3;
        }

        input, select {
            background-color: #f0f8ff; /* Light blue input and select fields */
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

        a {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Update Budget</h2>

    <?php if ($successMessage): ?>
        <div class="message success"><?php echo $successMessage; ?></div>
    <?php endif; ?>
    <?php if ($errorMessage): ?>
        <div class="message error"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <form action="update_budget.php?id=<?php echo $budget['id']; ?>" method="POST">
        <input type="hidden" name="id" value="<?php echo $budget['id']; ?>">
        
        <label for="category">Category:</label>
        <select name="category" required>
            <option value="Groceries" <?php if($budget['category'] == 'Groceries') echo 'selected'; ?>>Groceries</option>
            <option value="Transportation" <?php if($budget['category'] == 'Transportation') echo 'selected'; ?>>Transportation</option>
            <option value="Utilities" <?php if($budget['category'] == 'Utilities') echo 'selected'; ?>>Utilities</option>
            <option value="Entertainment" <?php if($budget['category'] == 'Entertainment') echo 'selected'; ?>>Entertainment</option>
            <!-- Add more categories as needed -->
        </select>
        
        <label for="budget_amount">Budget Amount:</label>
        <input type="number" name="budget_amount" value="<?php echo $budget['budget_amount']; ?>" required>
        
        <label for="budget_period">Budget Period:</label>
        <select name="budget_period" required>
            <option value="Weekly" <?php if($budget['budget_period'] == 'Weekly') echo 'selected'; ?>>Weekly</option>
            <option value="Monthly" <?php if($budget['budget_period'] == 'Monthly') echo 'selected'; ?>>Monthly</option>
            <option value="Yearly" <?php if($budget['budget_period'] == 'Yearly') echo 'selected'; ?>>Yearly</option>
            <!-- Add more periods as needed -->
        </select>
        
        <button type="submit">Update Budget</button>
    </form>

    <a href="DBMS.php">Home</a>
</body>
</html>
