<?php 

// dashboard.php

include 'conn.php';

session_start();

$is_logged_in = isset($_SESSION['user_id']);

$role = $_SESSION['role'] ?? ''; // Get the role from session if set

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"> 

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 

    <style>

        body {

            font-family: 'Poppins';

            overflow-x: hidden;



        }



        .overlay {

            position: absolute;

            top: 0;

            left: 0;

            width: 100%;

            height: 100%;

            background: rgba(0, 0, 0, 0.7); 

            z-index: -1;

        }

        .accordion-content {

            display: none;

        }

        .accordion-content.active {

            display: block;

        }

        .accordion-toggle.active span:last-child {

            transform: rotate(45deg);

        }

        @keyframes scroll {

            0% { transform: translateX(100%); }

            100% { transform: translateX(-100%); }

        }

        .scrolling-wrapper {

            overflow: hidden;

            white-space: nowrap;

        }

        .scrolling-content {

            display: inline-block;

            animation: scroll 15s linear infinite;

        }

    </style>

</head>

<body class="flex flex-col items-center justify-center min-h-screen space-y-8 bg-black">

    <!-- Overlay -->

    <div class="overlay"></div>



    <!-- Header -->

    <?php include "header.php"; ?>



    <!-- Main Content Based on User Role -->

    <?php if ($is_logged_in): ?>

        <?php if ($role == 'student'): ?>

            <!-- Include Student Dashboard -->

            <?php include "student_dashboard.php"; ?>

        <?php elseif ($role == 'teacher'): ?>

            <!-- Include Teacher Dashboard -->

            <?php include "teacher_dashboard.php"; ?>

        <?php else: ?>

            <p class="text-center text-red-500">You do not have access to any dashboard.</p>

        <?php endif; ?>

    <?php else: ?>

        <div class="px-8 w-full">

        <!-- Section for Not Logged In Users -->

        <div class="bg-[#6B23D6] text-white rounded-[30px] p-10 flex flex-col md:flex-row items-center justify-center space-y-8 md:space-y-0 md:space-x-8 w-full px-4">

            <!-- Left Section: Text Content -->

            <div class="px-8 text-left">

                <h1 class="md:text-3xl  text-xl font-bold mb-4">KnowledgeKnockout QUIZ.</h1>

                <p class="text-sm mb-6">Test your knowledge across a wide range of subjects and challenge yourself to improve. Whether you’re a student, a teacher, or just looking to learn something new,
                     KnowledgeKnockout has you covered!</p>

                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">

                    <button id="openModalMobile" class="bg-white text-[#6B23D6] font-bold py-3 px-6 rounded-full hover:bg-gray-100">TRY IT'S FREE</button>

                    <a href="#" class="text-white font-bold text-center hover:text-gray-300 bg-black py-3 px-6 rounded-full">LEARN MORE</a>

                </div>

            </div>



            <!-- Right Section: Image Content -->

            <div class="hidden md:block">

                <img src="assets/Eve-removebg-preview.png" alt="AI Character" class="w-full">

            </div>

        </div>



        <!-- Navigation Tabs -->

        <div class="scrolling-wrapper w-full z-10 mt-8">

            <div class="scrolling-content flex space-x-8 py-4">

                <a href="#" class="text-xl font-bold text-gray-400 hover:text-gray-200">QUIZ</a>

                <a href="#" class="text-xl font-bold text-gray-400 hover:text-gray-200">NOTES</a>

                <!-- Repeat Tabs -->

            </div>

        </div>



       <!-- Feature Section -->

<div class="text-center mt-8 px-4">

    <h1 class="md:text-4xl text-2xl px-2 font-bold text-white">Meet the Features of KnowledgeKnockout</h1>

    <p class="text-sm text-gray-400 mt-4 max-w-2xl mx-auto">Discover the unique features that make KnowledgeKnockout Quiz an innovative platform for creating and taking quizzes. Enhance your learning experience with our interactive tools.</p>

</div>



