<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Expense Tracker</title>
    <link rel="stylesheet" href="dbmsstyles.css">
    <style>
        /* CSS styles for tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Additional styling for section headings */
        h2 {
            margin-top: 40px;
            color: #333;
        }

        /* Styling for the settings section */
        .settings-form {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        .settings-form input[type="text"],
        .settings-form input[type="password"],
        .settings-form input[type="email"],
        .settings-form input[type="number"],
        .settings-form select,
        .settings-form button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .settings-form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .settings-form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo-container">
                <img src="budget.png" alt="Logo" class="logo"> <!-- Add your logo file path here -->
                <div class="logo-text">Expense Tracker</div>
            </div>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#add-expense">Add Expense</a></li>
                <li><a href="#add-income">Add Income</a></li>
                <li><a href="#expense-list">Expense List</a></li>
                <li><a href="#income-list">Income List</a></li>
                <li><a href="#budgets">Budgets</a></li>
                <li><a href="#settings">Settings</a></li>
                <li><a href="login.html">Logout</a></li> <!-- Added Login link -->
            </ul>
        </nav>
    </header>

    <main>
        <section id="home" class="section1">
            <h1><b><center>Welcome to Your Expense Tracker</center></b></h1>
            <p><center>Track your expenses and manage your budget efficiently.</center></p>
            <center><img src="expense.jpeg" alt="Expenses" class="welcome-image"></center>
        </section>

        <section id="add-expense" class="section">
            <h2>Add New Expense</h2>
            <form action="add_expense.php" method="POST">
                <input type="text" name="expense_name" placeholder="Expense Name" required>
                <input type="number" name="amount" placeholder="Amount" required>
                <input type="date" name="expense_date" required>
                <select name="category" required>
                    <option value="" disabled selected>Select Category</option>
                    <option value="Groceries">Groceries</option>
                    <option value="Transportation">Transportation</option>
                    <option value="Utilities">Utilities</option>
                    <option value="Entertainment">Entertainment</option>
                    <!-- Add more categories as needed -->
                </select>
                <button type="submit">Add Expense</button>
            </form>
        </section>

        <section id="add-income" class="section">
            <h2>Add New Income</h2>
            <form action="add_income.php" method="POST">
                <input type="text" name="income_source" placeholder="Income Source" required>
                <input type="number" name="income_amount" placeholder="Amount" required>
                <input type="date" name="income_date" required>
                <button type="submit">Add Income</button>
            </form>
        </section>

        <section id="add-budget" class="section">
            <h2>Add New Budget</h2>
            <form action="add_budget.php" method="POST">
                <select name="category" required>
                    <option value="" disabled selected>Select Category</option>
                    <option value="Groceries">Groceries</option>
                    <option value="Transportation">Transportation</option>
                    <option value="Utilities">Utilities</option>
                    <option value="Entertainment">Entertainment</option>
                    <!-- Add more categories as needed -->
                </select>
                <input type="number" name="budget_amount" placeholder="Budget Amount (₹)" required>
                <select name="budget_period" required>
                    <option value="" disabled selected>Select Budget Period</option>
                    <option value="Weekly">Weekly</option>
                    <option value="Monthly">Monthly</option>
                    <option value="Yearly">Yearly</option>
                    <!-- Add more periods as needed -->
                </select>
                <button type="submit">Add Budget</button>
            </form>
        </section>

        <section id="expense-list" class="section">
            <h2>Your Expenses</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Expense Name</th>
                        <th>Amount (₹)</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db_connection.php';

                    $sql = "SELECT * FROM expenses";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row['id'] . "</td>
                                    <td>" . $row['expense_name'] . "</td>
                                    <td>" . $row['amount'] . "</td>
                                    <td>" . $row['expense_date'] . "</td>
                                    <td>
                                        <a href='update_expense.php?id=" . $row['id'] . "'>Update</a> 
                                        <a href='delete_expense.php?id=" . $row['id'] . "'>Delete</a>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No expenses found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
        
        <section id="income-list" class="section">
            <h2>Your Income</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Income Source</th>
                        <th>Amount (₹)</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db_connection.php';
            
                    $sql = "SELECT * FROM income";
                    $result = $conn->query($sql);
            
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row['id'] . "</td>
                                    <td>" . $row['income_source'] . "</td>
                                    <td>" . $row['income_amount'] . "</td>
                                    <td>" . $row['income_date'] . "</td>
                                    <td>
                                        <a href='update_income.php?id=" . $row['id'] . "'>Update</a> |
                                        <a href='delete_income.php?id=" . $row['id'] . "'>Delete</a>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No income found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>

        <section id="budgets" class="section">
            <h2>Your Budgets</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Budget Amount (₹)</th>
                        <th>Budget Period</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db_connection.php';
            
                    $sql = "SELECT * FROM budgets";
                    $result = $conn->query($sql);
            
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row['id'] . "</td>
                                    <td>" . $row['category'] . "</td>
                                    <td>" . $row['budget_amount'] . "</td>
                                    <td>" . $row['budget_period'] . "</td>
                                    <td>
                                        <a href='update_budget.php?id=" . $row['id'] . "'>Update</a> |
                                        <a href='delete_budget.php?id=" . $row['id'] . "'>Delete</a>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No budgets found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>

        <section id="settings" class="section">
            <h2>Settings</h2>
            <div class="settings-form">
                <form action="update_settings.php" method="POST">
                    <h3>Update User Information</h3>
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="current_password" placeholder="Current Password" required>
                    <input type="password" name="new_password" placeholder="New Password">
                    <input type="password" name="confirm_password" placeholder="Confirm New Password">
                    <button type="submit">Update Information</button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Personal Expense Tracker. All rights reserved.</p>
    </footer>
</body>
</html>
