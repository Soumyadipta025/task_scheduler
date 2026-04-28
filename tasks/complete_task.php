<?php
include "../includes/db.php";

/*
  This file marks a task as completed
  Represents "Complete Tasks" step
*/

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: ../index.php");
    exit();
}

$task_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$sql = "
    UPDATE tasks
    SET is_completed = 1
    WHERE id = ? AND user_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $task_id, $user_id);
$stmt->execute();

header("Location: ../index.php");
exit();
