<?php
session_start();
include "includes/db.php";

if (isset($_POST['update'])) {

    $id       = $_POST['id'];
    $title    = $_POST['title'];
    $category = $_POST['category'];
    $due_date = $_POST['due_date'];
    $user_id  = $_SESSION['user_id'];

    $stmt = $conn->prepare(
        "UPDATE tasks
         SET title=?, category=?, due_date=?
         WHERE id=? AND user_id=?"
    );

    $stmt->bind_param(
        "sssii",
        $title, $category, $due_date,
        $id, $user_id
    );

    $stmt->execute();
}

header("Location: dashboard.php");
exit();
