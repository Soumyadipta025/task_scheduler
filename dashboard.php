<?php
session_start();
include "includes/db.php";
include "includes/header.php";

/* ------------------ LOGIN CHECK ------------------ */
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* ------------------ FETCH USER TASKS ------------------ */
$stmt = $conn->prepare(
    "SELECT * FROM tasks WHERE user_id = ? ORDER BY id DESC"
);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$tasks = $stmt->get_result();
?>

<!-- ------------------ PAGE BACKGROUND ------------------ -->
<style>
body {
    background: url("assets/background.jpg") no-repeat center center fixed;
    background-size: cover;
}
.dashboard-bg {
    min-height: 100vh;
    padding: 20px 0;
}
</style>

<div class="dashboard-bg">
<div class="container my-5 bg-white p-4 rounded shadow">


    <!-- ------------------ ADD TASK BUTTON ------------------ -->
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#addTaskModal">
            ➕ <?= $lang['add_task'] ?>
        </button>
    </div>

    <h3 class="fw-bold mb-3"><?= $lang['my_tasks'] ?></h3>

    <!-- ------------------ TASK TABLE ------------------ -->


    <div class="table-responsive">
    <table class="table table-bordered align-middle">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Task Title</th>
            <th>Category</th>
            <th>Due Date</th>
            <th>Action</th>
            <th>Remove</th>
        </tr>
        </thead>

        <tbody>
        <?php if ($tasks->num_rows > 0): ?>
            <?php while ($row = $tasks->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['category']) ?></td>
                <td><?= $row['due_date'] ?></td>
                <td>
                    <!-- ONLY EDIT BUTTON (DELETE REMOVED) -->
                    <button class="btn btn-warning btn-md"
                            data-bs-toggle="modal"
                            data-bs-target="#editTask<?= $row['id'] ?>">
                        Edit
                    </button>

                                   
   <td>
    <a href="tasks/delete_task.php?id=<?= $row['id'] ?>"
       class="btn btn-danger btn-sm"
       onclick="return confirm('Are you sure you want to delete this task?');">
        Delete
    </a>
</td>

                </td>
            </tr>

            <!-- ------------------ EDIT TASK MODAL ------------------ -->
            <div class="modal fade" id="editTask<?= $row['id'] ?>" tabindex="-1">
            <div class="modal-dialog">
            <form method="POST" action="update_task.php">
            <div class="modal-content">

                <div class="modal-header">
                    <h5>Edit Task</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">

                    <input type="text" name="title"
                           class="form-control mb-2"
                           value="<?= htmlspecialchars($row['title']) ?>"
                           required>

                    <input type="text" name="category"
                           class="form-control mb-2"
                           value="<?= htmlspecialchars($row['category']) ?>">

                    <input type="date" name="due_date"
                           class="form-control"
                           value="<?= $row['due_date'] ?>">
                </div>

                <div class="modal-footer">
                    <button type="submit" name="update"
                            class="btn btn-success">
                        Save Changes
                    </button>
                </div>

            </div>
            </form>
            </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center text-muted">
                    No tasks found
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>
</div>

<!-- ------------------ ADD TASK MODAL ------------------ -->
<div class="modal fade" id="addTaskModal" tabindex="-1">
<div class="modal-dialog">
<form method="POST" action="add_task.php">
<div class="modal-content">

    <div class="modal-header">
        <h5>Add New Task</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
        <input type="text" name="title"
               class="form-control mb-2"
               placeholder="Task Title" required>

        <input type="text" name="category"
               class="form-control mb-2"
               placeholder="Category">

        <input type="date" name="due_date"
               class="form-control">
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">
            Save Task
        </button>
    </div>

</div>
</form>
</div>
</div>

<?php include "includes/footer.php"; ?>
