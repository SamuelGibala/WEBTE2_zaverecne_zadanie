<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');
require_once('language.php');
require_once('info_modal.php');

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
    if (switch_lang()) {}
    else {
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
}


?>
<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Teacher home</title>
    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>

    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/table.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <style>
        .container {
            margin-left: 20px;
            max-width: 500px;
            padding: 20px;
            border-radius: 5px;
        }
        h2 {
            margin-bottom: 20px;
            margin-right: 20px;
        }
        form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        input[type="datetime-local"] {
            width: 100%;
            padding: 5px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
                        href="#"
                        class="list-group-item list-group-item-action py-2 ripple active"
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
                        class="list-group-item list-group-item-action py-2 ripple"
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
<!--Main Navigation-->

<!--Main layout-->
<main style="margin-top: 50px">
    <div class="container pt-4">
        <hgroup>
            <h2><?php echo get_localized('create_tasks_teacher') ?></h2>
        </hgroup>
        <hr />
        <form action="#" method="post" onsubmit="return validateForm();">
                <div class="form-outline mb-4">
                    <label class="form-label" for="task_name"><?php echo get_localized('create_tasks_teacher_task_name') ?></label>
                    <input type="text" name="task_name"  id="task_name" required>
                </div>
                <div class="form-outline mb-4">
                    <label class="form-label" for="term_start"><?php echo get_localized('create_tasks_teacher_start_date') ?></label>
                    <input type="datetime-local" name="term_start" id="term_start">
                </div>
                <div class="form-outline mb-4">
                    <label class="form-label" for="deadline"><?php echo get_localized('create_tasks_teacher_end_date') ?></label>
                    <input type="datetime-local" name="deadline" id="deadline">
                </div>
                <div class="form-outline mb-4">
                    <label class="form-label"  for="score"><?php echo get_localized('create_tasks_teacher_points') ?></label>
                    <input type="number" name="score"  id="score" required>
                </div>
            <?php
            $count = 0;
            foreach ($files as $file) {
                $count++;
                if (is_dir($folderPath . '/' . $file) || strpos($file, '.') === 0) {
                    continue;
                }
                echo '<div class="form-check">';
                echo '<input class="form-check-input" type="checkbox" id="fileCheck' . $count . '" name="file[]" value="' . $file . '" style="margin-right: 5px">' . $file . '<br>';
                echo '<label class="form-check-label" for="fileCheck' . $count . '"></label>';
                echo '</div>';
            }
            ?>
            <button type='submit' class="btn btn-primary" style="width: 100%"><?php echo get_localized('create_tasks_teacher_submit_btn') ?></button>
        </form>
    </div>
</main>
<input type="hidden" id="err_missing_file" value="<?php echo get_localized('create_tasks_teacher_submit_btn') ?>">
<?php add_info_modal() ?>
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
            alert(document.getElementById('err_missing_file').value);
            return false; // Prevent form submission
        }
    }
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="./js/info_modal_pdf.js"></script>
</body>
</html>
