<?php
include 'conn.php';
session_start();

if ($_SESSION['role'] != 'teacher') {
    header('Location: login.php');
    exit();
}

// Fetch all students
$sql_students = "SELECT id, username FROM users WHERE role = 'student'";
$students_result = $conn->query($sql_students);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Performance</title>
      <script src="https://cdn.tailwindcss.com"></script>    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>
<body class="bg-[#FFEBD4]  text-gray-800">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">Student Performance</h1>

        <?php if ($students_result->num_rows > 0): ?>
            <?php while ($student = $students_result->fetch_assoc()): ?>
                <div class="bg-white shadow rounded-lg p-6 mb-6">
                    <h2 class="text-2xl font-semibold mb-4"><?php echo htmlspecialchars($student['username']); ?>'s Performance</h2>

                    <?php
                    // Fetch quizzes attempted by the student
                    $student_id = $student['id'];
                    $sql_attempts = "SELECT q.title, qa.score, qa.attempt_date 
                                      FROM quiz_attempts qa
                                      JOIN quizzes q ON qa.quiz_id = q.id
                                      WHERE qa.user_id = $student_id";
                    $attempts_result = $conn->query($sql_attempts);
                    ?>

                    <?php if ($attempts_result->num_rows > 0): ?>
                        <table class="min-w-full bg-white divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quiz Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php while ($attempt = $attempts_result->fetch_assoc()): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($attempt['title']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo number_format($attempt['score'], 2); ?>%</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo date('Y-m-d', strtotime($attempt['attempt_date'])); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="text-gray-600">No quiz attempts found for this student.</p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-gray-600">No students found.</p>
        <?php endif; ?>

        <a href="dashboard.php" class="text-blue-500 hover:underline mt-4 inline-block">Back to Dashboard</a>
    </div>
</body>
</html>
