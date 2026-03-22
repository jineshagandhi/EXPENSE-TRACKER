-- ============================================
-- Personal Expense Tracker - Database Schema
-- ============================================

CREATE DATABASE IF NOT EXISTS expense_tracker;
USE expense_tracker;

-- ----------------------------
-- Table: User
-- ----------------------------
CREATE TABLE IF NOT EXISTS User (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    UserType ENUM('General', 'Premium') DEFAULT 'General',
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ----------------------------
-- Table: Category
-- ----------------------------
CREATE TABLE IF NOT EXISTS Category (
    CategoryID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(50) NOT NULL,
    Description VARCHAR(255)
);

-- ----------------------------
-- Table: Income
-- ----------------------------
CREATE TABLE IF NOT EXISTS Income (
    IncomeID INT PRIMARY KEY AUTO_INCREMENT,
    Amount DECIMAL(10, 2) NOT NULL,
    Date DATE NOT NULL,
    Source VARCHAR(100),
    CategoryID INT,
    FOREIGN KEY (CategoryID) REFERENCES Category(CategoryID)
);

-- ----------------------------
-- Table: Expense
-- ----------------------------
CREATE TABLE IF NOT EXISTS Expense (
    ExpenseID INT PRIMARY KEY AUTO_INCREMENT,
    Amount DECIMAL(10, 2) NOT NULL,
    Date DATE NOT NULL,
    Description VARCHAR(255),
    CategoryID INT,
    FOREIGN KEY (CategoryID) REFERENCES Category(CategoryID)
);

-- ----------------------------
-- Table: FinancialRecords
-- ----------------------------
CREATE TABLE IF NOT EXISTS FinancialRecords (
    RecordID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT NOT NULL,
    IncomeID INT,
    ExpenseID INT,
    FOREIGN KEY (UserID) REFERENCES User(UserID),
    FOREIGN KEY (IncomeID) REFERENCES Income(IncomeID),
    FOREIGN KEY (ExpenseID) REFERENCES Expense(ExpenseID)
);

-- ----------------------------
-- Table: Budget
-- ----------------------------
CREATE TABLE IF NOT EXISTS Budget (
    BudgetID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT NOT NULL,
    CategoryID INT NOT NULL,
    Amount DECIMAL(10, 2) NOT NULL,
    Period VARCHAR(50) NOT NULL,
    FOREIGN KEY (UserID) REFERENCES User(UserID),
    FOREIGN KEY (CategoryID) REFERENCES Category(CategoryID)
);

-- ----------------------------
-- Application-level tables
-- (used directly by the PHP frontend)
-- ----------------------------

CREATE TABLE IF NOT EXISTS expenses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    expense_name VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    expense_date DATE NOT NULL,
    category VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS income (
    id INT PRIMARY KEY AUTO_INCREMENT,
    income_source VARCHAR(255) NOT NULL,
    income_amount DECIMAL(10, 2) NOT NULL,
    income_date DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS budgets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category VARCHAR(100) NOT NULL,
    budget_amount DECIMAL(10, 2) NOT NULL,
    budget_period VARCHAR(50) NOT NULL
);

-- ----------------------------
-- Stored Procedures
-- ----------------------------

DELIMITER //

-- Procedure: Add Income
CREATE PROCEDURE IF NOT EXISTS AddIncome(
    IN p_Amount DECIMAL(10, 2),
    IN p_Date DATE,
    IN p_Source VARCHAR(255),
    IN p_CategoryID INT
)
BEGIN
    INSERT INTO Income (Amount, Date, Source, CategoryID)
    VALUES (p_Amount, p_Date, p_Source, p_CategoryID);
END //

-- Procedure: Delete Expense
CREATE PROCEDURE IF NOT EXISTS DeleteExpense(
    IN p_ExpenseID INT
)
BEGIN
    DELETE FROM Expense WHERE ExpenseID = p_ExpenseID;
END //

DELIMITER ;

-- ----------------------------
-- Functions
-- ----------------------------

DELIMITER //

-- Function: Calculate Total Income for a User
CREATE FUNCTION IF NOT EXISTS GetTotalIncome(p_UserID INT)
RETURNS DECIMAL(10, 2)
DETERMINISTIC
BEGIN
    DECLARE total_income DECIMAL(10, 2);
    SELECT COALESCE(SUM(i.Amount), 0) INTO total_income
    FROM Income i
    JOIN FinancialRecords fr ON i.IncomeID = fr.IncomeID
    WHERE fr.UserID = p_UserID;
    RETURN total_income;
END //

-- Function: Calculate Net Balance for a User
CREATE FUNCTION IF NOT EXISTS GetNetBalance(p_UserID INT)
RETURNS DECIMAL(10, 2)
DETERMINISTIC
BEGIN
    DECLARE net_balance DECIMAL(10, 2);
    DECLARE total_expense DECIMAL(10, 2);

    SELECT COALESCE(SUM(e.Amount), 0) INTO total_expense
    FROM Expense e
    JOIN FinancialRecords fr ON e.ExpenseID = fr.ExpenseID
    WHERE fr.UserID = p_UserID;

    SET net_balance = GetTotalIncome(p_UserID) - total_expense;
    RETURN net_balance;
END //

DELIMITER ;

-- ----------------------------
-- Triggers
-- ----------------------------

DELIMITER //

-- Trigger: Auto-create FinancialRecord after Income insert
CREATE TRIGGER IF NOT EXISTS AfterIncomeInsert
AFTER INSERT ON Income
FOR EACH ROW
BEGIN
    INSERT INTO FinancialRecords (UserID, IncomeID)
    VALUES (1, NEW.IncomeID);
END //

DELIMITER ;
