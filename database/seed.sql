-- ============================================
-- Personal Expense Tracker - Sample Seed Data
-- ============================================

USE expense_tracker;

-- ----------------------------
-- Categories
-- ----------------------------
INSERT INTO Category (CategoryID, Name, Description) VALUES
(1, 'Salary', 'Monthly salary and wages'),
(2, 'Freelance', 'Freelance and contract work'),
(3, 'Groceries', 'Food and grocery shopping'),
(4, 'Transportation', 'Commute, fuel, and travel'),
(5, 'Utilities', 'Electricity, water, internet bills'),
(6, 'Entertainment', 'Movies, dining out, subscriptions'),
(7, 'Healthcare', 'Medical expenses and insurance'),
(8, 'Education', 'Books, courses, tuition');

-- ----------------------------
-- Users
-- ----------------------------
INSERT INTO User (UserID, Name, Email, Password, UserType) VALUES
(1, 'Jinesha Gandhi', 'jinesha.gandhi@example.com', 'password123', 'Premium'),
(2, 'Test User', 'test@example.com', 'test123', 'General');

-- ----------------------------
-- Income records (normalized)
-- ----------------------------
INSERT INTO Income (IncomeID, Amount, Date, Source, CategoryID) VALUES
(1, 50000.00, '2024-10-01', 'Salary', 1),
(2, 15000.00, '2024-10-10', 'Freelance Project', 2),
(3, 50000.00, '2024-11-01', 'Salary', 1);

-- ----------------------------
-- Expense records (normalized)
-- ----------------------------
INSERT INTO Expense (ExpenseID, Amount, Date, Description, CategoryID) VALUES
(1, 2000.00, '2024-10-15', 'Grocery Shopping', 3),
(2, 500.00, '2024-10-16', 'Bus Pass', 4),
(3, 1500.00, '2024-10-18', 'Electricity Bill', 5),
(4, 800.00, '2024-10-20', 'Movie Night', 6),
(5, 3000.00, '2024-11-05', 'Weekly Groceries', 3);

-- ----------------------------
-- Financial Records (linking users to transactions)
-- ----------------------------
INSERT INTO FinancialRecords (RecordID, UserID, IncomeID, ExpenseID) VALUES
(1, 1, 1, NULL),
(2, 1, 2, NULL),
(3, 1, NULL, 1),
(4, 1, NULL, 2),
(5, 1, NULL, 3),
(6, 1, NULL, 4),
(7, 1, 3, NULL),
(8, 1, NULL, 5);

-- ----------------------------
-- Budgets
-- ----------------------------
INSERT INTO Budget (BudgetID, UserID, CategoryID, Amount, Period) VALUES
(1, 1, 3, 10000.00, 'Monthly'),
(2, 1, 4, 3000.00, 'Monthly'),
(3, 1, 6, 5000.00, 'Monthly');

-- ----------------------------
-- Application-level sample data
-- (used by the PHP frontend)
-- ----------------------------
INSERT INTO expenses (expense_name, amount, expense_date, category) VALUES
('Grocery Shopping', 2000.00, '2024-10-15', 'Groceries'),
('Bus Pass', 500.00, '2024-10-16', 'Transportation'),
('Electricity Bill', 1500.00, '2024-10-18', 'Utilities'),
('Movie Night', 800.00, '2024-10-20', 'Entertainment'),
('Weekly Groceries', 3000.00, '2024-11-05', 'Groceries');

INSERT INTO income (income_source, income_amount, income_date) VALUES
('Salary', 50000.00, '2024-10-01'),
('Freelance Project', 15000.00, '2024-10-10'),
('Salary', 50000.00, '2024-11-01');

INSERT INTO budgets (category, budget_amount, budget_period) VALUES
('Groceries', 10000.00, 'Monthly'),
('Transportation', 3000.00, 'Monthly'),
('Entertainment', 5000.00, 'Monthly');