<!-- Feature Cards -->

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto mt-12 p-10">

    <!-- Feature Card 1 -->

    <div class="bg-[#6B23D6] p-6 rounded-[30px] shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-105">

        <h2 class="text-xl font-bold mb-2 text-white">Interactive Quizzes</h2>

        <p class="text-gray-300 text-sm">Create engaging quizzes with a variety of question types, including multiple choice, fill-in-the-blank, and matching.</p>

    </div>

    

    <!-- Feature Card 2 -->

    <div class="bg-[#6B23D6] p-6 rounded-[30px] shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-105">

        <h2 class="text-xl font-bold mb-2 text-white">Real-Time Analytics</h2>

        <p class="text-gray-300 text-sm">Monitor quiz performance in real-time with detailed analytics, providing insights into participant scores and progress.</p>

    </div>



    <!-- Feature Card 3 -->

    <div class="bg-[#6B23D6] p-6 rounded-[30px] shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-105">

        <h2 class="text-xl font-bold mb-2 text-white">Customizable Themes</h2>

        <p class="text-gray-300 text-sm">Choose from various themes or customize your own to align with your brand or preferences, making quizzes visually appealing.</p>

    </div>



    <!-- Feature Card 4 -->

    <div class="bg-[#6B23D6] p-6 rounded-[30px] shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-105">

        <h2 class="text-xl font-bold mb-2 text-white">Secure and Private</h2>

        <p class="text-gray-300 text-sm">Ensure data privacy and security with our robust encryption standards, keeping your information safe and confidential.</p>

    </div>



    <!-- Feature Card 5 -->

    <div class="bg-[#6B23D6] p-6 rounded-[30px] shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-105">

        <h2 class="text-xl font-bold mb-2 text-white">Collaborative Tools</h2>

        <p class="text-gray-300 text-sm">Work with colleagues or classmates to create quizzes, share results, and encourage collaborative learning.</p>

    </div>



    <!-- Feature Card 6 -->

    <div class="bg-[#6B23D6] p-6 rounded-[30px] shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-105">

        <h2 class="text-xl font-bold mb-2 text-white">Mobile-Friendly Design</h2>

        <p class="text-gray-300 text-sm">Access quizzes on any device with our responsive design, optimized for smartphones, tablets, and desktops.</p>

    </div>

</div>



        <!-- Signup Call to Action -->

        <div class="bg-[#6B23D6] text-white rounded-[30px] p-10 flex flex-col md:flex-row items-center justify-between w-full ">

            <div class="md:w-1/2 mb-6 md:mb-0">

                <img src="assets/Eve-removebg-preview.png" alt="Robot Image" class="w-full h-auto">

            </div>

            <div class="md:w-1/2 text-center md:text-left px-4">

                <h1 class="text-2xl md:text-4xl font-bold mb-4">Sign up now & get the KnowledgeKnockout everyday.</h1>

                <p class="text-md md:text-lg font-semibold mb-2">NO MATTER WHAT YOU DO. WE HAVE KnowledgeKnockout VIBE.</p>

                <p class="text-xs text-gray-300 mb-6">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Enim, animi.</p>

                <button class="bg-white text-purple-800 text-center font-bold py-3 px-6 rounded-full">TRY IT'S FREE</button>

            </div>

        </div>



<!-- FAQ Section -->

<div class="bg-[#6B23D6] text-white rounded-[30px] p-10 flex flex-col items-center w-full  mt-12">

    <h1 class="text-3xl font-bold mb-8 text-center">Frequently Asked Questions</h1>

    

    <!-- FAQ Item Template -->

    <div class="w-full md:w-2/3 mb-4">

        <button class="w-full text-left py-4 px-6 bg-gray-800 rounded-lg flex justify-between items-center focus:outline-none faq-toggle">

            <span>What is KnowledgeKnockout?</span>

            <span class="text-xl transform transition-transform duration-200">+</span>

        </button>

        <div class="faq-content px-6 py-4 bg-gray-700 rounded-lg mt-2 hidden">

            <p>KnowledgeKnockout is an online learning platform that allows users to create and take quizzes on various topics. It's widely used for educational purposes and can be utilized for both individual and group learning experiences.</p>

        </div>

    </div>

    

    <!-- Additional FAQ Items -->

    <div class="w-full md:w-2/3 mb-4">

        <button class="w-full text-left py-4 px-6 bg-gray-800 rounded-lg flex justify-between items-center focus:outline-none faq-toggle">

            <span>How do I create a quiz?</span>

            <span class="text-xl transform transition-transform duration-200">+</span>

        </button>

        <div class="faq-content px-6 py-4 bg-gray-700 rounded-lg mt-2 hidden">

            <p>To create a quiz, simply sign up for an account, navigate to the 'Create Quiz' section, and follow the instructions to add questions, answers, and set quiz parameters.</p>

        </div>

    </div>



    <div class="w-full md:w-2/3 mb-4">

        <button class="w-full text-left py-4 px-6 bg-gray-800 rounded-lg flex justify-between items-center focus:outline-none faq-toggle">

            <span>Is KnowledgeKnockout free to use?</span>

            <span class="text-xl transform transition-transform duration-200">+</span>

        </button>

        <div class="faq-content px-6 py-4 bg-gray-700 rounded-lg mt-2 hidden">

            <p>Yes, KnowledgeKnockout offers a free tier with essential features, as well as premium plans that provide additional tools and resources for enhanced learning experiences.</p>

        </div>

    </div>



    <div class="w-full md:w-2/3 mb-4">

        <button class="w-full text-left py-4 px-6 bg-gray-800 rounded-lg flex justify-between items-center focus:outline-none faq-toggle">

            <span>Can I use KnowledgeKnockout for remote learning?</span>

            <span class="text-xl transform transition-transform duration-200">+</span>

        </button>

        <div class="faq-content px-6 py-4 bg-gray-700 rounded-lg mt-2 hidden">

            <p>Absolutely! KnowledgeKnockout is designed to be used in both classroom settings and remote learning environments, supporting asynchronous quizzes and live sessions.</p>

        </div>

    </div>

