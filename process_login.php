<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $email = $_POST['email'];
        $password = $_POST['password'];

        // Validate email and password
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo '<script>alert("Zlý formát emailu"); window.location.href = "./";</script>';
            exit();
        }


        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $storedHashedPassword = $row['password'];
            if (password_verify($password, $storedHashedPassword)) {
                // Passwords match
                $_SESSION['email'] = $email;
                $role = $row['role'];
                $id = $row['id'];
                $_SESSION['role'] = $role;
                $_SESSION['id'] = $id;

                if ($role === "teacher") {
                    header("Location: homeT.php");
                } elseif ($role === "student") {
                    header("Location: homeS.php");
                } else {
                    // Invalid role
                    echo '<script>alert("Zlá rola používateľa"); window.location.href = "./";</script>';
                    exit();
                }
            } else {
                // Login failed
                echo '<script>alert("Nesprávny email alebo heslo"); window.location.href = "./";</script>';
                exit();
            }
        } else {
            // User not found
            echo '<script>alert("Používateľ nenájdený"); window.location.href = "./";</script>';
            exit();
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit();
    }
}
?>
