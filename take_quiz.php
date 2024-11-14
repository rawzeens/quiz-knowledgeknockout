<?php

include 'conn.php';

session_start();

$is_logged_in = isset($_SESSION['user_id']);



if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {

    header('Location: index.php');

    exit();

}



// Get the quiz ID from the URL and validate it

$quiz_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;



// Fetch the quiz details

$stmt = $conn->prepare("SELECT * FROM quizzes WHERE id = ?");

$stmt->bind_param("i", $quiz_id);

$stmt->execute();

$quiz_result = $stmt->get_result();



if ($quiz_result->num_rows > 0) {

    $quiz = $quiz_result->fetch_assoc();

    $title = htmlspecialchars($quiz['title']);

    $description = htmlspecialchars($quiz['description']);

} else {

    echo "<p>Quiz not found.</p>";

    exit();

}

?>



<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $title; ?></title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body class="flex flex-col items-center justify-center min-h-screen space-y-8 bg-black ">



    <!-- Header -->

    <?php include "header.php"; ?>

<div class="w-full px-8">

<button onclick="goBack()" class="bg-purple-400 mb-4 rounded-md text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition duration-200">

    ← Back

</button>



<script>

    function goBack() {

        window.history.back();

    }

</script>

    <div class="bg-[#6B23D6] text-white rounded-[30px] p-10 flex flex-col md:flex-row items-center justify-center space-y-8 md:space-y-0 md:space-x-8 w-full">

        

    <div class="mb-6 w-full">

            <h1 class="text-3xl font-bold mb-4"><?php echo $title; ?></h1>

            <p class="text-lg mb-6"><?php echo $description; ?></p>



            <?php

            // Fetch the questions associated with this quiz

            $stmt = $conn->prepare("SELECT * FROM questions WHERE quiz_id = ? ORDER BY id");

            $stmt->bind_param("i", $quiz_id);

            $stmt->execute();

            $questions_result = $stmt->get_result();



            if ($questions_result->num_rows > 0):

                $question_number = 1;

            ?>

                <form method="POST" action="submit_quiz.php">

                    <?php while ($question = $questions_result->fetch_assoc()): ?>

                        <div class="mb-6 p-8 rounded-xl bg-[#32007c7d]">

                            <h3 class="text-xl font-semibold mb-2"><?php echo "#{$question_number} " . htmlspecialchars($question['question_text']); ?></h3>



                            <?php if ($question['question_type'] == 'multiple_choice'): ?>

                                <?php

                                $question_id = $question['id'];

                                $stmt = $conn->prepare("SELECT * FROM options WHERE question_id = ?");

                                $stmt->bind_param("i", $question_id);

                                $stmt->execute();

                                $options_result = $stmt->get_result();

                                ?>

                                <div class="space-y-2">

                                    <?php while ($option = $options_result->fetch_assoc()): ?>

                                        <label class="flex items-center space-x-2">

                                            <input type="radio" name="question_<?php echo $question_id; ?>" value="<?php echo $option['id']; ?>" class="form-radio text-blue-500" required>

                                            <span><?php echo htmlspecialchars($option['option_text']); ?></span>

                                        </label>

                                    <?php endwhile; ?>

                                </div>

                            <?php elseif ($question['question_type'] == 'true_false'): ?>

                                <div class="space-y-2">

                                    <label class="flex items-center space-x-2">

                                        <input type="radio" name="question_<?php echo $question['id']; ?>" value="1" class="form-radio text-blue-500" required>

                                        <span>True</span>

                                    </label>

                                    <label class="flex items-center space-x-2">

                                        <input type="radio" name="question_<?php echo $question['id']; ?>" value="0" class="form-radio text-blue-500" required>

                                        <span>False</span>

                                    </label>

                                </div>

                            <?php elseif ($question['question_type'] == 'fill_in_the_blank'): ?>

                                <input type="text" name="question_<?php echo $question['id']; ?>" placeholder="Your answer here" class="w-full p-2 text-blue-500 border border-gray-300 rounded-md mt-2" required>

                            <?php endif; ?>

                        </div>

                        <?php $question_number++; ?>

                    <?php endwhile; ?>



                    <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">

                    <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-md text-lg font-semibold shadow-md hover:bg-blue-400 transition duration-300">

                        Submit Quiz

                    </button>

                </form>

            <?php else: ?>

                <p>No questions available for this quiz.</p>

            <?php endif; ?>

        </div>

    </div>

    </div>



</body>

</html>

