<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli("localhost", "root", "", "task_scheduler");

if ($conn->connect_error) {
    die("Connection failed");
}
?>

