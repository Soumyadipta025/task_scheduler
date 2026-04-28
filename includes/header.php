<?php
include __DIR__ . "/lang.php";
?>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Task Scheduler</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Your CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .card {
            border-radius: 14px;
            /* Make cards bigger */
            padding: 2.2rem;
            min-height: 220px;

            /* Ultra smooth transition */
            transition:
                transform 0.45s cubic-bezier(0.22, 1, 0.36, 1),
                box-shadow 0.45s cubic-bezier(0.22, 1, 0.36, 1);

            /* Performance boost */
            will-change: transform;
        }

        /* Hover / Touch effect */
        .card {
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.18);
        }

        .card h5 {
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }

        /* ================= WHAT WE BELIEVE ANIMATION ================= */

        .believe-section {
            opacity: 0;
            transform: translateX(80px);
            animation: believeSlideIn 1s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        /* Animation keyframes */
        @keyframes believeSlideIn {
            from {
                opacity: 0;
                transform: translateX(80px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* ===== Global background ===== */
        body {

            color: #ffffff;
        }

        /* ================= MAIN WRAPPER ================= */
        .hero-gradient {
            background-color: #000;
        }

        /* ================= HEADINGS & TEXT ================= */
        .hero-gradient h2,
        .hero-gradient h5 {
            color: #ffffff;
        }

        .hero-gradient p,
        .hero-gradient .text-muted {
            color: #9b9191 !important;
        }

        .text-muted {
            --bs-text-opacity: 1;
            color: var(--bs-secondary-color) rgba(163, 169, 175, 0.75) !important;
        }

        /* ================= CARDS ================= */
        .hero-gradient .card {
            background: linear-gradient(145deg, #2b2b2b, #000);
            border: 1px solid #333;
            border-radius: 16px;
            color: #f1f1f1;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hero-gradient .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(255, 255, 255, 0.08);
        }

        /* ================= ACCORDION ================= */
        .hero-gradient .accordion-item {
            background: linear-gradient(145deg, #1c1c1c, #000);
            border: 1px solid #333;
        }

        .hero-gradient .accordion-button {
            background-color: #111;
            color: #ffffff;
        }

        .hero-gradient .accordion-button:not(.collapsed) {
            background-color: #1a1a1a;
            color: #ffffff;
        }

        .hero-gradient .accordion-body {
            background-color: #000;
            color: #cccccc;
        }

        /* ================= BUTTONS (OPTIONAL) ================= */
        .gradient-btn {
            background: linear-gradient(90deg, #444, #111);
            border: none;
            color: #ffffff;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .gradient-btn:hover {
            background: linear-gradient(90deg, #555, #222);
            color: #ffffff;
        }

        /* ================= SECTION SEPARATOR (OPTIONAL) ================= */
        section.py-5 {
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* 
   HOW IT WORKS – ICON BOX (NO BOX BY DEFAULT)*/

        .how-it-works .icon-box {
            background: transparent;
            border: none;
            border-radius: 20px;
            padding: 40px 25px;
            height: 100%;
            box-shadow: none;

            transition:
                background 0.35s ease,
                box-shadow 0.35s ease,
                transform 0.35s ease;
        }

        /* =====================================================
   HOVER EFFECT – BOX APPEARS
===================================================== */
        .how-it-works .icon-box:hover {
            background: linear-gradient(145deg, #1a1a1a, #000000);
            border: 1px solid rgba(255, 255, 255, 0.15);

            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(255, 255, 255, 0.08);
        }

        /* =====================================================
   ICON CIRCLE (ALWAYS VISIBLE)
===================================================== */
        .how-it-works .icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 20px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ffffff, #bbbbbb);
            color: #000000;

            box-shadow: 0 8px 20px rgba(255, 255, 255, 0.25);
            transition: transform 0.35s ease;
        }

        /* =====================================================
   ICON HOVER ANIMATION
===================================================== */
        .how-it-works .icon-box:hover .icon {
            transform: scale(1.1) rotate(3deg);
        }

        /* =====================================================
   TITLES
===================================================== */
        .how-it-works h5 {
            color: #ffffff;
            font-weight: 600;
            margin-bottom: 10px;
        }

        /* =====================================================
   DESCRIPTION TEXT
===================================================== */
        .how-it-works p {
            color: #bdbdbd;
            font-size: 0.95rem;
            margin: 0;
        }


        /* =====================================================
   HOW IT WORKS – WORKFLOW ARROWS (FADE DOWN)
===================================================== */

        /* Enable relative positioning */
        .how-it-works .col-md-3 {
            position: relative;
        }

        /* Arrow (except last item) */
        .how-it-works .col-md-3:not(:last-child)::after {
            content: "➜";
            position: absolute;

            top: 50%;
            right: -18px;

            font-size: 28px;
            color: rgba(255, 255, 255, 0.35);

            /* Fade-down animation */
            opacity: 0;
            transform: translateY(-25px);
            animation: arrowFadeDown 0.8s ease forwards;

            pointer-events: none;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        /* Staggered animation for arrows */
        .how-it-works .col-md-3:nth-child(1)::after {
            animation-delay: 0.2s;
        }

        .how-it-works .col-md-3:nth-child(2)::after {
            animation-delay: 0.4s;
        }

        .how-it-works .col-md-3:nth-child(3)::after {
            animation-delay: 0.6s;
        }

        /* Arrow hover effect */
        .how-it-works .col-md-3:hover::after {
            color: rgba(255, 255, 255, 0.7);
            transform: translateY(0) translateX(6px);
        }

        /* =====================================================
   FADE DOWN KEYFRAMES
===================================================== */
        @keyframes arrowFadeDown {
            from {
                opacity: 0;
                transform: translateX(-25px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* =====================================================
   MOBILE RESPONSIVE – HIDE ARROWS
===================================================== */
        @media (max-width: 767px) {
            .how-it-works .col-md-3::after {
                display: none;
            }
        }

        /* =====================================================
   FADE DOWN ANIMATION (ONLY)
===================================================== */
        .fade-right {
            opacity: 0;
            transform: translateX(-25px);
            animation: fadeDown 0.8s ease forwards;
        }

        /* Delays for step-by-step animation */
        .fade-right.delay-1 {
            animation-delay: 0.2s;
        }

        .fade-right.delay-2 {
            animation-delay: 0.4s;
        }

        /* Keyframes */
        @keyframes fadeRight {
            from {
                opacity: 0;
                transform: translateX(-25px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* ================= DASHBOARD GRADIENT ================= */


        /* Cards */
        .dashboard-gradient .card {
          background: linear-gradient(180deg, #141010, #632d2d, #f44d4d8e);
            border: 1px solid #e0e0e0;
            border-radius: 16px;
        }

        /* Headings */
        .dashboard-gradient h2,
        .dashboard-gradient h5 {
            color: #ffffff;
        }

        /* Tables */
        .dashboard-gradient .table {
            background: #fff;
        }

        .dashboard-gradient .table thead {
            background: linear-gradient(135deg, #eaeaea, #dcdcdc);
        }

        /* underline */
        .section-title::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;

            width: 0;
            height: 3px;

            background: linear-gradient(90deg, #bdbdbd, #ffffff);
            border-radius: 3px;

            transition: width 0.6s ease;
        }



        /* ================= ANIMATED HEADING UNDERLINE ================= */
.dispaly-6 ,p{   
    color: #fff!important; 
}
        .section-title {
            position: relative;
            display: inline-block;
            padding-bottom: 12px;
        }

        /* underline */
        .section-title::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;

            width: 0;
            height: 3px;

            background: linear-gradient(90deg, #bdbdbd, #ffffff);
            border-radius: 3px;

            transition: width 0.6s ease;
        }

        /* animate on load */
        .section-title.animate::after {
            width: 70%;
        }

        /* center aligned headings */
        .text-center .section-title::after {
            left: 50%;
            transform: translateX(-50%);
        }

         h6 {
    margin-top: 0;
    margin-bottom: .5rem;
    font-weight: 500;
    line-height: 1.2;
    color:white !important;
}

.mb-0 {
    margin-bottom: 0 !important;    
    color: #fff!important;
}

        /* ================= IMAGE ROUND + WHITE GLOW ================= */

        .believe-image {
            border-radius: 50%;
            /* rounded corners */
            background: rgba(255, 255, 255, 0.08);

            /* White glow shadow */
            box-shadow:
                0 0 25px rgba(255, 255, 255, 0.25),
                0 0 60px rgba(255, 255, 255, 0.15);

            padding: 14px;

            /* Smooth hover animation */
            transition:
                transform 0.4s ease,
                box-shadow 0.4s ease;
        }

        /* Hover effect (optional but looks premium) */
        .believe-image:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow:
                0 0 35px rgba(255, 255, 255, 0.35),
                0 0 80px rgba(255, 255, 255, 0.2);
        }

        /* ================= CTA SECTION ================= */
        .cta-section {
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .cta-box {
            max-width: 100vw;
            padding: 60px 30px;
            border-radius: 22px;

            background: linear-gradient(145deg, #1c1c1c, #000);
            border: 1px solid rgba(255, 255, 255, 0.12);

            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.8),
                inset 0 0 0 1px rgba(255, 255, 255, 0.04);
        }

        /* Buttons hover polish */
        .cta-box .btn-light:hover {
            background: #ffffff;
            color: #000;
            transform: translateY(-2px);
        }

        .cta-box .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* ===== Glass Gradient Modal ===== */
        .modal-content {
            background: linear-gradient(135deg,
                    rgba(0, 0, 0, 0.85),
                    rgba(255, 255, 255, 0.15));
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);

            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow:
                0 20px 50px rgba(0, 0, 0, 0.6),
                inset 0 0 0 rgba(255, 255, 255, 0.05);

            color: #fff;
        }

        /* Modal header */
        .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        /* Close button */
        .modal-header .btn-close {
            filter: invert(1);
        }

        /* Inputs */
        .modal-content input {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #fff;
        }

        .modal-content input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        /* Login/Register button */
        .modal-content .btn-primary {
            background: linear-gradient(135deg, #000, #444);
            border: none;
            color: #fff;
            font-weight: 600;
        }

        .modal-content .btn-primary:hover {
            background: linear-gradient(135deg, #111, #666);
        }

        /* Tabs (Login / Register) */
        .nav-tabs {
            border-bottom: none;
        }

        .nav-tabs .nav-link {
            background: transparent;
            color: rgba(255, 255, 255, 0.6);
            border: none;
            font-weight: 500;
        }

        .nav-tabs .nav-link.active {
            color: #070707;
            border-bottom: 2px solid #fff;


        }

        /* ===== TABLE HEADER GRADIENT ===== */
        .table thead th {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            color: #ffffff;
            border-color: #1f1f1f;
        }

        /* ===== TABLE ROWS ===== */
        .table tbody tr {
            background-color: #ffffff;
        }

        /* ===== TABLE BORDER ===== */
        .table {
            border: 1px solid #2c2c2c;
        }

        /* ===== HOVER EFFECT ===== */
        .table tbody tr:hover {
            background-color: #f1f5f9;
        }

        /* ===== BUTTON ALIGNMENT FIX ===== */
        .table td {
            vertical-align: middle;
        }

        /* ===== DASHBOARD MAIN CARD GRADIENT ===== */
        .dashboard-bg .container.bg-white {
            background: linear-gradient(135deg,
                    #0f2027,
                    #000000,
                    #3b4042) !important;
            color: #e6d9d9;
        }

        /* ===== TEXT FIX FOR HEADINGS ===== */
        .dashboard-bg h3,
        .dashboard-bg th {
            color: #ffffff;
        }

        /* ===== TABLE BODY TEXT ===== */
        .dashboard-bg td {
            color: #f0e8e8;
            background: linear-gradient(135deg,
                    #0f2027,
                    #000000,
                    #3b4042)
        }

        .btn {
            border-radius: 15px;
            color: #f0e8e8;
            background: linear-gradient(135deg,
                    #0f2027,
                    #000000,
                    #3b4042)
        }

        body {

            background-image: url(../assets/background.jpg);
            background-size: cover;
            background-position: center;
        }

        .dashboard-gradient {
            background: linear-gradient(135deg,
                    #181866,
                    #000000,
                    #3b4042),
        }

        /* ===== GLASS CARDS ===== */
        .card {
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);

            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.35);

            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }

        /* ===== PROGRESS BAR GLASS ===== */
        .progress {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(8px);
            border-radius: 20px;
            overflow: hidden;
        }

        /* ===== GLASS CARDS ===== */
        .card {
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);

            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.35);

            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }

        /* ===== PROGRESS BAR GLASS ===== */
        .progress {
            background: rgba(56, 55, 55, 0.4);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            overflow: hidden;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid d-flex justify-content-between align-items-center">

            <!-- LEFT -->
            <span class="navbar-brand mb-0 h1">
                Task Scheduler
            </span>

            <!-- RIGHT -->
            <div>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <button type="button"
                        class="btn btn-outline-light me-2"
                        data-bs-toggle="modal"
                        data-bs-target="#authModal"
                        onclick="openLoginTab()">
                        Login
                    </button>

                    <button type="button"
                        class="btn gradient-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#authModal"
                        onclick="openRegisterTab()">
                        Register
                    </button>
                <?php else: ?>
                    <span class="text-white me-3">Hi,
                        <?= htmlspecialchars($_SESSION['name']) ?>
                    </span>
                    <a href="auth/logout.php" class="btn btn-danger">
                        Logout
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </nav>

    <!-- AUTH MODAL -->
    <div class="modal fade" id="authModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- Tabs -->
                    <ul class="nav nav-tabs mb-3 glass-tabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active glass-tab-btn"
                                data-bs-toggle="tab"
                                data-bs-target="#loginTab"
                                type="button">
                                Login
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link glass-tab-btn"
                                data-bs-toggle="tab"
                                data-bs-target="#registerTab"
                                type="button">
                                Register
                            </button>
                        </li>
                    </ul>


                    <!-- Tab Content -->
                    <div class="tab-content">

                        <!-- LOGIN TAB -->
                        <div class="tab-pane fade show active" id="loginTab">
                            <form method="POST" action="auth/login.php">
                                <input type="email"
                                    name="email"
                                    class="form-control mb-2"
                                    placeholder="Email"
                                    required>

                                <input type="password"
                                    name="password"
                                    class="form-control mb-3"
                                    placeholder="Password"
                                    required>

                                <button class="btn btn-primary w-100">
                                    Login
                                </button>
                            </form>
                        </div>

                        <!-- REGISTER TAB -->
                        <div class="tab-pane fade" id="registerTab">
                            <form method="POST" action="auth/register.php">
                                <input type="text"
                                    name="name"
                                    class="form-control mb-2"
                                    placeholder="Name"
                                    required>

                                <input type="email"
                                    name="email"
                                    class="form-control mb-2"
                                    placeholder="Email"
                                    required>

                                <input type="password"
                                    name="password"
                                    class="form-control mb-3"
                                    placeholder="Password"
                                    required>

                                <button class="btn btn-warning w-100">
                                    Register
                                </button>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>