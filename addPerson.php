<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('config.php');
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

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (empty($name)) {
        echo '<script>alert("Meno je povinné"); window.location.href = "./addPerson.php";</script>';
        exit();
    }


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Zlý formát emailu"); window.location.href = "./addPerson.php";</script>';
        exit();
    }


    if (strlen($password) < 6) {
        echo '<script>alert("Heslo musí mať najmenej 6 znakov"); window.location.href = "./addPerson.php";</script>';
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (name, surname, email, password, role) VALUES (?, ?, ?, ?,?)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $surname);
    $stmt->bindParam(3, $email);
    $stmt->bindParam(4, $hashedPassword);
    $stmt->bindParam(5, $role);
    $stmt->execute();

    // Display success message
    echo "User registration successful!";
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
    <style>
        .container {
            margin-left: 20px;
            max-width: 400px;
            padding: 20px;
            border-radius: 5px;
        }

        h2 {
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
        .custom-radio {
            display: inline-block;
            position: relative;
            padding-left: 25px;
            margin-right: 15px;
            cursor: pointer;
            font-size: 16px;
        }

        .custom-radio input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: #ccc;
            border-radius: 50%;
        }

        .custom-radio input:checked ~ .checkmark {
            background-color: #2196F3;
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .custom-radio input:checked ~ .checkmark:after {
            display: block;
        }

        .custom-radio .checkmark:after {
            top: 6px;
            left: 6px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: white;
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
                    href="#"
                    class="list-group-item list-group-item-action py-2 ripple active"
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
            <h2>Pridať používateľa</h2>
        </hgroup>
        <hr />
        <form method="POST" action="#" onsubmit="return validateForm()">
            <div class="form-outline mb-4">
                <input type="text" id="name" name="name" class="form-control">
                <label class="form-label" for="name">Meno</label>
            </div>
            <span id="nameError" class="error"></span>

            <div class="form-outline mb-4">
                <input type="text" id="surname" name="surname" class="form-control">
                <label class="form-label"  for="surname">Priezvisko</label>
            </div>
            <span id="surnameError" class="error"></span>

            <div class="form-outline mb-4">
                <input type="email" id="email" name="email" class="form-control">
                <label class="form-label"  for="email">Email</label>
            </div>
            <span id="emailError" class="error"></span>

            <div class="form-outline mb-4">
                <input type="password" id="password" name="password" class="form-control">
                <label class="form-label" for="password">Heslo</label>
            </div>
            <span id="passwordError" class="error"></span>

            <label class="custom-radio" for="roleStudent">Student
                <input type="radio" id="roleStudent" name="role" value="student" checked>
                <span class="checkmark"></span>
            </label>

            <label class="custom-radio" for="roleTeacher">Teacher
                <input type="radio" id="roleTeacher" name="role" value="teacher">
                <span class="checkmark"></span>
            </label>

            <br><br>
            <span id="roleError" class="error"></span>
            <div class="form-outline mb-4">
                <input type="submit" class="btn btn-primary" value="Pridať" style="width: 100%">
            </div>
        </form>
    </div>
</main>

<script>
    function validateForm() {

        document.getElementById('nameError').textContent = '';
        document.getElementById('surnameError').textContent = '';
        document.getElementById('emailError').textContent = '';
        document.getElementById('passwordError').textContent = '';
        document.getElementById('roleError').textContent = '';

        var name = document.getElementById('name').value;
        var surname = document.getElementById('surname').value;
        var email = document.getElementById('email').value;
        var password = document.getElementById('password').value;
        var roleError =  document.getElementById('roleError').value;
        var role =  document.getElementById('role').value;

        if (name === '') {
            document.getElementById('nameError').textContent = 'Meno je povinné';
            return false;
        }
        if (surname === '') {
            document.getElementById('surnameError').textContent = 'Priezvisko je povinné';
            return false;
        }

        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            document.getElementById('emailError').textContent = 'Nesprávny tvar emailu';
            return false;
        }
        if (password.length < 6) {
            document.getElementById('passwordError').textContent = 'Heslo musí mať najmenej 6 znakov';
            return false;
        }
        if (!role.checked){
            roleError.textContent = "Vyberte rolu";
            return false;
        }
        return true;
    }
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.js"></script>
</body>
</html>
