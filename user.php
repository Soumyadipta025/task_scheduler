<?php
session_start();
include "includes/db.php";
include "includes/header.php";

/* ===== HANDLE BULK DELETE USERS ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_users'])) {
    $userIds = $_POST['user_ids'] ?? [];
    if (!empty($userIds)) {
        $placeholders = implode(',', array_fill(0, count($userIds), '?'));
        $stmt = $conn->prepare("DELETE FROM users WHERE id IN ($placeholders)");
        $stmt->bind_param(str_repeat('i', count($userIds)), ...$userIds);
        $stmt->execute();
    }
}

/* ===== HANDLE BULK DELETE TASKS ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_tasks'])) {
    $taskIds = $_POST['task_ids'] ?? [];
    if (!empty($taskIds)) {
        $placeholders = implode(',', array_fill(0, count($taskIds), '?'));
        $stmt = $conn->prepare("DELETE FROM tasks WHERE id IN ($placeholders)");
        $stmt->bind_param(str_repeat('i', count($taskIds)), ...$taskIds);
        $stmt->execute();
    }
}

/* ===== HANDLE TASK STATUS UPDATE ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id'])) {
    $taskId = (int) $_POST['task_id'];
    $newStatus = isset($_POST['is_completed']) ? 1 : 0;

    $stmt = $conn->prepare(
        "UPDATE tasks SET is_completed = ? WHERE id = ?"
    );
    $stmt->bind_param("ii", $newStatus, $taskId);
    $stmt->execute();
}

/* ===== DASHBOARD COUNTS ===== */
$totalUsers = $conn->query(
    "SELECT COUNT(*) AS total FROM users"
)->fetch_assoc()['total'];

$totalTasks = $conn->query(
    "SELECT COUNT(*) AS total FROM tasks"
)->fetch_assoc()['total'];

$pendingTasks = $conn->query(
    "SELECT COUNT(*) AS total FROM tasks WHERE is_completed = 0"
)->fetch_assoc()['total'];

/* ===== FETCH USERS ===== */
$users = $conn->query(
    "SELECT id, name, email, role FROM users ORDER BY id DESC"
);

