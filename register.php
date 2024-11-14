<?php
include 'conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $role = $conn->real_escape_string($_POST['role']);

    // Check if username or email already exists
    $sql = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($user['username'] === $username) {
            echo 'Username already taken.'; // Send error message for username
        } elseif ($user['email'] === $email) {
            echo 'Email already registered.'; // Send error message for email
        }
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert new user into database
        $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashed_password', '$role')";
        if ($conn->query($sql) === TRUE) {
            // Fetch the newly inserted user's ID and role
            $user_id = $conn->insert_id;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['role'] = $role;
            echo 'success'; // Send success response
        } else {
            echo 'Error: ' . $conn->error; // Send error message
        }
    }
}
?>
