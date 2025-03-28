<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "buy_sell_phone";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];
    
    $errors = [];

    // Validate input
    if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($password_confirmation)) {
        $errors[] = "All fields are required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if ($password !== $password_confirmation) {
        $errors[] = "Passwords do not match.";
    }
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters.";
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $errors[] = "Email is already registered. Please use a different email.";
    }
    $stmt->close();

    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $hashed_password);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Registration successful! You can now log in.";
            header("Location: ../html/login.php"); // Redirect back to signup page
            exit();
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }
        $stmt->close();
    }

    $_SESSION['errors'] = $errors;
    header("Location: ../html/signup.php"); // Redirect back to signup page
    exit();
}

$conn->close();
?>
