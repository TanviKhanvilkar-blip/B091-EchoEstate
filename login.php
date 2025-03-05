<?php
include 'db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            echo "<script>alert('Login successful! Redirecting to your dashboard...'); window.location.href='home.html';</script>";
        } else {
            echo "<script>alert('Invalid password. Try again!'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('No account found with this email.'); window.location.href='signup.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
