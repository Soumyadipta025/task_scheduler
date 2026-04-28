<?php
session_start();
include "../includes/db.php";
include "../includes/header.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* ===== TASK COUNTS ===== */
$total = $conn->query(
    "SELECT COUNT(*) AS t FROM tasks WHERE user_id = $user_id"
)->fetch_assoc()['t'];

$completed = $conn->query(
    "SELECT COUNT(*) AS c FROM tasks WHERE user_id = $user_id AND is_completed = 1"
)->fetch_assoc()['c'];

$pending  = $total - $completed;
$progress = $total > 0 ? round(($completed / $total) * 100) : 0;

/* ===== PROGRESS BAR COLOR ===== */
/*
- GREEN only if all tasks completed
- RED if any task is pending
*/
$barClass = ($total > 0 && $pending === 0)
    ? 'bg-success'
    : 'bg-danger';
?>

<!-- ================= PAGE STYLE ================= -->
<style>
.dashboard-gradient {
    background: #6902024b;
        border: 1px solid rgba(244, 211, 211, 0.63);
    padding: 40px;
    margin-top: 100px;
    border-radius: 16px;
}

/* Disable transitions (clean UI) */
.progress-bar {
    transition: none !important;
}
</style>

<!-- ================= PAGE CONTENT ================= -->
<div class="container dashboard-gradient shadow link-light">

    <h3 class="fw-bold mb-4 text-center"><?= $lang['task_progress'] ?></h3>

    <!-- ===== STAT CARDS ===== -->
    <div class="row g-4 justify-content-center text-center">

        <div class="col-md-3">
            <div class="card p-4 shadow-sm">
                <h6><?= $lang['total_tasks'] ?></h6>
                <p class="display-6 mb-0"><?= $total ?></p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-4 shadow-sm">
                <h6><?= $lang['completed'] ?></h6>
                <p class="display-6 mb-0"><?= $completed ?></p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-4 shadow-sm">
                <h6><?= $lang['pending'] ?></h6>
                <p class="display-6 mb-0"><?= $pending ?></p>
            </div>
        </div>

    </div>

    <!-- ===== PROGRESS BAR ===== -->
    <div class="mt-5">
        <div class="progress" style="height: 28px;">
            <div class="progress-bar <?= $barClass ?>"
                 role="progressbar"
                 style="width: <?= $progress ?>%;">
                <?= $progress ?>%
            </div>
        </div>

        <p class="text-center mt-2 text-muted">
            <?= $completed ?> <?= $lang['of'] ?> <?= $total ?> <?= $lang['tasks_completed'] ?>
        </p>
    </div>

</div>

<?php include "../includes/footer.php"; ?>
