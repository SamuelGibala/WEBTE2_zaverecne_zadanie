<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('language.php');

switch_lang();

if (isset($_SESSION['email'])){
    if ($_SESSION['role'] === "teacher") {
        header("Location: homeT.php");
    } elseif ($_SESSION['role'] === "student") {
        header("Location: homeS.php");
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css" rel="stylesheet"/>
      <style>
          html, body {
              height: 100%;
              margin: 0;
          }

          .container {
              position: absolute;
              top: 50%;
              left: 50%;
              transform: translate(-50%, -50%);
          }
          .row {
              position: relative;
              display: flex;
              justify-content: center;
          }

          .col-md-4 {
              max-width: 300px; /* Optional: Set a max width for the column */
          }
      </style>
</head>
<body>
    <div class="position-relative">
        <div class="position-absolute top-0" style="right: 30px">
            <ul class="navbar-nav d-flex flex-row">
                <?php get_menu_dropdown() ?>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <hgroup>
                    <h1><?php echo get_localized('login_header') ?></h1>
                </hgroup>
                <form method="post" action="process_login.php">
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input type="email" id="email" name="email" class="form-control" required />
                        <label class="form-label" for="email">Email</label>
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <input type="password" id="password" name="password" class="form-control" required />
                        <label class="form-label" for="password"><?php echo get_localized('form_pass') ?></label>
                    </div>
                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-block mb-4"><?php echo get_localized('login_btn') ?></button>
                </form>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.js"></script>
</body>
</html>
