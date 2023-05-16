<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');
require_once('language.php');
require_once('info_modal.php');

switch_lang();

// Check if user is not logged in
if (!isset($_SESSION['email'])) {
    header("Location: ./");
    exit();
}
if ($_SESSION['role'] === "teacher") {
    header("Location: homeT.php");
}

$conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("select tests.id as 'id', ts.task_name as 'task_name', tests.score as 'score',ts.score as 'tot_score' from tests join task_set ts on ts.id = tests.set_id where student_id= :id and student_result is not null order by tests.timestamp desc");
$stmt->bindParam(':id', $_SESSION['id']);
$stmt->execute();
$tests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="sk">
<head>
    <title>Home Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .accordion-card {
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .accordion-card .card-header {
            border-radius: 10px;
        }
    </style>
</head>
<body>
<header>
    <!-- Sidebar -->
    <nav
            id="sidebarMenu"
            class="collapse d-lg-block sidebar collapse bg-white"
    >
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a
                        href="./homeS.php"
                        class="list-group-item list-group-item-action py-2 ripple"
                        aria-current="true"
                >
                    <i class="fa-solid fa-pen"></i>
                    <span><?php echo get_localized('menu_assigned_tasks') ?></span>
                </a>
                <a
                        href="#"
                        class="list-group-item list-group-item-action py-2 ripple active"
                >
                    <i class="fa-solid fa-list"></i>
                    <span><?php echo get_localized('menu_done_tasks') ?></span>
                </a>
            </div>
        </div>
    </nav>
    <!-- Sidebar -->

    <!-- Navbar -->
    <nav
            id="main-navbar"
            class="navbar navbar-expand-lg navbar-light bg-white fixed-top"
    >
        <!-- Container wrapper -->
        <div class="container-fluid">
            <!-- Toggle button -->
            <button
                    class="navbar-toggler"
                    type="button"
                    data-mdb-toggle="collapse"
                    data-mdb-target="#sidebarMenu"
                    aria-controls="sidebarMenu"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
            >
                <i class="fas fa-bars"></i>
            </button>

            <a class="navbar-brand" href="#">
                <img
                        src="https://am2023.sski.sk/wp-content/uploads/2023/01/feistu.png"
                        height="40"
                        alt=""
                        loading="lazy"
                />
            </a>

            <div style="margin: 0 auto"><?php echo get_localized('menu_header') ?></div>

            <!-- Right links -->
            <ul class="navbar-nav d-flex flex-row">
                <!-- Notification dropdown -->
                <?php add_info_modal_btn() ?>
                <?php get_lang_dropdown() ?>
                <li class="ms-4 nav-item navbar-text"><?php echo $_SESSION['email']?></li>
                <li class="ms-3 nav-item navbar-text">
                    <a href="logout.php">
                        <i class="fa-solid fa-right-from-bracket fa-xl" style="color: #cd0a0a;"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
</header>

<main style="margin-top: 50px">
    <div class="container pt-4">
        <div class="container-fluid">
            <h3><?php echo get_localized('menu_done_tasks') ?></h3>
            <hr />
            <ul class="list-group">
                <?php
                if (count($tests) == 0){
                    echo 
                    '<li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h5>' . get_localized('done_tasks_none_found') . '</h5>
                        </div>
                    </li>';
                } 
                else {
                    foreach ($tests as $item) {
                        $labelScore = $item['score'] . "/" . $item['tot_score'] . " " . get_localized('student_detail_points');
                        echo 
                        '<li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-left">' . $item['task_name'] . '</span>
                            <span class="text-center">' . $labelScore . '</span>
                            <div>
                                <form action="./check.php" method="post">
                                    <input type="hidden" name="id" value="' . $item['id'] . '">
                                    <button type="submit" class="btn btn-primary">' . get_localized('done_tasks_detail') . '</button>
                                </form>
                            </div>
                        </li>';
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</main>
<?php add_info_modal() ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="./js/info_modal_pdf.js"></script>
</body>
</html>