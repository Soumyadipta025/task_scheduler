<?php
session_start();
include "includes/db.php";

/* ---------- AUTH CHECK ---------- */
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include "includes/header.php";

$user_id = $_SESSION['user_id'];
$today   = date('Y-m-d');

/* ---------- FETCH PENDING TASKS ---------- */
$stmt = $conn->prepare(
    "SELECT title, category, due_date
     FROM tasks
     WHERE user_id = ? AND is_completed = 0
     ORDER BY due_date ASC"
);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$tasks = $stmt->get_result();
?>

<style>
/* ===== EMPTY STATE DESIGN ===== */

body {
    min-height: 100vh;
    background: linear-gradient(135deg, #161617, #383643);
    color: #fffdfd;
    background-attachment: fixed;
}

.empty-state {
    background: rgba(255,255,255,0.9);
}

.empty-state {
    background: linear-gradient(135deg, #161617, #383643);
    border: 2px solid #d1d5db;
    border-radius: 16px;
    padding: 60px 20px;
    text-align: center;
    max-width: 800px;
    margin: 40px auto;
    
}

.empty-state img {
    width: 80px;
    margin-bottom: 20px;
}

.empty-state h4 {
    font-weight: 700;
    margin-bottom: 10px;
    
}

.empty-state p {
    color: #fcfafa;
    margin-bottom: 25px;
}

.empty-state a {
    font-size: 16px;
}
/* ===== TASK REMINDER TITLE STYLE ===== */
.container h3 {
    text-align: center;
    text-decoration: underline;
    text-underline-offset: 8px;
    text-decoration-thickness: 2px;
    margin-top: 30px;
}
.btn {
    background: linear-gradient(
        135deg,
        #0f2027,
        #000000,
        #3b4042
    ) !important;
    color: #ffffff;
    border-radius: 15px;
    border-width: 1px;
    border-color: #ffffff;
}

</style>

<div class="container my-5">
    <h3 class="fw-bold mb-3">⏰ <?= $lang['task_reminders'] ?></h3>

    <?php
    $notifyTasks = [];

    if ($tasks->num_rows > 0):
        while ($task = $tasks->fetch_assoc()):

            if ($task['due_date'] < $today) {
                $alertClass = "danger";
                $statusText = isset($lang['overdue']) ? $lang['overdue'] : "Overdue";
                $notifyTasks[] = $task['title'];
            } elseif ($task['due_date'] === $today) {
                $alertClass = "warning";
                $statusText = isset($lang['due_today']) ? $lang['due_today'] : "Due Today";
                $notifyTasks[] = $task['title'];
            } else {
                $alertClass = "info";
                $statusText = isset($lang['upcoming']) ? $lang['upcoming'] : "Upcoming";
            }
    ?>

        <!-- TASK ALERT -->
        <div class="alert alert-<?= $alertClass ?> d-flex justify-content-between align-items-center">
            <div>
                <strong><?= htmlspecialchars($task['title']) ?></strong>
                <div class="small text-muted">
                    <?= isset($lang['category']) ? $lang['category'] : 'Category' ?>: <?= htmlspecialchars($task['category']) ?>
                </div>
            </div>

            <div class="text-end">
                <span class="badge bg-dark"><?= $statusText ?></span><br>
                <small><?= isset($lang['due']) ? $lang['due'] : 'Due' ?>: <?= $task['due_date'] ?></small>
            </div>
        </div>

    <?php
        endwhile;
    else:
    ?>

        <!-- EMPTY STATE UI -->
        <div class="empty-state">
            <img src="assets/celebration.png" alt="No tasks">
            <h4><?= isset($lang['no_pending_tasks']) ? $lang['no_pending_tasks'] : 'No pending tasks!' ?></h4>
            <p><?= isset($lang['all_caught_up']) ? $lang['all_caught_up'] : "You're all caught up. Enjoy your free time." ?></p>
            <a href="../task_scheduler/dashboard.php" class="btn ">
                <?= $lang['add_task'] ?>
            </a>
        </div>

    <?php endif; ?>
</div>

<!-- ================= NOTIFICATION SCRIPT (UNCHANGED) ================= -->
<script>

 document.addEventListener("DOMContentLoaded", function () {

    const tasks = <?php echo json_encode($notifyTasks); ?>;
    if (!tasks || tasks.length === 0) return;

    if (Notification.permission === "default") {
        Notification.requestPermission();
    }

    if (Notification.permission === "granted") {
        tasks.forEach((task, index) => {
            setTimeout(() => {
                new Notification("⏰ Task Reminder", {
                    body: `"${task}" is due or overdue`,
                    icon: window.location.origin + "/assets/notification.png"
                });
            }, index * 2000);
        });
    }

});

</script>

<?php include "includes/footer.php"; ?>
