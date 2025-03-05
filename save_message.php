<?php
include 'db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_id']) && isset($_POST['message'])) {
        $user_id = $_SESSION['user_id'];
        $message = $_POST['message'];

        $stmt = $conn->prepare("INSERT INTO conversations (user_id, message) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $message);
        
        if ($stmt->execute()) {
            echo "Message saved!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "User not logged in or message missing.";
    }
    $conn->close();
}
?>
