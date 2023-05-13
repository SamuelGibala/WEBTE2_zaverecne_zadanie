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
try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $db->prepare("SELECT id, task_name, term_start, deadline FROM task_set");
    $stmt->execute();
    $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$folderPath = 'zadania/testy';
$files = scandir($folderPath);


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['task_name'];
    $body = $_POST['score'];
    $start = $_POST['term_start'];
    $deadline = $_POST['deadline'];

    foreach ($datas as $data){
        if ($data['task_name'] === $name ){
            echo '<script>alert("Názov úlohy sa už nachádza"); window.location.href = "./homeT.php";</script>';
        }
    }
    $sql = "INSERT INTO task_set (task_name, term_start, deadline, score) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $name);
    if ($start == null && $deadline == null ){
        $stmt->bindParam(2, $start, PDO::PARAM_NULL);
        $stmt->bindParam(3, $deadline, PDO::PARAM_NULL);
    }elseif ($start == null){
        $stmt->bindParam(2, $start, PDO::PARAM_NULL);
        $stmt->bindParam(3, $deadline);
    }elseif ($deadline == null){
        $stmt->bindParam(2, $start);
        $stmt->bindParam(3, $deadline, PDO::PARAM_NULL);
    } else{
        $stmt->bindParam(2, $start);
        $stmt->bindParam(3, $deadline);
    }
    $stmt->bindParam(4, $body);
    $stmt->execute();

    $taskID = $db->lastInsertId();

    if (isset($_POST['file'])) {
        $selectedFiles = $_POST['file'];
        foreach ($selectedFiles as $file) {
            $sql = "INSERT INTO task (set_id, file_name) VALUES (?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(1, $taskID);
            $stmt->bindParam(2, $file);
            $stmt->execute();
            header("Location: ./homeT.php");
        }
    }
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
                        href="#"
                        class="list-group-item list-group-item-action py-2 ripple active"
                        aria-current="true"
                >
                    <i class="fa-solid fa-pen"></i>
                    <span>Generovanie úloh</span>
                </a>
                <a
                        href="./completedT.php"
                        class="list-group-item list-group-item-action py-2 ripple"
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
        <hgroup>
            <h2>Vygenerovanie úloh pre študentov</h2>
        </hgroup>
        <hr />
        <form action="#" method="post" onsubmit="return validateForm();">
            <table class="tableS">
                <thead>
                <tr><td>Názov úlohy</td><td>Dátum odkedy</td><td>Dátum dokedy</td><td>Body</td></tr>
                </thead>
                <tbody>
                <tr>
                    <td><input type='text' name='task_name' class='form-control' id='name' value="Názov" required></td>
                    <td><input type='datetime-local' name='term_start' class='form-control' id='InputDate' value="0"></td>
                    <td><input type='datetime-local' name='deadline' class='form-control' id='InputDate' value="0"></td>
                    <td><input type='number' name='score' class='form-control' id='body' value='body' required></td>
                </tr>
                </tbody>
            </table>
            <?php
            foreach ($files as $file) {
                if (is_dir($folderPath . '/' . $file) || strpos($file, '.') === 0) {
                    continue;
                }
                echo '<input type="checkbox" name="file[]" value="' . $file . '" style="margin-right: 5px">' . $file . '<br>';
            }
            ?>
            <button type='submit' class="btn btn-primary">Priradiť</button>
        </form>
    </div>
</main>
<script>
    function validateForm() {

        var checkboxes = document.getElementsByName('file[]');

        var isChecked = false;
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                isChecked = true;
                break;
            }
        }

        if (!isChecked) {
            alert("Zaškrtni aspoň jedno políčko!");
            return false; // Prevent form submission
        }
    }
</script>
</body>
</html>
