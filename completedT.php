<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
require_once("config.php");
try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //$query = "SELECT  u.id, u.email, u.name, u.surname, COUNT(t.student_id) as Pocet_uloh FROM users u WHERE role = 'student' join tests t on u.id = t.student_id";
   /* $query =  "SELECT u.id AS user_id, u.name, u.surname, u.email, COUNT(t.task) AS number_of_tasks, SUM(t.score) AS total_score, COUNT(t.student_result) AS number_submit
                    FROM users u
                        JOIN tests t ON u.id = t.student_id
                            WHERE u.role = 'student'
                                GROUP BY u.id, u.name, u.surname, u.email";*/
    $query = "SELECT u.id AS user_id, u.name, u.surname, u.email, COUNT(t.task) AS number_of_tasks, SUM(t.score) AS total_score, COUNT(t.student_result) AS number_submit
                FROM users u
                    LEFT JOIN tests t ON u.id = t.student_id
                        WHERE u.role = 'student'
                            GROUP BY u.id, u.name, u.surname, u.email";
    $stm = $db->query($query);
    $rows = $stm->fetchAll(PDO::FETCH_ASSOC);


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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.css">
    <link href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/table.css">
    <style>
        .container {
            margin-left: 20px;
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
                    href="#"
                    class="list-group-item list-group-item-action py-2 ripple active"
                    aria-current="true"
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
        <h2><?php echo get_localized('menu_list_students') ?></h2>
        <hr />
        <div class="table-responsive">
           <table id="example" class="dataTable display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th><?php echo get_localized('form_name') ?></th>
                        <th><?php echo get_localized('form_surname') ?></th>
                        <th>Email</th>
                        <th><?php echo get_localized('list_students_assigned_tasks_count') ?></th>
                        <th><?php echo get_localized('list_students_finished_tasks_count') ?></th>
                        <th><?php echo get_localized('list_students_points_count') ?></th>
                    </tr>
                </thead>
               <tbody>
                   <?php
                    foreach ($rows as $row) {
                        echo("<tr><td>{$row['user_id']}</td> <td>{$row['name']}</td> <td>{$row['surname']}</td><td>{$row['email']}</td><td>{$row['number_of_tasks']}</td><td>{$row['number_submit']}</td><td>{$row['total_score']}</td></tr> ");
                    }
                   ?>
               </tbody>
            </table>
        </div>
    </div>
</main>

<script>
    <?php
    $js_array = json_encode($rows);
    echo "var data = ". $js_array . ";\n";
    ?>
    $(document).ready( function () {
        table = $('#example').DataTable({
            order: [[2, 'asc']],
            "pagingType": "full_numbers",
            "bInfo" : false
        });
    });
    $('#example tbody').on('click', 'tr', function() {
        var data = table.row(this).data();
        var id = data[0];
        console.log(id);
        window.location.href = "detail.php?id=" + id;
    });
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.js"></script>
</body>
</html>
