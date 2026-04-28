<?php
session_start();
include "includes/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$title    = $_POST['title'];
$category = $_POST['category'];
$due_date = $_POST['due_date'];
$user_id  = $_SESSION['user_id'];

$stmt = $conn->prepare(
    "INSERT INTO tasks (user_id, title, category, due_date)
     VALUES (?, ?, ?, ?)"
);
$stmt->bind_param("isss",
    $user_id, $title, $category, $due_date
);
$stmt->execute();

header("Location: dashboard.php");
exit();
