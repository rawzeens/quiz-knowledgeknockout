<?php
include 'conn.php';
session_start();

if ($_SESSION['role'] != 'teacher') {
    header('Location: login.php');
    exit();
}

$quiz_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch quiz title
$sql = "SELECT title FROM quizzes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$stmt->bind_result($quiz_title);
$stmt->fetch();
$stmt->close();

// Fetch quiz statistics
$sql = "SELECT COUNT(*) AS total_attempts, 
               AVG(score) AS average_score, 
               MAX(score) AS highest_score 
        FROM quiz_attempts 
        WHERE quiz_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$stats_result = $stmt->get_result();
$stats = $stats_result->fetch_assoc();
$stmt->close();

// Fetch detailed results
$sql = "SELECT u.username, qa.score, qa.attempt_date 
        FROM quiz_attempts qa
        JOIN users u ON qa.user_id = u.id
        WHERE qa.quiz_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$detailed_results = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Statistics - <?php echo htmlspecialchars($quiz_title); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Header -->
    <?php include "header.php"; ?>

    <div class="container mx-auto p-6 pt-32">
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h1 class="text-3xl font-bold mb-6 text-center">Statistics for "<?php echo htmlspecialchars($quiz_title); ?>"</h1>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-blue-100 p-4 rounded-lg shadow-md text-center">
                    <h2 class="text-xl font-semibold mb-2">Total Attempts</h2>
                    <p class="text-2xl font-bold"><?php echo htmlspecialchars($stats['total_attempts']); ?></p>
                </div>
                <div class="bg-green-100 p-4 rounded-lg shadow-md text-center">
                    <h2 class="text-xl font-semibold mb-2">Average Score</h2>
                    <p class="text-2xl font-bold"><?php echo number_format(htmlspecialchars($stats['average_score']), 2); ?></p>
                </div>
                <div class="bg-yellow-100 p-4 rounded-lg shadow-md text-center">
                    <h2 class="text-xl font-semibold mb-2">Highest Score</h2>
                    <p class="text-2xl font-bold"><?php echo htmlspecialchars($stats['highest_score']); ?></p>
                </div>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Detailed Results</h2>
            
            <?php if ($detailed_results->num_rows > 0): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 border-b">Student</th>
                                <th class="px-4 py-2 border-b">Score</th>
                                <th class="px-4 py-2 border-b">Attempt Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $detailed_results->fetch_assoc()): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['username']); ?></td>
                                    <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['score']); ?></td>
                                    <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['attempt_date']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-gray-600 text-center">No attempts recorded for this quiz yet.</p>
            <?php endif; ?>

            <div class="text-center mt-4">
                <a href="dashboard.php" class="inline-block bg-blue-500 text-white px-6 py-3 rounded-md text-lg font-semibold hover:bg-blue-400 transition duration-300">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="container mx-auto text-center">
            <p>&copy; <?php echo date('Y'); ?> Quiz System. All rights reserved.</p>
            <div class="mt-4">
                <a href="privacy_policy.php" class="text-gray-400 hover:text-gray-300">Privacy Policy</a> | 
                <a href="terms_of_service.php" class="text-gray-400 hover:text-gray-300">Terms of Service</a>
            </div>
        </div>
    </footer>

</body>
</html>

<?php
$conn->close();
?>
