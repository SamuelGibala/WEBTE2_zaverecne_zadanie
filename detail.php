<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$detail_id = $_GET["id"];

require_once('config.php');
require_once('language.php');

// Check if user is not logged in
if (!isset($_SESSION['email'])) {
    header("Location: ./");
    exit();
}

if ($_SESSION['role'] === "student") {
    header("Location: homeS.php");
}

try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT  email, name, surname, id as u_id FROM users WHERE role = 'student'";
    $stm = $db->query($query);
    $rows = $stm->fetchAll(PDO::FETCH_ASSOC);

    $query = "SELECT * FROM users u WHERE u.id =" . $detail_id;
    $stmt = $db->query($query);
    $person = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $query = "SELECT task, task_result, student_result, score FROM tests t  WHERE t.student_id =" . $detail_id;
    $stmt = $db->query($query);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $db->prepare("select tests.id as 'id', ts.task_name as 'task_name', tests.score as 'score',ts.score as 'tot_score' from tests join task_set ts on ts.id = tests.set_id where student_id= :id and student_result is not null order by tests.timestamp desc");
    $stmt->bindParam(':id', $detail_id);
    $stmt->execute();
    $tests = $stmt->fetchAll(PDO::FETCH_ASSOC);



} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>

<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/table.css">
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
                    height="40"
                    alt=""
                    loading="lazy"
                />
            </a>

            <div style="margin: 0 auto"><?php echo get_localized('menu_header') ?></div>

            <!-- Right links -->
            <ul class="navbar-nav d-flex flex-row">
                <!-- Notification dropdown -->
                <li><?php echo $_SESSION['email']?></li>
                <li style="margin-left: 10px"> <a href="logout.php"><i class="fa-solid fa-right-from-bracket fa-xl" style="color: #cd0a0a;"></i></a> </li>

            </ul>
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
</header>
<!--Main Navigation-->
<!--Main layout-->
<main style="margin-top: 50px">
    <div class="container pt-4">
        <h2><?php echo get_localized('student_detail') ?></h2>
        <hr />
        <div class="pageElement">
            <div class="formLogin2 table-responsive" id="specs">
                <table class="table table-borderless myTable">
                    <?php
                        foreach ($person as $persona) {
                            echo ("<tr><th>" . get_localized('form_name') . ": </th><td>{$persona['name']}</td></tr>");
                            echo ("<tr><th>" . get_localized('form_surname') . ": </th><td>{$persona['surname']}</td></tr>");
                            echo ("<tr><th>Email: </th><td>{$persona['email']}</td></tr>");
                            echo ("<tr><th>" . get_localized('form_role') . ": </th><td>{$persona['role']}</td></tr>");
                        }
                    ?>
                </table>
            </div>
        </div>
        <h2><?php echo get_localized('student_detail_task_list') ?></h2>
        <hr />
        <ul class="list-group">
            <?php
            if (count($tests) == 0) {
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
                            <form action="./checkT.php" method="post">
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
</main>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.js"></script>
</body>
</html>