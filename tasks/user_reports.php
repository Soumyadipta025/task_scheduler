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
    "SELECT COUNT(*) AS t FROM tasks WHERE user_id=$user_id"
)->fetch_assoc()['t'];

$completed = $conn->query(
    "SELECT COUNT(*) AS c FROM tasks WHERE user_id=$user_id AND is_completed=1"
)->fetch_assoc()['c'];

$pending  = $total - $completed;
$progress = $total > 0 ? round(($completed / $total) * 100) : 0;

/* ===== PROGRESS COLOR ===== */
$barClass = 'bg-danger';
if ($progress >= 70) {
    $barClass = 'bg-success';
} elseif ($progress >= 40) {
    $barClass = 'bg-warning';
}
?>

<!-- ================= GOOGLE CHART ================= -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Task Status', 'Count'],
        ['Completed', <?= $completed ?>],
        ['Pending', <?= $pending ?>]
    ]);

    var options = {
        title: '<?= $lang['task_completion_overview'] ?>',
        pieHole: 0.45,
        legend: { position: 'bottom' },
        colors: ['#28a745', '#dc3545'],
        chartArea: { width: '90%', height: '80%' }
    };

    var chart = new google.visualization.PieChart(
        document.getElementById('task_pie_chart')
    );
    chart.draw(data, options);
}
</script>

<!-- ================= PAGE STYLE ================= -->
<style>
.dashboard-gradient {
    background: #902f2f45;
    
    padding: 40px;
    margin-top: 100px;
    border-radius: 16px;
}

</style>

<!-- ================= PAGE CONTENT ================= -->
<div class="container dashboard-gradient shadow">

    <h3 class="fw-bold mb-4 text-center"><?= $lang['progress_report'] ?></h3>

    <!-- ===== STAT CARDS ===== -->
    <div class="row g-4 justify-content-center text-center">

        <div class="col-md-3">
            <div class="card p-4 shadow-sm">
                <h5><?= $lang['total_tasks'] ?></h5>
                <p class="display-6"><?= $total ?></p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-4 shadow-sm">
                <h5><?= $lang['completed'] ?></h5>
                <p class="display-6"><?= $completed ?></p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-4 shadow-sm">
                <h5><?= $lang['progress'] ?></h5>
                <p class="display-6"><?= $progress ?>%</p>
            </div>
        </div>

    </div>

    <!-- ===== PROGRESS BAR ===== -->
    <div class="progress mt-5" style="height: 30px;">
        <div class="progress-bar <?= $barClass ?> progress-bar-striped progress-bar-animated"
             style="width: <?= $progress ?>%;">
            <?= $progress ?>%
        </div>
    </div>

    <p class="text-center text-muted mt-2">
        <?= $completed ?> <?= $lang['of'] ?> <?= $total ?> <?= $lang['tasks_completed'] ?>
    </p>

    <!-- ===== PIE CHART ===== -->
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 text-center">
            <h5 class="fw-bold mb-3"><?= $lang['task_distribution'] ?></h5>
            <div id="task_pie_chart" style="height: 400px;"></div>
        </div>
    </div>

</div>

<?php include "../includes/footer.php"; ?>
