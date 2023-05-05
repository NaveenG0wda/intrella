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

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Intrella - All Slots</title>

  <!-- css imports -->

  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.css" />
  <link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />

  <!-- css imports -->

  <style>
    .form-control {
      box-shadow: none !important;
    }

    .form-select {
      box-shadow: none !important;
    }

    .pagination .page-link {
      border: none !important;
    }

    .page-link.active,
    .active>.page-link {
      background-color: #8cc53d !important;
      color: white !important;
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
        <a class="list-group-item list-group-item-white list-group-item-action  p-3 gradient-custom-2 shadow-none border-white" href="dashboard.php"><i class="fa-solid fa-gauge fa-lg mx-1"></i> Dashboard</a>
        <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="createuser.php"><i class="fa-sharp fa-solid fa-user-plus fa-lg mx-1"></i> Create User</a>
        <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="manageusers.php"><i class="fa-solid fa-user-pen fa-lg mx-1"></i> Manage Students</a>
        <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="manageemployees.php"><i class="fa-sharp fa-solid fa-user-tie fa-lg mx-1"></i> Manage Employees</a>
        <a class="list-group-item list-group-item-white active list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="viewslots.php"><i class="fa-solid fa-check-to-slot fa-lg mx-1"></i> All Slots</a>
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



      <?php
      /* Checking if the session variable "save" is set, if it is, it will display a toast message. */
      if (isset($_SESSION["save"])) {
      ?>
        <div class="position-fixed top-0 toastae start-50 translate-middle-x p-3" style="z-index: 11">
          <div id="liveToast" class="toast bg-success bg-opacity-75 hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
              <div class="toast-body ms-auto text-white">
                Slot Deleted Successfully !
              </div>
              <button type="button" class="btn-close shadow-none btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
          </div>
        </div>
      <?php
      }
      unset($_SESSION["save"]);
      ?>

      <?php
      /* Checking if the session variable "fail" is set, if it is, it will display a toast message. */
      if (isset($_SESSION["fail"])) {
      ?>
        <div class="position-fixed top-0 toastae start-50 translate-middle-x p-3" style="z-index: 11">
          <div id="liveToast" class="toast bg-danger bg-opacity-75 hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
              <div class="toast-body ms-auto text-white">
                Delete Failed !
              </div>
              <button type="button" class="btn-close shadow-none btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
          </div>
        </div>
      <?php
      }
      unset($_SESSION["fail"]);
      ?>



      <!-- Page content-->
      <div class="container-fluid mx-auto mt-4-2-1 mb-4">


        <div class="row justify-content-center g-3">
          <div class="col-md-10 lead text-start mb-3 text-green">
            All Slots
          </div>
          <div class="col-md-10">


            <form action="deleteslot.php" method="post" id="deleteslotform"></form>

            <!-- Creating a hidden input field csrf -->
            <?= $csrf->input('deleteslotform', 'deleteslotform'); ?>


            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="slotstable">
                <thead class="gradient-custom-2 text-white">
                  <tr class="align-middle text-center text-nowrap">
                    <th>Time</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Employee</th>
                    <th>User</th>
                    <th>Location</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Format</th>
                    <th>Contact</th>
                    <th>User Status</th>
                    <th>Employee Status</th>
                    <th>User Comments</th>
                    <th>Employee Comments</th>
                    <th data-orderable="false">Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = "select * from tickets_2022_slots";

                  $result = mysqli_query($link, $query);

                  while ($row = mysqli_fetch_array($result)) {
                  ?>

                    <tr class="align-middle text-center text-nowrap">
                      <td><?= $row["starttime"] ?> - <?= $row["endtime"] ?> </td>
                      <td><?= $row["date"] ?></td>
                      <td><?= $row["type"] ?></td>
                      <td><?= $row["employeename"] ?></td>
                      <td><?= $row["user"] ?></td>
                      <td><?= $row["location"] ?></td>
                      <td><?= $row["title"] ?></td>
                      <td><?= $row["description"] ?></td>
                      <td><?= $row["reportformat"] ?></td>
                      <td><?= $row["contact"] ?></td>
                      <td><?= $row["userstatus"] ?></td>
                      <td><?= $row["employeestatus"] ?></td>
                      <td><?= $row["usercomment"] ?></td>
                      <td><?= $row["employeecomment"] ?></td>
                      <td>
                        <div class="form-group">
                          <button class="btn btn-danger btn-sm delete text-white shadow-none" id="deleteslot" name="deleteslot" form="deleteslotform" value="<?= $row["id"] ?>">
                            <i class="fa fa-trash"></i>
                          </button>
                        </div>
                      </td>
                    </tr>

                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- javascript imports -->

  <script src="../js/jquery.js"></script>
  <script src="../js/bootstrap.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js"></script>

  <!-- javascript imports -->

  <script>
    $(function() {
      /* Calling the DataTable() function. */
      $("#slotstable").DataTable({
        lengthMenu: [
          [5, 10, 25, 50, -1],
          [5, 10, 25, 50, 'All'],
        ],
      });

      /* Showing the toast message. */
      $('.toast').toast('show');

    })
  </script>

</body>

</html>