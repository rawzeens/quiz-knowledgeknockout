<?php
include 'conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            echo 'success'; // Send success response
        } else {
            echo 'Invalid password.'; // Send error message
        }
    } else {
        echo 'No user found with that username.'; // Send error message
    }
}
?>
