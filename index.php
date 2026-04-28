<?php
session_start();
include "includes/db.php";

/* ---------- REDIRECT BEFORE ANY OUTPUT ---------- */
if (isset($_SESSION['user_id'])) {
    header("Location: user.php");
    exit();
}

/* ---------- NOW LOAD HEADER ---------- */
include "includes/header.php";
?>

<!-- ================= HERO SECTION ================= -->
<section class="hero-section d-flex align-items-center">
    <div class="container text-center text-white">
        <h1 class="display-5 fw-bold">
            <?= $lang['organize_tasks'] ?>
        </h1>
        <p class="lead mt-3">
            <?= $lang['help_plan_better'] ?>
        </p>
         <!-- LANGUAGE SWITCHER -->
            <div class="me-3">
                <div class="btn-group" role="group">
                    <a href="?lang=en" class="btn btn-sm <?= $_SESSION['lang'] === 'en' ? 'btn-light text-dark' : 'btn-outline-light' ?>">
                        English
                    </a>
                    <a href="?lang=hi" class="btn btn-sm <?= $_SESSION['lang'] === 'hi' ? 'btn-light text-dark' : 'btn-outline-light' ?>">
                        हिंदी
                    </a>
                </div>
            </div>
    </div>
    
</section>

<!-- ================= GRADIENT WRAPPER START ================= -->
<section class="hero-gradient text-white">

<!-- ================= WHAT WE BELIEVE ================= -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-md-5 text-center">
                <img src="assets/060d108f-0fe7-4c44-95e8-72103f61da16.png"
     class="img-fluid believe-image">

            </div>

            <div class="col-md-7 ps-md-5">
                <h2 class="fw-bold section-title animate">
    <?= $lang['what_we_believe'] ?>
</h2>

                <p>
                    <?= $lang['believe_description'] ?>
                </p>
            </div>

        </div>
    </div>
</section>

<!-- ================= FEATURES ================= -->
<section class="py-5">
    <div class="container">
       <h2 class="text-center fw-bold mb-5">
    <span class="section-title animate">
        <?= $lang['why_use_scheduler'] ?>
    </span>
</h2>

        <div class="row g-4 text-center">

            <div class="col-md-4">
                <div class="card h-100 p-4">
                    <h5><?= $lang['easy_task_management'] ?></h5>
                    <p class="text-muted"><?= $lang['easy_task_desc'] ?></p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 p-4">
                    <h5> <?= $lang['reminder_notifications'] ?></h5>
                    <p class="text-muted"><?= $lang['reminder_desc'] ?></p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 p-4">
                    <h5> <?= $lang['stay_productive'] ?></h5>
                    <p class="text-muted"><?= $lang['productive_desc'] ?></p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= HOW IT WORKS ================= -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">
    <span class="section-title animate">
        <?= $lang['how_it_works'] ?>
    </span>
</h2>

        <div class="row g-4 text-center how-it-works">

            <div class="col-md-3">
                <div class="icon-box">
                    <div class="icon">👤</div>
                    <h5><?= $lang['register'] ?></h5>
                </div>
            </div>

            <div class="col-md-3">
                <div class="icon-box">
                    <div class="icon">📝</div>
                    <h5><?= $lang['add_tasks'] ?></h5>
                </div>
            </div>

            <div class="col-md-3">
                <div class="icon-box">
                    <div class="icon">⏰</div>
                    <h5><?= $lang['get_reminded'] ?></h5>
                </div>
            </div>

            <div class="col-md-3">
                <div class="icon-box">
                    <div class="icon">✅</div>
                    <h5><?= $lang['complete'] ?></h5>
                </div>
            </div>

        </div>


        <!-- ================= CTA – GET STARTED ================= -->
<section class="cta-section py-5">
    <div class="container">
        <div class="cta-box text-center mx-auto">

            <h2 class="fw-bold mb-3 section-title animate">
                <?= $lang['ready_to_start'] ?>
            </h2>

            <p class="mb-4 text-muted">
                <?= $lang['start_description'] ?>
            </p>

            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <button class="btn btn-dark btn-lg px-4"
                        data-bs-toggle="modal"
                        data-bs-target="#authModal"
                        onclick="openRegisterTab()">
                    <?= $lang['register_now'] ?>
                </button>

            </div>

        </div>
    </div>
</section>

    </div>
</section>

</section>
<!-- ================= GRADIENT WRAPPER END ================= -->

<?php include "includes/footer.php"; ?>
