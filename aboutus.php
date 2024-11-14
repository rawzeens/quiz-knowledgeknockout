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

    <!-- Main Layout Container -->
    <div class=" w-full h-full justify-center lg:justify-between items-start lg:items-center space-y-8 lg:space-y-0 px-6 lg:px-16 py-12">



        <!-- Main Content Area -->
        <main class="w-full  mx-auto py-12 space-y-12">
    <!-- 1:2 Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- 1/3 Section -->
        <section class="col-span-2 md:col-span-1 bg-white bg-opacity-10 p-6 rounded-lg">
            <h1 class="text-3xl font-bold text-white mb-4">About Us</h1>
            <p class="text-lg leading-8 text-white">
                Welcome to <span class="font-semibold">KnowledgeKnockout</span>, where learning is both fun and effective. Our platform is designed for anyone looking to engage with challenging quizzes and enhance their understanding across a wide variety of subjects.
            </p>
        </section>
        
        <!-- 2/3 Section -->
        <section class="col-span-2 bg-white bg-opacity-10 p-6 rounded-lg space-y-6">
            <p class="text-lg leading-8 text-white">
                Whether you're a student preparing for exams, a teacher looking for an interactive way to engage students, or a lifelong learner, KnowledgeKnockout offers you the tools to succeed. Our AI-powered platform delivers personalized quiz experiences, instant feedback, and real-time analytics to help you track your progress and grow your knowledge.
            </p>
            <h2 class="text-3xl font-bold text-white mt-6">Our Mission</h2>
            <p class="text-lg leading-8 text-white">
                Our mission is to make learning accessible, engaging, and enjoyable for everyone. We are passionate about providing a platform that blends education with technology to create a powerful and interactive learning environment.
            </p>
        </section>
    </div>

    <!-- Full Width Section -->
    <section class="bg-white bg-opacity-10 p-8 rounded-lg space-y-6">
        <h2 class="text-3xl font-bold text-white">Why Choose Us?</h2>
        <ul class="list-disc list-inside text-lg leading-8 text-white space-y-2">
            <li>Interactive and fun quizzes that make learning enjoyable.</li>
            <li>Real-time analytics that provide instant feedback and insights.</li>
            <li>Customizable themes to personalize your quiz experience.</li>
            <li>Wide range of quiz formats including multiple choice, fill-in-the-blank, and matching.</li>
            <li>AI-driven platform that adapts to your learning pace and style.</li>
        </ul>
        <h2 class="text-3xl font-bold text-white mt-6">Join Our Community</h2>
        <p class="text-lg leading-8 text-white">
            We invite you to join our growing community of learners, educators, and quiz enthusiasts. Whether you’re here to challenge yourself or create an educational environment for others, KnowledgeKnockout provides the tools to help you succeed.
        </p>
        <a href="contact.php" class="inline-block mt-8 px-6 py-3 bg-white text-[#6B23D6] font-semibold rounded-lg hover:bg-gray-100 transition duration-300">
            Get in Touch
        </a>
    </section>
</main>

    </div>



</body>
