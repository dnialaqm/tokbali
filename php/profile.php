<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['fname'])) {

include "db_conn.php";
include 'user.php';
$user = getUserById($_SESSION['id'], $conn);


 ?>
 <!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>   
        <link href="style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <title>Assignment 1 - Case Study</title>
     
    </head>
    <body>
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <div class="container-fluid d-flex justify-content-evenly">
              <ul class="navbar-nav">
                <a href="index.html"><img src="../logo.png" width="90px;"></a>
              </ul>
            </div>
        </nav>

            <?php if ($user) { ?>
            <div class="d-flex justify-content-center align-items-center vh-100">
              <div class="shadow w-350 p-3 text-center"> 
                <img src="upload/<?=$_SESSION['pp']?>" class="img-fluid rounded-circle">
                    <h3 class="display-4 "><?=$user['fname']?></h3>
                    <a href="edit.php" class="btn btn-primary">
                      Edit Profile
                    </a>
                     <a href="logout.php" class="btn btn-warning">
                        Logout
                    </a>
              </div>
            </div>
            <?php }else { 
             header("Location: login.php");
             exit;
            } ?>
    </body>
</html>
        
        <?php }else {
          header("Location: login.php");
          exit;
        } ?>