</div>
<!-- Modal Structure -->
<div id="signupModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-4/5 max-w-md mx-4 relative">
        <!-- Login Form -->
        <div id="loginForm">
                        <!-- Updated to use absolute positioning -->

                        <button id="closeModal" class="absolute top-2 right-2 text-gray-500 text-2xl hover:text-gray-700">

&times;

</button>
            <h2 class="text-xl font-bold mb-4">Login</h2>
            <!-- Display login message -->
            <div id="loginMessage" class="mb-4 text-center text-red-500 hidden"></div>
            <form id="loginFormElement">
                <div class="mb-4">
                    <label for="loginUsername" class="block text-gray-700 font-bold mb-2">Username</label>
                    <input type="text" id="loginUsername" name="username" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="loginPassword" class="block text-gray-700 font-bold mb-2">Password</label>
                    <input type="password" id="loginPassword" name="password" required class="w-full border border-gray-300 rounded p-2">
                </div>
                <button type="submit" class="bg-[#6B23D6] text-white font-bold py-2 px-4 rounded-lg w-full">Submit</button>
                <p class="text-center text-gray-600 mt-4">
                    <a href="forgot_password.php" class="text-blue-500 hover:underline">Forgot Password?</a>
                </p>
                <p class="text-center text-gray-600 mt-4">
                    Don't have an account? <a href="#" id="showRegister" class="text-blue-500 hover:underline">Register here</a>.
                </p>
            </form>
        </div>
        
        <!-- Register Form -->
        <div id="registerForm" class="hidden">
                        <!-- Updated to use absolute positioning -->

                        <button id="closeModal" class="absolute top-2 right-2 text-gray-500 text-2xl hover:text-gray-700">

&times;

</button>
            <h2 class="text-xl font-bold mb-4">Register</h2>
            <!-- Display register message -->
            <div id="registerMessage" class="mb-4 text-center text-red-500 hidden"></div>
            <form id="registerFormElement">
                <div class="mb-4">
                    <label for="registerUsername" class="block text-gray-700 font-bold mb-2">Username</label>
                    <input type="text" id="registerUsername" name="username" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="registerEmail" class="block text-gray-700 font-bold mb-2">Email</label>
                    <input type="email" id="registerEmail" name="email" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="registerPassword" class="block text-gray-700 font-bold mb-2">Password</label>
                    <input type="password" id="registerPassword" name="password" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="role" class="block text-gray-700 font-bold mb-2">Role</label>
                    <select id="role" name="role" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                    </select>
                </div>
                <div class="mb-6">
                    <button type="submit" name="reg" class="bg-[#6B23D6] text-white font-bold py-2 px-4 rounded-full w-full">Register</button>
                </div>
                <p class="text-center text-gray-600">Already have an account? <a href="#" id="showLogin" class="text-blue-500 hover:underline">Login here</a>.</p>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Handle login form submission
        $('#loginFormElement').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: 'login.php',
                data: formData,
                success: function(response) {
                    if (response === 'success') {
                        window.location.href = 'index.php';
                    } else {
                        $('#loginMessage').text(response).removeClass('hidden');
                    }
                }
            });
        });

        // Handle register form submission
        $('#registerFormElement').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: 'register.php',
                data: formData,
                success: function(response) {
                    if (response === 'success') {
                        window.location.href = 'index.php';
                    } else {
                        $('#registerMessage').text(response).removeClass('hidden');
                    }
                }
            });
        });

        // Toggle between login and register forms
        $('#showRegister').click(function(e) {
            e.preventDefault();
            $('#loginForm').hide();
            $('#registerForm').show();
        });

        $('#showLogin').click(function(e) {
            e.preventDefault();
            $('#registerForm').hide();
            $('#loginForm').show();
        });
    });

    
        // Show modal from desktop view

        document.getElementById('openModal').addEventListener('click', function() {

document.getElementById('signupModal').classList.remove('hidden');

});



