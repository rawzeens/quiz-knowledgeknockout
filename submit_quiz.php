<?php
include 'conn.php';
session_start();

// Check if the user is logged in and is a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$quiz_id = isset($_POST['quiz_id']) ? (int)$_POST['quiz_id'] : 0;

// Validate quiz ID
if ($quiz_id <= 0) {
    echo "<p>Invalid quiz ID.</p>";
    exit();
}

// Prepare to fetch the questions for this quiz
$sql = "SELECT * FROM questions WHERE quiz_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Failed to prepare statement: " . $conn->error);
}
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$questions_result = $stmt->get_result();

// Check if there are questions for this quiz
if ($questions_result->num_rows === 0) {
    echo "<p>No questions found for this quiz.</p>";
    exit();
}

// Insert a new attempt record
$sql = "INSERT INTO quiz_attempts (user_id, quiz_id, score) VALUES (?, ?, 0)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Failed to prepare statement: " . $conn->error);
}
$stmt->bind_param("ii", $user_id, $quiz_id);
$stmt->execute();
$attempt_id = $stmt->insert_id;

$score = 0;

while ($question = $questions_result->fetch_assoc()) {
    $question_id = $question['id'];
    $correct = false;

    if ($question['question_type'] == 'multiple_choice' || $question['question_type'] == 'true_false') {
        $selected_option = isset($_POST["question_$question_id"]) ? trim($_POST["question_$question_id"]) : '';

        if ($question['question_type'] == 'true_false') {
            // Validate true/false answer
            $correct = ($selected_option === $question['correct_answer']);

            // Insert the user's answer
            $sql = "INSERT INTO user_answers (attempt_id, question_id, answer_text, is_correct) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Failed to prepare statement: " . $conn->error);
            }
            $stmt->bind_param("issi", $attempt_id, $question_id, $selected_option, $correct);
            $stmt->execute();
        } else {
            // Handle multiple choice questions
            $sql = "SELECT is_correct FROM options WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Failed to prepare statement: " . $conn->error);
            }
            $stmt->bind_param("i", $selected_option);
            $stmt->execute();
            $option_result = $stmt->get_result();
            $option = $option_result->fetch_assoc();
            $correct = $option['is_correct'] ? true : false;

            // Insert the user's answer
            $sql = "INSERT INTO user_answers (attempt_id, question_id, selected_option_id, is_correct) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Failed to prepare statement: " . $conn->error);
            }
            $stmt->bind_param("iiii", $attempt_id, $question_id, $selected_option, $correct);
            $stmt->execute();
        }
    } elseif ($question['question_type'] == 'fill_in_the_blank') {
        $answer_text = isset($_POST["question_$question_id"]) ? trim($_POST["question_$question_id"]) : '';
        $correct_answer = $question['correct_answer'];

        // Validate the user's answer
        $correct = (strcasecmp($answer_text, $correct_answer) == 0);

        // Insert the user's answer
        $sql = "INSERT INTO user_answers (attempt_id, question_id, answer_text, is_correct) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Failed to prepare statement: " . $conn->error);
        }
        $stmt->bind_param("issi", $attempt_id, $question_id, $answer_text, $correct);
        $stmt->execute();
    }

    if ($correct) {
        $score++;
    }
}

// Update the score in the quiz_attempts table
$sql = "UPDATE quiz_attempts SET score = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Failed to prepare statement: " . $conn->error);
}
$stmt->bind_param("ii", $score, $attempt_id);
$stmt->execute();

// Redirect to the quiz results page
header("Location: quiz_results.php?attempt_id=$attempt_id");
exit();
?>
