<?php







// Fetch quizzes created by the teacher

$teacher_id = $_SESSION['user_id'];

$sql = "SELECT * FROM quizzes WHERE created_by = $teacher_id";

$quizzes_result = $conn->query($sql);

?>



<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Teacher Dashboard</title>

      <script src="https://cdn.tailwindcss.com"></script>    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>





</head>

<body class="bg-gray-100 text-gray-800">

    <div class="container mx-auto p-4 px-8 text-white">

        <h1 class="text-3xl font-bold mb-6">Teacher Dashboard</h1>



        <!-- Manage Quizzes Section -->

        <div class="bg-[#6B23D6] shadow rounded-lg p-6 mb-6 ">

            <h2 class="text-2xl font-semibold mb-4">Manage Quizzes</h2>

            <?php if ($quizzes_result->num_rows > 0): ?>

                <ul class="space-y-4">

                    <?php while ($quiz = $quizzes_result->fetch_assoc()): ?>

                        <li class="p-4 bg-[#766ec3] rounded-lg flex justify-between items-center">

                            <span class="font-medium"><?php echo $quiz['title']; ?></span>

                            <div>

                                <a href="edit_quiz.php?id=<?php echo $quiz['id']; ?>" class="text-blue-500 hover:underline">Edit</a> |

                                <a href="delete_quiz.php?id=<?php echo $quiz['id']; ?>" class="text-red-500 hover:underline" onclick="return confirm('Are you sure?')">Delete</a> |

                                <a href="view_results.php?id=<?php echo $quiz['id']; ?>" class="text-green-500 hover:underline">View Results</a>

                            </div>

                        </li>

                    <?php endwhile; ?>

                </ul>

            <?php else: ?>

                <p class="text-gray-600">You haven't created any quizzes yet.</p>

            <?php endif; ?>

            <a href="create_quiz.php" class="mt-4 inline-block text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded">Create New Quiz</a>

        </div>



        <!-- Student Performance Section -->

        <div class="bg-[#6B23D6] shadow rounded-lg p-6 mb-6">

            <h2 class="text-2xl font-semibold mb-4">Student Performance</h2>

            <a href="student_performance.php" class="text-white hover:underline">View Student Performance</a>

        </div>



        <!-- Quiz Statistics Section -->

        <div class="bg-[#6B23D6] shadow rounded-lg p-6">

            <h2 class="text-2xl font-semibold mb-4">Quiz Statistics</h2>

            <a href="quiz_statistics.php" class="text-white hover:underline">View Quiz Statistics</a>

        </div>

    </div>

</body>

</html>

