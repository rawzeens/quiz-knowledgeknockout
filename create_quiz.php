<?php

include 'conn.php';

session_start();

$is_logged_in = isset($_SESSION['user_id']);


if ($_SESSION['role'] != 'teacher') {

    header('Location: index.php');

    exit();

}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title = $_POST['title'];

    $description = $_POST['description'];

    $created_by = $_SESSION['user_id'];



    $sql = "INSERT INTO quizzes (title, description, created_by) VALUES (?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {

        $stmt->bind_param("ssi", $title, $description, $created_by);



        if ($stmt->execute()) {

            $quiz_id = $stmt->insert_id;



            foreach ($_POST['questions'] as $index => $question) {

                $question_text = $question['text'];

                $question_type = $question['type'];

                $correct_answer = isset($question['answer']) ? $question['answer'] : null; // Handle fill-in-the-blank answers



                $sql = "INSERT INTO questions (quiz_id, question_text, question_type, correct_answer) VALUES (?, ?, ?, ?)";

                if ($stmt = $conn->prepare($sql)) {

                    $stmt->bind_param("isss", $quiz_id, $question_text, $question_type, $correct_answer);

                    $stmt->execute();



                    $question_id = $stmt->insert_id;



                    if ($question_type == 'multiple_choice' || $question_type == 'true_false') {

                        foreach ($question['options'] as $option) {

                            $option_text = $option['text'];

                            $is_correct = isset($option['is_correct']) ? 1 : 0;



                            $sql = "INSERT INTO options (question_id, option_text, is_correct) VALUES (?, ?, ?)";

                            if ($stmt = $conn->prepare($sql)) {

                                $stmt->bind_param("isi", $question_id, $option_text, $is_correct);

                                $stmt->execute();

                            } else {

                                echo "Error preparing statement for options: " . $conn->error;

                            }

                        }

                    }

                } else {

                    echo "Error preparing statement for questions: " . $conn->error;

                }

            }



            header('Location: index.php');

            exit();

        } else {

            $error = "Failed to create quiz. Please try again.";

        }

    } else {

        echo "Error preparing statement for quizzes: " . $conn->error;

    }

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Quiz</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body class="bg-black text-white">

    <?php include "header.php"; ?>

    <div class="container mx-auto p-4 px-8 pt-12">

<button onclick="goBack()" class="bg-purple-400 mb-4 rounded-md text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition duration-200">

    ← Back

</button>



<script>

    function goBack() {

        window.history.back();

    }

</script>

        <h1 class="text-3xl font-bold mb-6">Create a New Quiz</h1>



        <div class="bg-[#6B23D6] shadow rounded-lg p-6 text-white">

            <?php if (isset($error)): ?>

                <div class="bg-red-100 text-red-700 p-4 rounded mb-4">

                    <?php echo $error; ?>

                </div>

            <?php endif; ?>



            <form action="create_quiz.php" method="POST" id="quizForm">

                <div class="mb-4">

                    <label for="title" class="block text-white font-bold mb-2">Quiz Title</label>

                    <input type="text" id="title" name="title" required class="w-full p-2 border text-black border-gray-300 rounded focus:outline-none focus:border-blue-500">

                </div>

                <div class="mb-4">

                    <label for="description" class="block text-white font-bold mb-2">Quiz Description</label>

                    <textarea id="description" name="description" rows="5" class="w-full p-2 border text-black border-gray-300 rounded focus:outline-none focus:border-blue-500"></textarea>

                </div>

                

                <div id="questionsContainer" class="mb-6"></div>

                <button type="button" id="addQuestionBtn" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Add Question</button>



                <div class="mt-6">

                    <button type="submit" class="w-full bg-[#514267db] hover:bg-[#978ba7db] text-white py-2 rounded ">Create Quiz</button>

                </div>

            </form>

        </div>

    </div>



    <script>

    $(document).ready(function() {

    let questionCount = 0;



    $('#addQuestionBtn').click(function() {

        questionCount++;

        $('#questionsContainer').append(`

            <div class="mb-4 p-4 bg-gray-50 rounded-lg relative" id="question${questionCount}">

                <button type="button" class="absolute top-2 right-2 text-red-500 hover:text-red-700" onclick="removeQuestion(${questionCount})">✖</button>

                <label class="block text-black font-bold mb-2">Question ${questionCount}</label>

                <input type="text" name="questions[${questionCount}][text]" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 mb-2" placeholder="Enter question text">

                <select name="questions[${questionCount}][type]" class="w-full text-black p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 mb-2 question-type" data-question="${questionCount}">

                    <option value="multiple_choice">Multiple Choice</option>

                    <option value="true_false">True/False</option>

                    <option value="fill_in_the_blank">Fill in the Blank</option>

                </select>

                <div class="optionsContainer"></div>

                <button type="button" class="addOptionBtn bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 mt-2" data-question="${questionCount}">Add Option</button>

            </div>

        `);

    });



    $(document).on('click', '.addOptionBtn', function() {

        const questionId = $(this).data('question');

        const optionsContainer = $(`#question${questionId} .optionsContainer`);

        const questionType = $(`#question${questionId} .question-type`).val();



        if (questionType === 'multiple_choice') {

            const optionCount = optionsContainer.children().length + 1;



            optionsContainer.append(`

                <div class="flex items-center mb-2">

                    <input type="text" name="questions[${questionId}][options][${optionCount}][text]" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 mr-2" placeholder="Enter option text">

                    <label class="inline-flex items-center">

                        <input type="checkbox" name="questions[${questionId}][options][${optionCount}][is_correct]" class="form-checkbox text-green-500">

                        <span class="ml-2">Correct</span>

                    </label>

                </div>

            `);

        }

        // No need for specific handling for true_false here, as it's handled in the change event

    });



    $(document).on('change', '.question-type', function() {

        const questionId = $(this).data('question');

        const questionType = $(this).val();

        const optionsContainer = $(`#question${questionId} .optionsContainer`);



        if (questionType === 'true_false') {

            optionsContainer.html(`

                <div class="flex items-center mb-2">

                    <label class="inline-flex items-center">

                        <input type="radio" name="questions[${questionId}][answer]" value="1" class="form-radio text-green-500">

                        <span class="ml-2">True</span>

                    </label>

                </div>

                <div class="flex items-center mb-2">

                    <label class="inline-flex items-center">

                        <input type="radio" name="questions[${questionId}][answer]" value="0" class="form-radio text-red-500">

                        <span class="ml-2">False</span>

                    </label>

                </div>

            `);

        } else if (questionType === 'multiple_choice') {

            optionsContainer.show();

            optionsContainer.empty(); // Ensure options container is cleared before adding new options

        } else if (questionType === 'fill_in_the_blank') {

            optionsContainer.html(`

                <div class="mb-2">

                    <input type="text" name="questions[${questionId}][answer]" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" placeholder="Enter the answer">

                </div>

            `);

        } else {

            optionsContainer.hide();

        }

    });

});



function removeQuestion(questionId) {

    $(`#question${questionId}`).remove();

}



    </script>

</body>

</html>

