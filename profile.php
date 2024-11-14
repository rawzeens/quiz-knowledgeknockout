<?php
include 'conn.php';
session_start();
$is_logged_in = isset($_SESSION['user_id']);

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update user details
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $new_password = $_POST['new_password'];

    if (!empty($new_password)) {
        // Hash new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql_update = "UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param('sssi', $username, $email, $hashed_password, $user_id);
    } else {
        $sql_update = "UPDATE users SET username = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param('ssi', $username, $email, $user_id);
    }

    if ($stmt->execute()) {
        $success_message = "Profile updated successfully.";
    } else {
        $error_message = "Failed to update profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body class="flex flex-col min-h-screen bg-gray-100">

    <!-- Header -->
    <?php include "header.php"; ?>

    <div class="container mx-auto p-6 pt-32 ">
        <h1 class="text-3xl font-semibold mb-6">Profile</h1>

        <?php if (isset($success_message)): ?>
            <div class="bg-green-100 text-green-800 p-4 rounded-md mb-4">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="bg-red-100 text-red-800 p-4 rounded-md mb-4">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <form action="profile.php" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" class="mt-1 block w-full p-3 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="mt-1 block w-full p-3 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Current Password:</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full p-3 border border-gray-300 rounded-md">
                <small class="text-gray-500">Leave blank if you don't want to change your password.</small>
            </div>
            <div class="mb-4">
                <label for="new_password" class="block text-gray-700">New Password:</label>
                <input type="password" id="new_password" name="new_password" class="mt-1 block w-full p-3 border border-gray-300 rounded-md">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-full text-lg font-semibold hover:bg-blue-400 transition duration-300">Update Profile</button>
        </form>
    </div>


</body>
</html>
