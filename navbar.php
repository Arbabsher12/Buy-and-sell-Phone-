<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Database connection
    include  './php/db.php';

    // Fetch user details (assuming you have a 'users' table with 'profile_picture' column)
    $query = "SELECT profile_picture FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($profile_picture);
    $stmt->fetch();
    $stmt->close();

    // Set default profile picture if none is found
    if (empty($profile_picture)) {
        $profile_picture = "none.jpg";  // Default image
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell & Buy Phones</title>
</head>
<body>
    <div class="navbar" id="navbar" >
        <div class="button">
            <button id="show" class="sidebar-toggle">☰</button>
        </div>
        
        <div class="logo">MarketPlace for Phones</div>
        <div class="nav-links">
            <a href="home.html">Home</a>
            <a href="sellNewPhone.html">Sell New</a>
            <a href="sellYourPhone.html">Sell Used</a>
            <a href="home.html">Buy New</a>
            <a href="home.html">Buy Used</a>
        </div>

        <div class="auth-buttons">
            <?php if (isset($_SESSION['user_id'])): ?>

                <img src="../uploads/<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile" class="profile-pic">

                <a href="" class="logout" >LOG OUT</a>

            <?php else: ?>
                <a href="../html/login.php" class="login" >Log in</a>
                <a href="signup.php" class="register" >Register</a>
            <?php endif; ?>
        </div>
    </div>


</body>
</html>
