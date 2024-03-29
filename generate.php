<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require 'parse.php';
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

if (isset($_POST['set_id'])) {
    $stmt = $conn->prepare("select * from task where set_id = :id");
    $stmt->bindParam(':id', $_POST['set_id']);
    $stmt->execute();
    $set_tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif (isset($_POST['checkbox'])) {
    $checkedCheckboxes = $_POST['checkbox'];
    $arr = array();
    // Loop through the checked checkboxes and echo their values
    foreach ($checkedCheckboxes as $checkboxValue) {
        $arr[] = $checkboxValue;
    }
    $task = getRandomTask($arr);
    $stmt = $conn->prepare("insert into tests (student_id, task, task_image, task_result, set_id) values (?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['id'],$task['task'],$task['image'],$task['equation'], $_POST['set']]);
    header("Location: ./");
    exit();

}
else {
    header("Location: ./");
    exit();
}

?>

<!doctype html>
<html lang="sk">
<head>
    <title>Test generator</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="./css/style.css">
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
                        href="./"
                        class="list-group-item list-group-item-action py-2 ripple"
                        aria-current="true"
                >
                    <i class="fa-solid fa-pen"></i>
                    <span><?php echo get_localized('menu_assigned_tasks') ?></span>
                </a>
                <a
                        href="./completedS.php"
                        class="list-group-item list-group-item-action py-2 ripple"
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
                <input type="hidden" name="set_id" form="lang_form" value="<?php echo $_POST['set_id'] ?>">
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
        <h3><?php echo get_localized('create_tasks') ?></h3>
        <hr />
        <div class="container ms-4 mt-4">
            <p><?php echo get_localized('create_tasks_files') ?></p>
            <form method="post" action="#" onsubmit="return validateForm();">
                <?php
                // Loop through the array to create checkboxes
                foreach ($set_tasks as $task) {
                    $checkboxName = $task['file_name'];
                    $checkboxId = $task['id'];
                    echo '<div class="form-check d-flex justify-content-left mb-4">';
                    echo '<input type="checkbox" class="form-check-input me-2" value = "' . $checkboxName . '" name="checkbox[]" id="' . $checkboxId . '">';
                    echo '<label for="' . $checkboxId . '" class="form-check-label">' . $checkboxName . '</label><br>';
                    echo '</div>';
                }
                ?>
                <input type="number" hidden name="set" value="<?php echo $_POST['set_id']?>">
                <button type="submit" class="btn btn-primary"><?php echo get_localized('create_tasks_submit_btn') ?></button>
            </form>
        </div>
    </div>
    <input type="hidden" id="err_file_req" value="<?php echo get_localized('create_tasks_file_req') ?>">
</main>
<?php add_info_modal() ?>
<script>
    function validateForm() {
        // Get all the checkboxes
        var checkboxes = document.getElementsByName('checkbox[]');

        // Check if at least one checkbox is checked
        var isChecked = false;
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                isChecked = true;
                break;
            }
        }

        // Display an alert if no checkbox is checked
        if (!isChecked) {
            alert(document.getElementById('err_file_req').value);
            return false; // Prevent form submission
        }
    }
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="./fonts/SourceSansPro-Regular-normal.js"></script>
<script src="./js/info_modal_pdf.js"></script>
</body>
</html>