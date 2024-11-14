<?php


// Fetch quizzes available for the student
$sql = "SELECT * FROM quizzes";
$result = $conn->query($sql);
?>


    <div class="w-full h-screen px-8">

        <div class="bg-[#a86efd5e] text-white shadow rounded-lg px-8 py-6 w-full  mx-auto" >
        <h1 class="text-3xl text-white font-bold mb-4">Student Dashboard</h1>
        <h2 class="text-2xl font-semibold mb-4">Available Quizzes</h2>   
        <?php if ($result->num_rows > 0): ?>
                <ul class="space-y-4">
                    <?php while ($quiz = $result->fetch_assoc()): ?>
                        <li class="p-4 bg-[#6B23D6] rounded-lg flex justify-between items-center">
                            <span class="font-bold text-xl"><?php echo $quiz['title']; ?></span>
                            <a href="take_quiz.php?id=<?php echo $quiz['id']; ?>" class="py-2 px-4 rounded-md bg-purple-400 hover:bg-purple-600">Take Quiz</a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="text-gray-600">No quizzes available.</p>
            <?php endif; ?>
        </div>
    </div>
