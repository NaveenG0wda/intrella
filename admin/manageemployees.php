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

    <title>Intrella - Manage Employees</title>

    <!-- css imports -->

    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.16.4/tagify.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.css" />

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
                <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="dashboard.php"><i class="fa-solid fa-gauge fa-lg mx-1"></i> Dashboard</a>
                <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="createuser.php"><i class="fa-sharp fa-solid fa-user-plus fa-lg mx-1"></i> Create User</a>
                <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="manageusers.php"><i class="fa-solid fa-user-pen fa-lg mx-1"></i> Manage Students</a>
                <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white active" href="manageemployees.php"><i class="fa-sharp fa-solid fa-user-tie fa-lg mx-1"></i> Manage Employees</a>
        <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="viewslots.php"><i class="fa-solid fa-check-to-slot fa-lg mx-1"></i> All Slots</a>
                <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket fa-lg mx-1"></i> Logout</a>
            </div>
        </div>

        <!-- Page content wrapper-->
        <div id="page-content-wrapper" class="d-flex flex-column">

            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-green shadow-none" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
                </div>
            </nav>

            <?php
            /* Checking if the session variable "exists" is set, if it is, it will display a toast message. */
            if (isset($_SESSION["exists"])) {
            ?>
                <div class="position-fixed top-0 toastae start-50 translate-middle-x p-3" style="z-index: 11">
                    <div id="liveToast" class="toast bg-danger bg-opacity-75 hide" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body ms-auto text-white">
                                User Already Exists !
                            </div>
                            <button type="button" class="btn-close shadow-none btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            <?php
            }
            unset($_SESSION["exists"]);
            ?>

            <?php
            /* Checking if the session variable "save" is set, if it is, it will display a toast message. */
            if (isset($_SESSION["save"])) {
            ?>
                <div class="position-fixed top-0 toastae start-50 translate-middle-x p-3" style="z-index: 11">
                    <div id="liveToast" class="toast bg-success bg-opacity-75 hide" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body ms-auto text-white">
                                Employee Deleted Successfully !
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
                            Employee Deletion Failed !
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
            <div class="container-fluid mx-auto mt-4-2-1 mb-3">
                <div class="row justify-content-center g-3">
                    <div class="col-md-10 lead text-start mb-3 text-green">
                        Manage Employees
                    </div>
                    <div class="col-md-10">

                         <!-- employee data table -->

                        <form action="deleteemployee.php" method="post" id="deleteemployeeform"></form>

                                    <!-- Creating a hidden input field csrf -->
                                      <?=$csrf->input('deleteemployeeform','deleteemployeeform');?>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="employeetable">
                                <thead class="gradient-custom-2 text-white">
                                    <tr class="align-middle text-center text-nowrap">
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Type</th>
                                        <th data-orderable="false">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "select * from tickets_2022_employees";

                                    $result = mysqli_query($link, $query);

                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>

                                        <tr class="align-middle text-center text-nowrap">
                                            <td><?= $row["name"] ?></td>
                                            <td><?= $row["email"] ?></td>
                                            <td><?= $row["type"] ?></td>
                                            <td>
                                                <div class="form-group">
                                                    <button class="btn btn-danger btn-sm delete text-white shadow-none" id="butdel" name="butdel" form="deleteemployeeform" value="<?= $row["id"] ?>">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.16.4/tagify.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.16.4/tagify.polyfills.min.js"></script>

    <!-- javascript imports -->

    <script>
        $(() => {


            /* Calling the DataTable() function. */
            $("#employeetable").DataTable({
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, 'All'],
                ],
            });

            /* Showing the toast message. */
            $('.toast').toast('show');

            /* Removing the red border from the input fields when the user starts typing. */
            $("input,textarea,select").on("keydown change", function() {
                $(this).removeClass("is-invalid")
            })

            /* Validating the form. */
            $("#deleteemployeeform").on("submit", (e) => {

                // debugger;

                var testemail = new RegExp("[a-z0-9]+@[a-z]+\.[a-z]{2,3}");
                var testphone = new RegExp("^[6-9][0-9]{9}$");

                var phone = $("#phone").val() != '' ? JSON.parse($("#phone").val()) : "";
                var email = $("#email").val();
                var title = $("#title").val();
                var password = $("#password").val();
                var pid = $("#pid").val();
                var course = $("#course").val();


                if (course != "") {
                    $("#course").removeClass("is-invalid");
                } else {
                    $("#course").addClass("is-invalid");
                    e.preventDefault();
                }

                if (pid != "") {
                    $("#pid").removeClass("is-invalid");
                } else {
                    $("#pid").addClass("is-invalid");
                    e.preventDefault();
                }

                if (title != "") {
                    $("#title").removeClass("is-invalid");
                } else {
                    $("#title").addClass("is-invalid");
                    e.preventDefault();
                }

                if (password != "") {
                    $("#password").removeClass("is-invalid");
                } else {
                    $("#password").addClass("is-invalid");
                    e.preventDefault();
                }

                if (email != "") {
                    if (!testemail.test(email)) {
                        $(".alertemail").text("* Enter Valid Email");
                        $("#email").addClass("is-invalid");
                        e.preventDefault();
                    } else {
                        $("#email").removeClass("is-invalid");
                    }
                } else {
                    $(".alertemail").text("* Enter Email");
                    $("#email").addClass("is-invalid");
                    e.preventDefault();
                }

                if (phone != '') {
                    for (let i = 0; i < phone.length; i++) {
                        if (phone[i].value != "") {
                            if (!testphone.test(phone[i].value)) {
                                $(".alertphone").text("* Enter Valid Phone");
                                $("#phone").addClass("is-invalid");
                                e.preventDefault();
                            } else {
                                $("#phone").removeClass("is-invalid");
                            }
                        }
                    }
                } else {
                    $(".alertphone").text("* Enter Phone No");
                    $("#phone").addClass("is-invalid");
                    e.preventDefault();
                }


            })

        })
    </script>


</body>

</html>