/* ===== FETCH TASKS ===== */
$stmt = $conn->prepare("
    SELECT tasks.id, tasks.title, tasks.is_completed, users.name
    FROM tasks
    JOIN users ON tasks.user_id = users.id
    ORDER BY tasks.id DESC
");
$stmt->execute();
$allTasks = $stmt->get_result();
?>

<style>
body {
    background: url("assets/background.jpg") no-repeat center center fixed;
    background-size: cover;
}

.user-wrapper {
    padding-top: 80px;
}

/* CENTERING FIX */
.panel-wrapper {
    max-width: 1200px;
    width: 100%;
}

.user-sidebar {
    background: rgba(0, 0, 0, 0.6);
    border-radius: 12px;
    padding: 20px;
    height: 50%;
}

.user-sidebar h4 {
    color: #fff;
    margin-bottom: 20px;

}


.user-sidebar a {
    display: block;
    color: #ddd;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 8px;
    text-decoration: none;
}

.user-sidebar a:hover {
    background: #343a40;
    color: #fff;
}

.user-content {
    background: #902f2f45;
    border-radius: 12px;
    padding: 25px;
}

.table tr:hover {
    transform: none !important;
    box-shadow: none !important;
    background-color: inherit !important;
}
.h2 mb-4{
   color: #f1e9e9;
}

.card{
      color: white;
      background: linear-gradient(
        180deg,
       #141010,
        #632d2d,
        #f44d4d8e
    )
  
}

.delete-btn-section {
    display: none;
    margin-top: 15px;
    padding: 10px;
    background: rgba(255, 0, 0, 0.1);
    border-radius: 6px;
}

.delete-btn-section.show {
    display: block;
}

.selected-count {
    color: #fff;
    font-weight: bold;
}
</style>

<script>
function selectAllRows(checkbox, tableId) {
    const checkboxes = document.querySelectorAll(`#${tableId} input[type="checkbox"]:not(.selectAll)`);
    checkboxes.forEach(cb => cb.checked = checkbox.checked);
    updateDeleteButtonVisibility(tableId);
}

function updateDeleteButtonVisibility(tableId) {
    const checkboxes = document.querySelectorAll(`#${tableId} input[type="checkbox"]:not(.selectAll)`);
    const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
    const deleteSection = document.getElementById(`delete-${tableId}`);
    const selectedCountSpan = document.getElementById(`selected-count-${tableId}`);
    
    if (checkedCount > 0) {
        deleteSection.classList.add('show');
        selectedCountSpan.textContent = `${checkedCount} <?= $lang['selected_items'] ?>`;
    } else {
        deleteSection.classList.remove('show');
    }
}

function deleteSelected(formId) {
    if (confirm('<?= $lang['confirm_delete'] ?>')) {
        document.getElementById(formId).submit();
    }
}
</script>

<div class="container-fluid user-wrapper d-flex justify-content-center">
    <div class="row g-4 panel-wrapper">

        <!-- SIDEBAR -->
        <div class="col-md-3">
            <div class="user-sidebar shadow">
                <h4><?= $lang['user_panel'] ?></h4>
                <a href="dashboard.php"><?= $lang['dashboard'] ?></a>
                <a href="./tasks/user_tasks.php"><?= $lang['tasks'] ?></a>
                <a href="./tasks/user_reports.php"><?= $lang['reports'] ?></a>
                <a href="task_reminder.php"><?= $lang['reminders'] ?></a>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-md-9">
            <div class="user-content shadow">

                <h2 class="fw-bold mb-4 text-white"><?= $lang['users_dashboard'] ?></h2>

                <!-- STATS -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <h5><?= $lang['total_users'] ?></h5>
                            <p class="display-6"><?= $totalUsers ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <h5><?= $lang['total_tasks'] ?></h5>
                            <p class="display-6"><?= $totalTasks ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <h5><?= $lang['pending_tasks'] ?></h5>
                            <p class="display-6"><?= $pendingTasks ?></p>
                        </div>
                    </div>
                </div>

                <!-- USER TABLE -->
                <div class="card mb-4">
                    <div class="card-header fw-bold"><?= $lang['user_management'] ?></div>
                    <div class="card-body">
                        <form id="delete-users-form" method="POST">
                            <input type="hidden" name="delete_users" value="1">
                            <table class="table table-bordered text-center" id="users-table">
                                <thead class="table-dark">
                                    <tr>
                                        <th><input type="checkbox" class="selectAll" onchange="selectAllRows(this, 'users-table')"> <?= $lang['select_all'] ?></th>
                                        <th><?= $lang['id'] ?></th>
                                        <th><?= $lang['name'] ?></th>
                                        <th><?= $lang['email'] ?></th>
                                        <th><?= $lang['role'] ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php while ($user = $users->fetch_assoc()): ?>
                                    <tr>
                                        <td><input type="checkbox" name="user_ids[]" value="<?= $user['id'] ?>" onchange="updateDeleteButtonVisibility('users-table')"></td>
                                        <td><?= $user['id'] ?></td>
                                        <td><?= htmlspecialchars($user['name']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td><?= ucfirst($user['role']) ?></td>
                                    </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                            <div class="delete-btn-section" id="delete-users-table">
                                <span class="selected-count" id="selected-count-users-table">0 <?= $lang['selected_items'] ?></span>
                                <button type="button" class="btn btn-danger btn-sm ms-3" onclick="deleteSelected('delete-users-form')">
                                    🗑️ <?= $lang['delete_selected'] ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- TASK TABLE -->
                <div class="card">
                    <div class="card-header fw-bold"><?= $lang['task_management'] ?></div>
                    <div class="card-body">
                        <form id="delete-tasks-form" method="POST">
                            <input type="hidden" name="delete_tasks" value="1">
                            <table class="table table-bordered text-center align-middle" id="tasks-table">
                                <thead class="table-dark">
                                    <tr>
                                        <th><input type="checkbox" class="selectAll" onchange="selectAllRows(this, 'tasks-table')"> <?= $lang['select_all'] ?></th>
                                        <th><?= $lang['id'] ?></th>
                                        <th><?= $lang['title'] ?></th>
                                        <th><?= $lang['user'] ?></th>
                                        <th><?= $lang['completed'] ?></th>
                                        <th><?= $lang['status'] ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php while ($task = $allTasks->fetch_assoc()): ?>
                                    <tr>
                                        <td><input type="checkbox" name="task_ids[]" value="<?= $task['id'] ?>" onchange="updateDeleteButtonVisibility('tasks-table')"></td>
                                        <td><?= $task['id'] ?></td>
                                        <td><?= htmlspecialchars($task['title']) ?></td>
                                        <td><?= htmlspecialchars($task['name']) ?></td>
                                        <td>
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                                <input type="checkbox"
                                                       name="is_completed"
                                                       onchange="this.form.submit()"
                                                       <?= $task['is_completed'] ? 'checked' : '' ?>>
                                            </form>
                                        </td>
                                        <td>
                                            <?php if ($task['is_completed']): ?>
                                                <span class="badge bg-success"><?= $lang['completed'] ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark"><?= $lang['pending'] ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                            <div class="delete-btn-section" id="delete-tasks-table">
                                <span class="selected-count" id="selected-count-tasks-table">0 <?= $lang['selected_items'] ?></span>
                                <button type="button" class="btn btn-danger btn-sm ms-3" onclick="deleteSelected('delete-tasks-form')">
                                    🗑️ <?= $lang['delete_selected'] ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<?php include "includes/footer.php"; ?>
