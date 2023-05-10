<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$detail_id = $_GET["id"];
require_once('config.php');
// Check if user is not logged in
if (!isset($_SESSION['email'])) {
    header("Location: ./");
    exit();
}

try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT  email, name, surname, numbergeneratetask,numbersubmittask, id as u_id FROM users WHERE role = 'student'";
    $stm = $db->query($query);
    $rows = $stm->fetchAll(PDO::FETCH_ASSOC);

    $query = "SELECT * FROM users u WHERE u.id =" . $detail_id;
    $stmt = $db->query($query);
    $person = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

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
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.js"></script>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/table.css">
    <link  rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
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
                    <span>Vygenerovanie úloh</span>
                </a>
                <a
                    href="./completedT.php"
                    class="list-group-item list-group-item-action py-2 ripple "
                >
                    <i class="fa-solid fa-list"></i>
                    <span>Zoznam študentov</span>
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
<main style="margin-top: 58px">
    <div class="container pt-4">
        <h2>Detail Študenta</h2>
        <div class="pageElement">
            <div class="formLogin2 table-responsive" id="specs">
                <table class="table table-borderless myTable">
                    <tr><th>Meno: </th> <td><?php echo ($person[0]['name']);?></td></tr>
                    <tr><th>Priezvisko: </th> <td><?php echo $person[0]['surname'];?></td></tr>
                    <tr><th>Email: </th> <td><?php echo $person[0]['email'];?></td></tr>
                    <tr><th>Typ: </th> <td><?php echo $person[0]['role'];?></td></tr>
                </table>
            </div>
        </div>
        <h2>Zoznam štedentov</h2>
        <table id="example" class="dataTable display" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Meno</th>
                <th>Priezvisko</th>
                <th>Počet vygenerovaných úloh</th>
                <th>Počet odovzdaných úloh</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($rows as $row)
            {
                echo("<tr><td>{$row['u_id']}</td> <td>{$row['name']}</td> <td>{$row['surname']}</td><td>{$row['email']}</td><td>{$row['email']}</td> </tr> ");
            }
            ?>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>