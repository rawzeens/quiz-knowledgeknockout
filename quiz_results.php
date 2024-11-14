<?php
include 'conn.php';
session_start();
$is_logged_in = isset($_SESSION['user_id']);

if ($_SESSION['role'] != 'student') {
    header('Location: login.php');
    exit();
}

$attempt_id = isset($_GET['attempt_id']) ? (int)$_GET['attempt_id'] : 0;

// Fetch the quiz attempt details
$sql = "SELECT * FROM quiz_attempts WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $attempt_id, $_SESSION['user_id']);
$stmt->execute();
$attempt_result = $stmt->get_result();

if ($attempt_result->num_rows > 0) {
    $attempt = $attempt_result->fetch_assoc();
    
    // Fetch the quiz details
    $sql = "SELECT * FROM quizzes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $attempt['quiz_id']);
    $stmt->execute();
    $quiz_result = $stmt->get_result();
    $quiz = $quiz_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($quiz['title']); ?> - Results</title>
    <script src="https://cdn.tailwindcss.com"></script>    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-black text-gray-900">

    <!-- Header -->
    <?php include "header.php"; ?>

    <div class="container mx-auto p-6 pt-10 text-white  ">
    <button onclick="goBack()" class="bg-purple-400 mb-4 rounded-md text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition duration-200">
    ← Back
</button>

<script>
    function goBack() {
        window.history.back();
    }
</script>
        <div class="bg-[#6B23D6] shadow-lg rounded-3xl p-6 mb-6">
            <h1 class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($quiz['title']); ?> - Results</h1>
            <p class="text-lg mb-6">Your score: <span class="font-semibold text-blue-500"><?php echo htmlspecialchars($attempt['score']); ?></span></p>

            <?php
            // Fetch the user's answers with correct answers
            $sql = "SELECT q.question_text, ua.answer_text, ua.selected_option_id, ua.is_correct, q.question_type, o.option_text, c.option_text as correct_option_text
                    FROM user_answers ua
                    LEFT JOIN questions q ON ua.question_id = q.id
                    LEFT JOIN options o ON ua.selected_option_id = o.id
                    LEFT JOIN options c ON q.id = c.question_id AND c.is_correct = 1
                    WHERE ua.attempt_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $attempt_id);
            $stmt->execute();
            $answers_result = $stmt->get_result();

            if ($answers_result->num_rows > 0):
                while ($answer = $answers_result->fetch_assoc()): ?>
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($answer['question_text']); ?></h3>
                        <p class="mb-2">Your answer: 
                            <?php if ($answer['question_type'] == 'true_false'): ?>
                                <span class="bg-[#a876f2] p-2 rounded">
                                    <?php echo $answer['answer_text'] == '1' ? 'True' : 'False'; ?>
                                </span>
                            <?php elseif ($answer['question_type'] == 'multiple_choice'): ?>
                                <span class="bg-[#a876f2] p-2 rounded">
                                    <?php echo htmlspecialchars($answer['option_text']); ?>
                                </span>
                            <?php else: ?>
                                <span class="bg-[#a876f2] p-2 rounded"><?php echo htmlspecialchars($answer['answer_text']); ?></span>
                            <?php endif; ?>
                        </p>
                        <?php if (!$answer['is_correct']): ?>
                            <p class="text-sm text-red-500">Correct answer: 
                                <?php if ($answer['question_type'] == 'true_false'): ?>
                                    <span class="bg-[#a876f2] p-2 rounded">
                                        <?php echo $answer['correct_option_text'] == '1' ? 'True' : 'False'; ?>
                                    </span>
                                <?php elseif ($answer['question_type'] == 'multiple_choice'): ?>
                                    <span class="bg-[#a876f2] p-2 rounded">
                                        <?php echo htmlspecialchars($answer['correct_option_text']); ?>
                                    </span>
                                <?php else: ?>
                                    <span class="bg-[#a876f2] p-2 rounded"><?php echo htmlspecialchars($answer['correct_option_text']); ?></span>
                                <?php endif; ?>
                            </p>
                        <?php endif; ?>
                        <p class="text-sm <?php echo $answer['is_correct'] ? 'text-green-500' : 'text-red-500'; ?>">
                            Correct: <?php echo $answer['is_correct'] ? "Yes" : "No"; ?>
                        </p>
                        <hr class="my-4">
                    </div>
                <?php endwhile;
            else: ?>
                <p>No answers available for this attempt.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php
} else {
    echo "<p>Quiz attempt not found or you do not have permission to view this result.</p>";
}
?>
