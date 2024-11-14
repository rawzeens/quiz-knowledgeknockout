-- Users table

CREATE TABLE users (

    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'teacher') NOT NULL DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    reset_token VARCHAR(255), 
    reset_token_expiry DATETIME;
);


-- Quizzes table

CREATE TABLE quizzes (

    id INT AUTO_INCREMENT PRIMARY KEY,

    title VARCHAR(255) NOT NULL,

    description TEXT,

    created_by INT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (created_by) REFERENCES users(id)

);



-- Questions table

CREATE TABLE questions (

    id INT AUTO_INCREMENT PRIMARY KEY,

    quiz_id INT,

    question_text TEXT NOT NULL,

    question_type ENUM('multiple_choice', 'true_false', 'fill_in_the_blank') NOT NULL,

    correct_answer TEXT,  -- For fill-in-the-blank questions

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE

);



-- Options table

CREATE TABLE options (

    id INT AUTO_INCREMENT PRIMARY KEY,

    question_id INT,

    option_text TEXT NOT NULL,

    is_correct BOOLEAN DEFAULT FALSE,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE

);



-- Quiz Attempts table

CREATE TABLE quiz_attempts (

    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT,

    quiz_id INT,

    score INT,

    attempt_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id),

    FOREIGN KEY (quiz_id) REFERENCES quizzes(id)

);



-- User Answers table

CREATE TABLE user_answers (

    id INT AUTO_INCREMENT PRIMARY KEY,

    attempt_id INT,

    question_id INT,

    selected_option_id INT,

    answer_text TEXT,

    is_correct BOOLEAN,

    FOREIGN KEY (attempt_id) REFERENCES quiz_attempts(id) ON DELETE CASCADE,

    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE,

    FOREIGN KEY (selected_option_id) REFERENCES options(id)

);

-- Users table

CREATE TABLE users (

    id INT AUTO_INCREMENT PRIMARY KEY,

    username VARCHAR(50) NOT NULL UNIQUE,

    email VARCHAR(100) NOT NULL UNIQUE,

    password VARCHAR(255) NOT NULL,

    role ENUM('student', 'teacher') NOT NULL DEFAULT 'student',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);



-- Quizzes table

CREATE TABLE quizzes (

    id INT AUTO_INCREMENT PRIMARY KEY,

    title VARCHAR(255) NOT NULL,

    description TEXT,

    created_by INT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (created_by) REFERENCES users(id)

);



-- Questions table

CREATE TABLE questions (

    id INT AUTO_INCREMENT PRIMARY KEY,

    quiz_id INT,

    question_text TEXT NOT NULL,

    question_type ENUM('multiple_choice', 'true_false', 'fill_in_the_blank') NOT NULL,

    correct_answer TEXT,  -- For fill-in-the-blank questions

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE

);



-- Options table

CREATE TABLE options (

    id INT AUTO_INCREMENT PRIMARY KEY,

    question_id INT,

    option_text TEXT NOT NULL,

    is_correct BOOLEAN DEFAULT FALSE,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE

);



-- Quiz Attempts table

CREATE TABLE quiz_attempts (

    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT,

    quiz_id INT,

    score INT,

    attempt_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id),

    FOREIGN KEY (quiz_id) REFERENCES quizzes(id)

);



-- User Answers table

CREATE TABLE user_answers (

    id INT AUTO_INCREMENT PRIMARY KEY,

    attempt_id INT,

    question_id INT,

    selected_option_id INT,

    answer_text TEXT,

    is_correct BOOLEAN,

    FOREIGN KEY (attempt_id) REFERENCES quiz_attempts(id) ON DELETE CASCADE,

    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE,

    FOREIGN KEY (selected_option_id) REFERENCES options(id)

);

