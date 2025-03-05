<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('HTTP/1.1 401 Unauthorized');
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

// Return data as JSON
header('Content-Type: application/json');
echo json_encode([
    'username' => $username,
    'email' => $email,
]);
?>