<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

        /* Customize Tailwind with Poppins font */

        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        

        html {

            font-family: 'Poppins', sans-serif;

        }

    </style>

<div class="w-full px-8">

    <nav class="bg-[#6B23D6]  text-white rounded-2xl px-8 py-4 flex items-center rounded-[30px] justify-between w-full mt-5">

        <!-- Left Section: Navigation Links -->

        <div class="flex items-center space-x-4 hidden lg:block lg:space-x-8">

            <a href="index.php" class="hover:text-gray-300">Home</a>

            <a href="aboutus.php" class="hover:text-gray-300">About</a>

            <a href="#" class="hover:text-gray-300">Features</a>

            <a href="#" class="hover:text-gray-300">Contact</a>

        </div>



        <!-- Right Section: Sign Up Button -->

        <div class="hidden lg:flex">

            <?php if ($is_logged_in): ?>

                <a href="logout.php" class="bg-white text-[#6B23D6] font-bold py-2 px-6 rounded-full hover:bg-gray-100">Log Out</a>

            <?php else: ?>

                <button id="openModal" class="bg-white text-[#6B23D6] font-bold py-2 px-6 rounded-full hover:bg-gray-100">Sign In</button>

            <?php endif; ?>

        </div>



        <!-- Mobile Menu Button -->

        <button id="mobileMenuButton" class="lg:hidden text-white focus:outline-none">

            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>

            </svg>

        </button>

    </nav>



    <!-- Mobile Menu -->

    <div id="mobileMenu" class="lg:hidden fixed inset-0 bg-[#6B23D6] text-white flex flex-col items-center justify-center space-y-4 z-20 hidden">

        <!-- Close Button -->

        <button id="closeMobileMenu" class="absolute top-4 right-4 text-white focus:outline-none">

            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>

            </svg>

        </button>



        <!-- Menu Links -->

        <a href="#" class="hover:text-gray-300">Home</a>

        <a href="#" class="hover:text-gray-300">About</a>

        <a href="#" class="hover:text-gray-300">Quiz</a>

        <a href="#" class="hover:text-gray-300">Contact</a>

        <?php if ($is_logged_in): ?>

            <a href="logout.php" class="bg-white text-[#6B23D6] font-bold py-2 px-6 rounded-full hover:bg-gray-100">Log Out</a>

        <?php else: ?>

            <!-- Updated Button ID to match the JS -->

            <button id="openModalMobile" class="bg-white text-[#6B23D6] font-bold py-2 px-6 rounded-full hover:bg-gray-100">Sign In</button>

        <?php endif; ?>

    </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



        </div>

    </div>



    <!-- Scripts -->

    <script>

        // Toggle mobile menu visibility

        document.getElementById('mobileMenuButton').addEventListener('click', function() {

            document.getElementById('mobileMenu').classList.toggle('hidden');

        });



        // Close mobile menu

        document.getElementById('closeMobileMenu').addEventListener('click', function() {

            document.getElementById('mobileMenu').classList.add('hidden');

        });




    </script>

</div>

