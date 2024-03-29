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
if ($_SESSION['role'] === "student") {
    header("Location: homeS.php");
}

$conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['id'])) {
    $stmt = $conn->prepare("select * from tests where id = :id");
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->execute();
    $test = $stmt->fetch(PDO::FETCH_ASSOC);
}
else {
    header("Location: ./");
    exit();
}
?>

<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test detail</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/table.css">
    <link rel="stylesheet" href="./css/responsive.css">
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
                    href="./homeT.php"
                    class="list-group-item list-group-item-action py-2 ripple"
                    aria-current="true"
                >
                    <i class="fa-solid fa-pen"></i>
                    <span><?php echo get_localized('menu_create_tasks') ?></span>
                </a>
                <a
                    href="./taskT.php"
                    class="list-group-item list-group-item-action py-2 ripple "
                    aria-current="true"
                >
                    <i class="fa-solid fa-list-check"></i>
                    <span><?php echo get_localized('menu_list_tasks') ?></span>
                </a>
                <a
                    href="./completedT.php"
                    class="list-group-item list-group-item-action py-2 ripple "
                >
                    <i class="fa-solid fa-list"></i>
                    <span><?php echo get_localized('menu_list_students') ?></span>
                </a>
                <a
                    href="./addPerson.php"
                    class="list-group-item list-group-item-action py-2 ripple"
                >
                    <i class="fa-solid fa-user-plus"></i>
                    <span><?php echo get_localized('menu_create_user') ?></span>
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
                        alt="FEI logo"
                        loading="lazy"
                        class="logos"
                />
            </a>

            <div style="margin: 0 auto"> <img src="flags/logo-no-background.png" class="logos" alt="e-FEIster"></div>

            <!-- Right links -->
            <ul class="navbar-nav d-flex flex-row">
                <!-- Notification dropdown -->
                <?php add_info_modal_btn() ?>
                <input type="hidden" name="id" form="lang_form" value="<?php echo $_POST['id'] ?>">
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

<!--Main layout-->
<main style="margin-top: 50px">
    <div class="container pt-4">
        <div class="mx-0 mx-sm-auto">
            <div class="card">
                <div class="card-body">

                    <div class="text-center">
                        <p>
                            <strong><?php echo $test['task']?></strong>
                        </p>
                        <?php if($test['task_image'] != null){
                            echo '<img src="./zadania/images/' . $test['task_image'] . '" style="width:60%">';
                        } ?>
                        <p>
                            <strong><?php echo get_localized('check_correct_result') ?></strong>
                        </p>
                        <p>
                            <strong>$<?php echo $test['task_result']?>$</strong>
                        </p>
                        <p>
                            <strong><?php echo get_localized('check_input') ?></strong>
                        </p>
                        <p>
                            <strong>$<?php echo $test['student_result']?>$</strong>
                        </p>
                        <p>
                            <strong><?php echo get_localized('check_points') ?> <?php echo $test['score']?></strong>
                        </p>
                    </div>

                </div>

            </div>
        </div>
    </div>
</main>
<?php add_info_modal() ?>
<script>
    MathJax = {
        tex: {
            inlineMath: [['$', '$'], ['\\(', '\\)']]
        }
    };
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.js"></script>
<script id="MathJax-script" async
        src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js">
</script>
<script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.js"
></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="./fonts/SourceSansPro-Regular-normal.js"></script>
<script src="./js/info_modal_pdf.js"></script>
</body>
</html>
