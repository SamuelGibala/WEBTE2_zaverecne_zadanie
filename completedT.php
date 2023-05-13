<?php
session_start();
require_once('config.php');
// Check if user is not logged in
if (!isset($_SESSION['email'])) {
    header("Location: ./");
    exit();
}
if ($_SESSION['role'] === "student") {
    header("Location: homeS.php");
}



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css" rel="stylesheet"/>
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
                    <span>Generovanie úloh</span>
                </a>
                <a
                    href="#"
                    class="list-group-item list-group-item-action py-2 ripple active"
                >
                    <i class="fa-solid fa-list"></i>
                    <span>Zoznam študentov</span>
                </a>
                <a
                        href="./addPerson.php"
                        class="list-group-item list-group-item-action py-2 ripple"
                >
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Pridať osobu</span>
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

            <div style="margin: 0 auto">
                TESTY
            </div>

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
        <h2>Zoznam študentov</h2>
        <hr />
        <div class="table-responsive">
           <table id="example" class="dataTable display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Meno</th>
                        <th>Priezvisko</th>
                        <th>Email</th>
                        <th>Počet vygenerovaných úloh</th>
                        <th>Počet odovzdaných úloh</th>
                        <th>Počet bodov</th>
                    </tr>
                </thead>
               <tbody>
                   <?php
                       foreach ($rows as $row)
                       {
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
</body>
</html>
