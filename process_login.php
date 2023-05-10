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
            echo '<script>alert("Invalid email format"); window.location.href = "index.php";</script>';
            exit();
        }

        if (strlen($password) < 4) {
            echo '<script>alert("Password must be at least 8 characters long"); window.location.href = "index.php";</script>';
            exit();
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        // Check if the query returns any rows
        if ($stmt->rowCount() > 0) {
            // Login successful
            $_SESSION['email'] = $email;

            $stmt = $conn->prepare("SELECT role FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $role = $row['role'];
            $_SESSION['role'] = $role;

            if ($_SESSION['role'] === "teacher") {
                header("Location: homeT.php");
            } elseif ($_SESSION['role'] === "student") {
                header("Location: homeS.php");
            } else {
                // Invalid role
                echo '<script>alert("Invalid user role"); window.location.href = "index.php";</script>';
                exit();
            }
        } else {
            // Login failed
            echo '<script>alert("Invalid email or password"); window.location.href = "index.php";</script>';
            exit();
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit();
    }
} else {
    // Redirect to login page
    header("Location: index.php");
    exit();
}
?>
