# System Architecture

## Overview

The Personal Expense Tracker follows a classic **3-tier architecture** pattern:

```
┌─────────────────────────────────────────────────────┐
│                   Client (Browser)                  │
└──────────────────────┬──────────────────────────────┘
                       │ HTTP
┌──────────────────────▼──────────────────────────────┐
│              Apache Web Server                      │
│  ┌────────────────────────────────────────────┐     │
│  │          Presentation Layer                │     │
│  │   login.html  specialisation.html          │     │
│  │   DBMS.php    dbmsstyles.css               │     │
│  └──────────────────┬─────────────────────────┘     │
│  ┌──────────────────▼─────────────────────────┐     │
│  │         Business Logic Layer (PHP)         │     │
│  │   add_expense.php    delete_expense.php    │     │
│  │   add_income.php     delete_income.php     │     │
│  │   add_budget.php     delete_budget.php     │     │
│  │   update_expense.php update_income.php     │     │
│  │   update_budget.php  db_connection.php     │     │
│  └──────────────────┬─────────────────────────┘     │
└──────────────────────┼──────────────────────────────┘
                       │ MySQL Protocol
┌──────────────────────▼──────────────────────────────┐
│               Data Layer (MySQL)                    │
│                                                     │
│   User  Category  Income  Expense                   │
│   FinancialRecords  Budget                          │
│                                                     │
│   Stored Procedures  Functions  Triggers            │
└─────────────────────────────────────────────────────┘
```

## Component Diagram

```mermaid
graph TD
    A[Browser] -->|HTTP Request| B[Apache + PHP]
    B -->|SQL Queries| C[(MySQL Database)]

    subgraph Frontend
        D[login.html]
        E[specialisation.html]
        F[DBMS.php - Dashboard]
        G[dbmsstyles.css]
    end

    subgraph Backend PHP
        H[db_connection.php]
        I[add_expense.php]
        J[add_income.php]
        K[add_budget.php]
        L[update_expense.php]
        M[update_income.php]
        N[update_budget.php]
        O[delete_expense.php]
        P[delete_income.php]
        Q[delete_budget.php]
    end

    subgraph Database
        R[expenses]
        S[income]
        T[budgets]
        U[User]
        V[Category]
        W[FinancialRecords]
    end

    A --> D
    D -->|Login| F
    E -->|Select User Type| D
    F --> I
    F --> J
    F --> K
    F --> L
    F --> M
    F --> N
    I --> H
    J --> H
    K --> H
    H --> C
```

## User Flow

```mermaid
flowchart TD
    A[User visits site] --> B[Specialisation Page]
    B -->|Select General/Premium| C[Login Page]
    C -->|Enter Credentials| D[Dashboard - DBMS.php]
    D --> E{Choose Action}
    E -->|Add| F[Add Expense/Income/Budget]
    E -->|View| G[View Lists]
    E -->|Edit| H[Update Records]
    E -->|Remove| I[Delete Records]
    E -->|Settings| J[Update Profile]
    E -->|Logout| C
    F --> D
    G --> D
    H --> D
    I --> D
```

## Request-Response Flow

1. User opens `specialisation.html` and selects account type
2. User is redirected to `login.html` for authentication
3. After login, `DBMS.php` loads as the main dashboard
4. Dashboard fetches data from MySQL via `db_connection.php`
5. CRUD actions are handled by individual PHP files that redirect back to the dashboard

## Docker Architecture

When using Docker Compose, three containers run:

| Container | Image | Port | Purpose |
|-----------|-------|------|---------|
| `expense-tracker-web` | php:8.1-apache | 8080 | PHP app server |
| `expense-tracker-db` | mysql:8.0 | 3307 | MySQL database |
| `expense-tracker-pma` | phpmyadmin | 8081 | Database admin UI |
