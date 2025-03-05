<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

// Database connection
$host = '127.0.0.1';
$db = 'real_estate_db';
$user = 'root'; // Replace with your database username
$pass = ''; // Replace with your database password

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$sql = "SELECT username, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

$stmt->bind_result($username, $email);
if (!$stmt->fetch()) {
    die("No user found with ID: " . $user_id);
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* Your CSS styles here */
    </style>
</head>
<body>
    <div class="sidebar">
        <h1 class="title">Echo Estate</h1>
        <ul class="menu">
            <li onclick="window.location.href='home.html'"><i class="fas fa-home"></i> Home</li>
            <li onclick="window.location.href='conversations.html'"><i class="fas fa-comments"></i> Conversations</li>
            <li onclick="window.location.href='calendar.html'"><i class="fas fa-calendar-alt"></i> Calendar</li>
            <li onclick="window.location.href='flat_search.html'"><i class="fas fa-map"></i> Maps</li>
            <li onclick="window.location.href='profile.php'"><i class="fas fa-user"></i> Profile</li>
            <li onclick="window.location.href='signup.html'" class="login-signup"><i class="fas fa-sign-in-alt"></i> Login/Signup</li>
        </ul>
    </div>
    <div class="content">
        <!-- Profile Section -->
        <section class="profile-section">
            <h1>Profile</h1>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        </section>
    </div>
</body>
</html>