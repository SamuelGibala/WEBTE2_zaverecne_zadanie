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

function sendPostRequest($url, $jsonData) {
    $ch = curl_init($url);

    $jsonDataEncoded = json_encode($jsonData);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);

    curl_close($ch);

    $response = json_decode($result, true);
    $apiResult = $response['result'];

    return $apiResult;
}

function addBackslash($string) {
    $result = '';
    $length = strlen($string);

    for ($i = 0; $i < $length; $i++) {
        if ($string[$i] === '\\') {
            $result .= '\\';
        }
        $result .= $string[$i];
    }

    return $result;
}

if (isset($_POST['id'])) {
    $stmt = $conn->prepare("select * from tests where id = :id");
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->execute();
    $test = $stmt->fetch(PDO::FETCH_ASSOC);
}
elseif(isset($_POST['solution'])) {

    $stmt = $conn->prepare("select ts.score as 'tot_score', t.task_result as 'task_result' from tests t join task_set ts on ts.id = t.set_id where t.id = :id");
    $stmt->bindParam(':id', $_POST['test_id']);
    $stmt->execute();
    $test2 = $stmt->fetch(PDO::FETCH_ASSOC);

    $corr_result = $test2['task_result'];
    //$expr1 = addBackslash($corr_result);
    //$expr2 = addBackslash($_POST['solution']);


    $data = array(
        "expr1" => $corr_result,
        "expr2" => $_POST['solution']
    );

    $response = sendPostRequest('https://site93.webte.fei.stuba.sk:9001/porovnaj2', $data);

    if ($response==1){
        $tot_score = $test2['tot_score'];
    }else{
        $tot_score = 0;
    }

    $stmt = $conn->prepare("UPDATE tests SET student_result = :result, score = :score WHERE id = :id");
    $stmt->bindParam(':id', $_POST['test_id']);
    $stmt->bindParam(':result', $_POST['solution']);
    $stmt->bindParam(':score', $tot_score);
    $stmt->execute();
    $test = $stmt->fetch(PDO::FETCH_ASSOC);
    header("Location: ./completedS.php");
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
    <title>Test solver</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <link
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
            rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
            href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
            rel="stylesheet"
    />
    <!-- MDB -->
    <link
            href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css"
            rel="stylesheet"
    />
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <style>
        body {
            --keycap-height: 2.5rem;
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
    <div class="container-md pt-4">
        <div class="mx-0 mx-sm-auto">
            <div class="card">
                <div class="card-body">
                    <form action="#" method="post" onsubmit="return validateForm();">
                    <div class="text-center">
                        <p>
                            <strong><?php echo $test['task']?></strong>
                        </p>
                        <?php if($test['task_image'] != null){
                        echo '<img src="./zadania/images/' . $test['task_image'] . '" style="width:60%">';
                        } ?>
                        <p>
                            <strong><?php echo get_localized('check_input') ?></strong>
                        </p>
                        <p>
                            <math-field style="
                            width: 45%;
                            font-size: 32px;
                            padding: 8px;
                            border-radius: 8px;
                            border: 1px solid rgba(0, 0, 0, .3);
                            box-shadow: 0 0 8px rgba(0, 0, 0, .2);
                            --caret-color: red;
                            --selection-background-color: lightgoldenrodyellow;
                            --selection-color: darkblue;
                            " id="formula">

                            </math-field>
                        </p>
                        <input hidden name="solution" id="sol" value="">
                        <input hidden name="test_id" value="<?php echo $test['id']?>">

                        <button type="submit" class="btn btn-primary" style="width: 45%"><?php echo get_localized('solve_submit_btn') ?></button>
                    </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
    <input type="hidden" id="err_solve_empty" value="<?php echo get_localized('err_solve_empty') ?>">
</main>
<?php add_info_modal() ?>
<script defer src="//unpkg.com/mathlive"></script>
<script>
    area = document.getElementById('sol');
    document.getElementById('formula').addEventListener('input',(ev) => {
// `ev.target` is an instance of `MathfieldElement`
        area.value = ev.target.value;
    });

    function validateForm(){
        if (area.value.trim() === ""){
            alert(document.getElementById('err_solve_empty').value);
            return false;
        }
    }
</script>
<script>
    MathJax = {
        tex: {
            inlineMath: [['$', '$'], ['\\(', '\\)']]
        }
    };
</script>
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

