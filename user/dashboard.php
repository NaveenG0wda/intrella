<?php

/* Including the csrf,database files. */
require '../config/php-csrf.php';
require "../config/database.php";

/* Starting a session and requiring the database.php file. */
session_start();

/* Checking if the admin is logged in. If the admin is logged in, it will redirect the admin to the dashboard. */
if (!isset($_SESSION["user"])) {
    echo "<script> location.replace('index.php') </script>";
}

/* Creating a new instance of the CSRF class. */
$csrf = new CSRF();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Intrella - Dashboard</title>

    <!-- css imports -->

    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.css" />

    <!-- css imports -->

    <style>
        .toastui-calendar-section-button {
         display: none !important;
        }
    </style>

</head>

<body>

    <div class="d-flex" id="wrapper">

        <!-- Sidebar-->
        <div class="border-end gradient-custom-2" id="sidebar-wrapper">
            <div class="sidebar-heading text-wrap border-bottom border-white gradient-custom-2">
                <img src="../images/image.png" width="125" alt="logo">
            </div>
            <div class="list-group text-break list-group-flush shadow-none">
                <a class="list-group-item list-group-item-white list-group-item-action active p-3 gradient-custom-2 shadow-none border-white" href="dashboard.php"><i class="fa-solid fa-gauge fa-lg mx-1"></i> Dashboard</a>
                <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="bookslot.php"><i class="fa-regular fa-calendar-plus fa-lg mx-1"></i> Book Slot</a>
                <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="myslots.php"><i class="fa-solid fa-business-time fa-lg mx-1"></i> My Slots</a>
                <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="viewslots.php"><i class="fa-solid fa-check-to-slot fa-lg mx-1"></i> All Slots</a>
                <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="profile.php"><i class="fa-solid fa-address-card fa-lg mx-1"></i> Profile</a>
                <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket fa-lg mx-1"></i> Logout</a>
            </div>
        </div>

        <!-- Page content wrapper-->
        <div id="page-content-wrapper">

            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-green shadow-none" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>

                </div>
            </nav>

            <!-- Page content-->
            <div class="container-fluid"> 

            <p class="text-start my-3 fs-3 text-green text-decoration-underline tug-2">Today</p>
              <div class="row mb-3 g-4">

              <?php
               $query = "select * from tickets_2022_slots where date = '".date("Y-m-d")."'";
            //    $query = "select * from tickets_2022_slots where date = '2022-09-22'";
               $result = mysqli_query($link,$query);
               while($row = mysqli_fetch_array($result))
               {
                if (!($row["date"] == date("Y-m-d") && $row["starttime"] < date("H:i:s"))) 
                {
              ?>

                <div class="col-md-4">
                   <div class="card border-green shadow-none">
                    <div class="card-header gradient-custom-2 py-2">
                      <div class="today text-capitalize fs-5 text-white">
                      <i class="fa-solid fa-diagram-project"></i>
                       <?=$row["title"]?>
                      </div>
                    </div>
                      <div class="card-body">
                       <div class="text-start mb-1 fs-6 text-green">
                        <i class="fa-solid fa-clock"></i> 
                        <?=$row["starttime"]?> - <?=$row["endtime"]?>
                       </div>
                       <div class="text-start mb-1 text-capitalize fs-6 text-green">
                       <i class="fa-solid fa-user-tie"></i>
                        <?=$row["employeename"]?>
                       </div>
                       <div class="text-start mb-1 text-capitalize fs-6 text-green">
                       <i class="fa-solid fa-laptop-file"></i>
                        <?=$row["type"]?>
                       </div>
                      </div>
                      <!-- <div class="card-footer gradient-custom-2 text-white py-2 text-capitalize ">
                      <i class="fa-solid fa-bars-staggered"></i>
                      <?=$row["employeestatus"]?>
                      </div> -->
                   </div>
                </div>

              <?php
                }
               }
              ?>

              </div>

            </div>
        </div>
    </div>

    <!-- javascript imports -->

    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>

    <!-- javascript imports -->

    <script>
        $(function(){
            
        })
    </script>


</body>

</html>