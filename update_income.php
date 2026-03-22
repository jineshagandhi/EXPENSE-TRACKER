<?php
include 'db_connection.php';

// Initialize variables
$message = '';
$income = [];

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch existing income details for editing
    $sql = "SELECT * FROM income WHERE id='$id'";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $income = $result->fetch_assoc();
    } else {
        $message = "<div class='message error'>No income found with the provided ID.</div>";
    }
} else {
    $message = "<div class='message error'>ID parameter is missing in the URL.</div>";
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Make sure the ID is still present
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $income_source = $_POST['income_source'];
        $income_amount = $_POST['income_amount'];
        $income_date = $_POST['income_date'];

        // Update query
        $sql = "UPDATE income SET income_source='$income_source', income_amount='$income_amount', income_date='$income_date' WHERE id='$id'";
        
        if ($conn->query($sql) === TRUE) {
            $message = "<div class='message success'>Income updated successfully.</div>";
            // Fetch the updated income record to reflect changes
            $sql = "SELECT * FROM income WHERE id='$id'";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $income = $result->fetch_assoc();
            }
        } else {
            $message = "<div class='message error'>Error updating income: " . $conn->error . "</div>";
        }
    } else {
        $message = "<div class='message error'>ID is missing in the form submission.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Income</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #d0e7f9; /* Light blue background */
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
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

        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #b3d3ea;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input:focus {
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

        input {
            background-color: #f0f8ff; /* Light blue input field */
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

        .back-home {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007BFF;
        }
    </style>
</head>
<body>
    <h2>Update Income</h2>
    
    <!-- Display success or error message -->
    <?php if (!empty($message)) echo $message; ?>

    <form action="update_income.php?id=<?php echo htmlspecialchars($income['id']); ?>" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($income['id']); ?>">
        
        <label for="income_source">Income Source:</label>
        <input type="text" name="income_source" value="<?php echo htmlspecialchars($income['income_source']); ?>" required>
        
        <label for="income_amount">Income Amount:</label>
        <input type="number" name="income_amount" value="<?php echo htmlspecialchars($income['income_amount']); ?>" required>
        
        <label for="income_date">Income Date:</label>
        <input type="date" name="income_date" value="<?php echo htmlspecialchars($income['income_date']); ?>" required>
        
        <button type="submit">Update Income</button>
    </form>

    <!-- <a href="DBMS.php">Back to Income List</a> -->
    <a class="back-home" href="DBMS.php">Home</a> <!-- Home button -->
</body>
</html>
