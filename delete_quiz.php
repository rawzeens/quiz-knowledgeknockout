<?php
include 'conn.php';
session_start();

// Ensure the user is logged in and has the correct role
if ($_SESSION['role'] != 'teacher') {
    header('Location: login.php');
    exit();
}

// Check if the ID parameter is set
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $quiz_id = (int)$_GET['id']; // Ensure the ID is treated as an integer

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Delete related user answers
        $sql = "DELETE FROM user_answers WHERE question_id IN (SELECT id FROM questions WHERE quiz_id = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quiz_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete user answers: " . $stmt->error);
        }

        // Delete related options
        $sql = "DELETE FROM options WHERE question_id IN (SELECT id FROM questions WHERE quiz_id = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quiz_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete options: " . $stmt->error);
        }

        // Delete related questions
        $sql = "DELETE FROM questions WHERE quiz_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quiz_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete questions: " . $stmt->error);
        }

        // Delete related quiz attempts
        $sql = "DELETE FROM quiz_attempts WHERE quiz_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quiz_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete quiz attempts: " . $stmt->error);
        }

        // Delete the quiz
        $sql = "DELETE FROM quizzes WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quiz_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete quiz: " . $stmt->error);
        }

        // Commit the transaction
        $conn->commit();

        // Redirect to the dashboard after successful deletion
        header('Location: index.php');
        exit();
    } catch (Exception $e) {
        // Rollback the transaction in case of an error
        $conn->rollback();
        $error = "Failed to delete the quiz. Error: " . $e->getMessage();
    }

    $stmt->close();
} else {
    $error = "Invalid quiz ID.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-4">
        <div class="bg-white shadow rounded-lg p-6">
            <?php if (isset($error)): ?>
                <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <a href="index.php" class="text-blue-500 hover:underline mt-4 inline-block">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
<?php
include 'conn.php';
session_start();

// Ensure the user is logged in and has the correct role
if ($_SESSION['role'] != 'teacher') {
    header('Location: login.php');
    exit();
}

// Check if the ID parameter is set
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $quiz_id = (int)$_GET['id']; // Ensure the ID is treated as an integer

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Delete related user answers
        $sql = "DELETE FROM user_answers WHERE question_id IN (SELECT id FROM questions WHERE quiz_id = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quiz_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete user answers: " . $stmt->error);
        }

        // Delete related options
        $sql = "DELETE FROM options WHERE question_id IN (SELECT id FROM questions WHERE quiz_id = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quiz_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete options: " . $stmt->error);
        }

        // Delete related questions
        $sql = "DELETE FROM questions WHERE quiz_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quiz_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete questions: " . $stmt->error);
        }

        // Delete related quiz attempts
        $sql = "DELETE FROM quiz_attempts WHERE quiz_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quiz_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete quiz attempts: " . $stmt->error);
        }

        // Delete the quiz
        $sql = "DELETE FROM quizzes WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quiz_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete quiz: " . $stmt->error);
        }

        // Commit the transaction
        $conn->commit();

        // Redirect to the dashboard after successful deletion
        header('Location: index.php');
        exit();
    } catch (Exception $e) {
        // Rollback the transaction in case of an error
        $conn->rollback();
        $error = "Failed to delete the quiz. Error: " . $e->getMessage();
    }

    $stmt->close();
} else {
    $error = "Invalid quiz ID.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-4">
        <div class="bg-white shadow rounded-lg p-6">
            <?php if (isset($error)): ?>
                <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <a href="index.php" class="text-blue-500 hover:underline mt-4 inline-block">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
<?php
include 'conn.php';
session_start();

// Ensure the user is logged in and has the correct role
if ($_SESSION['role'] != 'teacher') {
    header('Location: login.php');
    exit();
}

// Check if the ID parameter is set
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $quiz_id = (int)$_GET['id']; // Ensure the ID is treated as an integer

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Delete related user answers
        $sql = "DELETE FROM user_answers WHERE question_id IN (SELECT id FROM questions WHERE quiz_id = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quiz_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete user answers: " . $stmt->error);
        }

        // Delete related options
        $sql = "DELETE FROM options WHERE question_id IN (SELECT id FROM questions WHERE quiz_id = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quiz_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete options: " . $stmt->error);
        }

        // Delete related questions
        $sql = "DELETE FROM questions WHERE quiz_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quiz_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete questions: " . $stmt->error);
        }

        // Delete related quiz attempts
        $sql = "DELETE FROM quiz_attempts WHERE quiz_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quiz_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete quiz attempts: " . $stmt->error);
        }

        // Delete the quiz
        $sql = "DELETE FROM quizzes WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quiz_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete quiz: " . $stmt->error);
        }

        // Commit the transaction
        $conn->commit();

        // Redirect to the dashboard after successful deletion
        header('Location: index.php');
        exit();
    } catch (Exception $e) {
        // Rollback the transaction in case of an error
        $conn->rollback();
        $error = "Failed to delete the quiz. Error: " . $e->getMessage();
    }

    $stmt->close();
} else {
    $error = "Invalid quiz ID.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-4">
        <div class="bg-white shadow rounded-lg p-6">
            <?php if (isset($error)): ?>
                <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <a href="index.php" class="text-blue-500 hover:underline mt-4 inline-block">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
<?php
include 'conn.php';
session_start();

// Ensure the user is logged in and has the correct role
if ($_SESSION['role'] != 'teacher') {
    header('Location: login.php');
    exit();
}

// Check if the ID parameter is set
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $quiz_id = (int)$_GET['id']; // Ensure the ID is treated as an integer

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Delete related user answers
        $sql = "DELETE FROM user_answers WHERE question_id IN (SELECT id FROM questions WHERE quiz_id = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quiz_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete user answers: " . $stmt->error);
        }

        // Delete related options
        $sql = "DELETE FROM options WHERE question_id IN (SELECT id FROM questions WHERE quiz_id = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quiz_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete options: " . $stmt->error);
        }

        // Delete related questions
        $sql = "DELETE FROM questions WHERE quiz_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quiz_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete questions: " . $stmt->error);
        }

        // Delete related quiz attempts
        $sql = "DELETE FROM quiz_attempts WHERE quiz_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quiz_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete quiz attempts: " . $stmt->error);
        }

        // Delete the quiz
        $sql = "DELETE FROM quizzes WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quiz_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete quiz: " . $stmt->error);
        }

        // Commit the transaction
        $conn->commit();

        // Redirect to the dashboard after successful deletion
        header('Location: index.php');
        exit();
    } catch (Exception $e) {
        // Rollback the transaction in case of an error
        $conn->rollback();
        $error = "Failed to delete the quiz. Error: " . $e->getMessage();
    }

    $stmt->close();
} else {
    $error = "Invalid quiz ID.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-4">
        <div class="bg-white shadow rounded-lg p-6">
            <?php if (isset($error)): ?>
                <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <a href="index.php" class="text-blue-500 hover:underline mt-4 inline-block">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
