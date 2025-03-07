**Internet Banking System using PHP and MySQL**

## Introduction
An **Internet Banking System** allows bank customers to perform banking transactions online. This project is built using PHP and MySQL, supporting multiple user roles, including **Admin, Staff, and Clients**. It provides functionalities like account management, fund transfers, transaction history, and user authentication.

## Features
### **Admin Panel:**
1. Manage staff accounts (add, edit, delete staff members)
2. Approve new client accounts
3. View all bank transactions
4. Manage system settings

### **Staff Panel:**
1. Approve or reject client transactions
2. Manage client details
3. Generate reports

### **Client Panel:**
1. Account login
2. View account balance and transaction history
3. Transfer funds to another account
4. Request services like checkbooks, account statements

## Database Structure (MySQL)
```sql
CREATE DATABASE internet_banking;

USE internet_banking;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff', 'client') NOT NULL,
    email VARCHAR(100) NOT NULL
);

CREATE TABLE accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    account_number VARCHAR(20) UNIQUE NOT NULL,
    balance DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (receiver_id) REFERENCES users(id)
);
```

## Implementation (PHP)

### **Database Connection (db.php)**
```php
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "internet_banking";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```

### **User Registration (register.php)**
```php
<?php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $role = 'client';
    
    $sql = "INSERT INTO users (username, password, email, role) VALUES ('$username', '$password', '$email', '$role')";
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
```

### **User Login (login.php)**
```php
<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            
            if ($row['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } elseif ($row['role'] == 'staff') {
                header("Location: staff_dashboard.php");
            } else {
                header("Location: client_dashboard.php");
            }
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
}
?>
```

### **Fund Transfer (transfer.php)**
```php
<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sender_id = $_SESSION['user_id'];
    $receiver_account = $_POST['receiver_account'];
    $amount = $_POST['amount'];
    
    $sql = "SELECT * FROM accounts WHERE account_number = '$receiver_account'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $receiver = $result->fetch_assoc();
        $receiver_id = $receiver['user_id'];
        
        $sql = "INSERT INTO transactions (sender_id, receiver_id, amount, status)
                VALUES ('$sender_id', '$receiver_id', '$amount', 'pending')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Transaction request submitted.";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Receiver account not found.";
    }
}
?>
```

### **Admin Dashboard (admin_dashboard.php)**
```php
<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
}
include 'db.php';

$sql = "SELECT * FROM transactions WHERE status = 'pending'";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "Transaction ID: " . $row['id'] . " | Amount: " . $row['amount'] . " | Status: " . $row['status'] . "<br>";
    echo "<a href='approve.php?id=" . $row['id'] . "'>Approve</a> | ";
    echo "<a href='reject.php?id=" . $row['id'] . "'>Reject</a><br><br>";
}
?>
```

### **Conclusion**
This **Internet Banking System** allows for secure transactions and management of users with different access levels. Features like **password encryption, role-based authentication, and transaction approvals** make the system secure. Future enhancements could include **SMS/email notifications, multi-factor authentication, and AI-based fraud detection**.

