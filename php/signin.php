<?php
session_start(); // Start session to store user data
ob_start(); // Start output buffering
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

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate inputs
    if (empty($email) || empty($password)) {
        $errors[] = "Email and Password are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($errors)) {
        // Check if email exists
        $stmt = $conn->prepare("SELECT user_id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $name, $hashed_password);
            $stmt->fetch();

            // Verify password
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = $name;                
                exit(); // Stop script execution
            } else {
                $errors[] = "Incorrect password.";
            }
        } else {
            $errors[] = "No account found with this email.";
        }

        if ($stmt->execute()) {
            header("Location: ../html/home.php"); // Redirect back to signup page
            exit();
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }
        $stmt->close();
    }
}

$conn->close();
ob_end_flush(); // Start output buffering
?>


