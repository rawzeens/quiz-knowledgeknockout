<?php
//dashboard.php
include 'db_connection.php';
session_start();

if ($_SESSION['role'] == 'teacher') {
    header('Location: index.php');
} else {
    header('Location: index.php');
}
?>
