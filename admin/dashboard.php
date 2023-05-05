<?php

/* Including the csrf,database files. */
require '../config/php-csrf.php';
require "../config/database.php";

/* Starting a session and requiring the database.php file. */
session_start();

/* Checking if the admin is logged in. If the admin is logged in, it will redirect the admin to the dashboard. */
if (!isset($_SESSION["admin"])) {
  echo "<script> location.replace('index.php') </script>";
}

/* Creating a new instance of the CSRF class. */
$csrf = new CSRF();


$users_count = "select count(*) as userscount from tickets_2022_users";

$users_count = mysqli_query($link, $users_count);

$users_count = mysqli_fetch_array($users_count);



$employees_count = "select count(*) as employeescount from tickets_2022_employees";

$employees_count = mysqli_query($link, $employees_count);

$employees_count = mysqli_fetch_array($employees_count);


$slots_count = "select count(*) as slotscount from tickets_2022_slots";

$slots_count = mysqli_query($link, $slots_count);

$slots_count = mysqli_fetch_array($slots_count)
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
        <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="createuser.php"><i class="fa-sharp fa-solid fa-user-plus fa-lg mx-1"></i> Create User</a>
        <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="manageusers.php"><i class="fa-solid fa-user-pen fa-lg mx-1"></i> Manage Students</a>
        <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="manageemployees.php"><i class="fa-sharp fa-solid fa-user-tie fa-lg mx-1"></i> Manage Employees</a>
        <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="viewslots.php"><i class="fa-solid fa-check-to-slot fa-lg mx-1"></i> All Slots</a>
        <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket fa-lg mx-1"></i> Logout</a>
      </div>
    </div>

    <!-- Page content wrapper-->
    <div id="page-content-wrapper">

      <!-- Top navigation-->
      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container-fluid">
          <button class="btn btn-green shadow-none" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
          <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button> -->
          <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item active"><a class="nav-link" href="#!">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="#!">Link</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#!">Action</a>
                                    <a class="dropdown-item" href="#!">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#!">Something else here</a>
                                </div>
                            </li>
                        </ul>
                    </div> -->
        </div>
      </nav>

      <!-- Page content-->
      <div class="container-fluid">
        <h2 class="my-4 text-green text-decoration-underline tug-2">Dashboard</h2>
        <div class="row">

          <div class="col-md-3 md-mb-0 mb-2">
            <div class="card shadow border-0 text-white gradient-custom-2" id="cardone">
              <div class="card-body rounded-3">
                <h5 class="card-title mb-4 text-decoration-underline tug-2">Students</h5>
                <div class="row">
                  <div class="col">
                    <i class="fa-solid fa-users fs-2"></i>
                  </div>
                  <div class="col text-md-end">
                    <span class="fs-4">
                      <?= $users_count["userscount"] ?>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-3 md-mb-0 mb-2">
            <div class="card shadow border-0 text-white gradient-custom-2" id="cardtwo">
              <div class="card-body rounded-3">
                <h5 class="card-title mb-4 text-decoration-underline tug-2">Employees</h5>
                <div class="row">
                  <div class="col">
                  <i class="fa-solid fa-people-group fs-2"></i>
                  </div>
                  <div class="col text-md-end">
                    <span class="fs-4">
                      <?= $employees_count["employeescount"] ?>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-3 md-mb-0 mb-2">
            <div class="card shadow border-0 text-white gradient-custom-2" id="cardthree">
              <div class="card-body rounded-3">
                <h5 class="card-title mb-4 text-decoration-underline tug-2">Slots</h5>
                <div class="row">
                  <div class="col">
                  <i class="fa-solid fa-calendar-days fs-2"></i>
                  </div>
                  <div class="col text-md-end">
                    <span class="fs-4">
                      <?= $slots_count["slotscount"] ?>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>

  <!-- javascript imports -->

  <script src="../js/jquery.js"></script>
  <script src="../js/bootstrap.js"></script>

  <!-- javascript imports -->

</body>

</html>