// Show modal from mobile view

document.getElementById('openModalMobile').addEventListener('click', function() {

document.getElementById('signupModal').classList.remove('hidden');

document.getElementById('mobileMenu').classList.add('hidden'); // Close mobile menu when opening modal

});



// Close modal

document.getElementById('closeModal').addEventListener('click', function() {

document.getElementById('signupModal').classList.add('hidden');

});



// Close modal when clicking outside

window.addEventListener('click', function(event) {

if (event.target === document.getElementById('signupModal')) {

    document.getElementById('signupModal').classList.add('hidden');

}

});
</script>


<!-- JavaScript to toggle forms -->
<script>
    document.getElementById('showRegister').addEventListener('click', function() {
        document.getElementById('loginForm').classList.add('hidden');
        document.getElementById('registerForm').classList.remove('hidden');
    });

    document.getElementById('showLogin').addEventListener('click', function() {
        document.getElementById('registerForm').classList.add('hidden');
        document.getElementById('loginForm').classList.remove('hidden');
    });
</script>



<script>

    // JavaScript to handle FAQ accordion functionality

    document.querySelectorAll('.faq-toggle').forEach(button => {

        button.addEventListener('click', () => {

            const faqContent = button.nextElementSibling;



            button.classList.toggle('active');

            faqContent.classList.toggle('hidden');



            // Toggle the plus/minus icon

            button.querySelector('span:last-child').textContent = 

                faqContent.classList.contains('hidden') ? '+' : '-';

        });

    });

</script>



    <?php endif; ?>

    </div> 

    </div>

    <footer class="bg-gray-800 text-white py-10 rounded-t-3xl">

    <div class="container mx-auto px-6 lg:px-8">

        <div class="flex flex-col lg:flex-row lg:justify-between">

            <!-- About Section -->

            <div class="mb-6 lg:mb-0 lg:w-1/3">

                <h2 class="text-2xl font-bold mb-4">About Us</h2>

                <p class="text-gray-400">We are committed to enhancing education through interactive quizzes and games. Our mission is to make learning engaging and effective for everyone.</p>

            </div>



            <!-- Links Section -->

            <div class="mb-6 lg:mb-0 lg:w-1/3">

                <h2 class="text-2xl font-bold mb-4">Quick Links</h2>

                <ul class="space-y-2">

                    <li><a href="#" class="hover:text-gray-300 transition">Home</a></li>

                    <li><a href="#" class="hover:text-gray-300 transition">About</a></li>

                    <li><a href="#" class="hover:text-gray-300 transition">Features</a></li>

                    <li><a href="#" class="hover:text-gray-300 transition">Contact</a></li>

                </ul>

            </div>



            <!-- Contact Section -->

            <div class="lg:w-1/3">

                <h2 class="text-2xl font-bold mb-4">Contact Us</h2>

                <p class="text-gray-400">123 Quiz Street, Quiz City, QC 12345</p>

                <p class="text-gray-400">Email: <a href="mailto:info@quizplatform.com" class="hover:text-gray-300 transition">info@quizplatform.com</a></p>

                <p class="text-gray-400">Phone: <a href="tel:+1234567890" class="hover:text-gray-300 transition">+1 (234) 567-890</a></p>

            </div>

        </div>



        <!-- Bottom Section -->

        <div class="mt-10 border-t border-gray-700 pt-6 text-center">

            <p class="text-gray-400 text-sm mb-6">&copy; 2024 R4 Dev - Quiz Platform. All rights reserved.</p>

            <div class="flex justify-center space-x-6">

                <a href="#" class="text-gray-400 hover:text-gray-300 transition">

                    <i class="fab fa-facebook-f fa-lg"></i>

                </a>

                <a href="#" class="text-gray-400 hover:text-gray-300 transition">

                    <i class="fab fa-twitter fa-lg"></i>

                </a>

                <a href="#" class="text-gray-400 hover:text-gray-300 transition">

                    <i class="fab fa-linkedin-in fa-lg"></i>

                </a>

                <a href="#" class="text-gray-400 hover:text-gray-300 transition">

                    <i class="fab fa-instagram fa-lg"></i>

                </a>

            </div>

        </div>

    </div>

</footer>





</body>

</html>

