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

    <title>Intrella - Profile</title>

    <!-- css imports -->

    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/timepicker.css">
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
                <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="dashboard.php"><i class="fa-solid fa-gauge fa-lg mx-1"></i> Dashboard</a>
                <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="bookslot.php"><i class="fa-regular fa-calendar-plus fa-lg mx-1"></i> Book Slot</a>
                <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="myslots.php"><i class="fa-solid fa-business-time fa-lg mx-1"></i> My Slots</a>
                <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="viewslots.php"><i class="fa-solid fa-check-to-slot fa-lg mx-1"></i> All Slots</a>
                <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none active border-white" href="profile.php"><i class="fa-solid fa-address-card fa-lg mx-1"></i> Profile</a>
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

            <?php
            /* Checking if the session variable "exists" is set, if it is, it will display a toast message. */
            if (isset($_SESSION["exists"])) {
            ?>
                <div class="position-fixed top-0 toastae start-50 translate-middle-x p-3" style="z-index: 11">
                    <div id="liveToast" class="toast bg-danger bg-opacity-75 hide" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body ms-auto text-white">
                                Slot Already Exists !
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
                                Password Changed Successfully !
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
                            Change Failed !
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
            <div class="container-fluid">
                <div class="row mt-4-2 mb-4 justify-content-center">
                    <div class="col-md-10">
                        <div class="card shadow-none border-green">
                            <div class="card-header py-2 gradient-custom-2">
                                <div class="row justify-content-evenly g-3">
                                    <div class="col-md-5 lead  text-white">
                                        <i class="fa-solid fa-address-card mx-1"></i> Profile
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                <!-- save slot form -->

                                <form action="saveprofile.php" method="post" id="saveprofileform" enctype="multipart/form-data">

                                    <!-- Creating a hidden input field csrf -->
                                    <?= $csrf->input('saveprofileform'); ?>

                                    <div class="row justify-content-evenly my-3 g-3">

                                        <?php

                                        $query = "select * from tickets_2022_users where email = '" . $_SESSION["user"] . "'";
                                        $result = mysqli_query($link, $query);
                                        $row = mysqli_fetch_array($result)
                                        ?>


                                        <div class="col-md-5 position-relative">
                                            <div class="text-center">
                                                <img src="../images/user.png" width="100" alt="logo">
                                            </div>
                                            <div class="row justify-content-center">

                                                <div class="col-auto fs-6">

                                                    <div class="text-green mt-4 mb-2 border-bottom">
                                                        <i class="fa-solid fa-id-card-clip"></i>
                                                        <?= $row["email"] ?>
                                                    </div>

                                                    <div class="text-green mb-2 border-bottom">
                                                        <i class="fa-regular fa-id-badge"></i>
                                                        <?= $row["pid"] ?>
                                                    </div>

                                                    <div class="text-green mb-2 border-bottom">
                                                        <i class="fa-solid fa-diagram-project"></i>
                                                        <?= $row["title"] ?>
                                                    </div>

                                                    <div class="text-green mb-2 border-bottom">
                                                        <i class="fa-solid fa-graduation-cap"></i>
                                                        <?= $row["course"] ?>
                                                    </div>

                                                    <div class="text-green mb-2 border-bottom">
                                                        <i class="fa-solid fa-phone"></i>
                                                        <?= $row["phone"] ?>
                                                    </div>

                                                </div>
                                            </div>


                                        </div>

                                        <div class="col text-center">
                                            <div class="vr h-100"></div>
                                        </div>

                                        <div class="col-md-5">

                                            <div class="position-relative">
                                                <h4 class="mt-2 text-green text-center text-md-start mb-4-2 text-decoration-underline tug-1" id="titlep">
                                                    Change Password
                                                </h4>
                                                    <div class="invalid-tooltip rounded-3">
                                                        * Passwords Do Not Match
                                                    </div>
                                            </div>

                                            <div class="position-relative">
                                                <label for="new">New Password:</label>
                                                <input type="password" name="new" id="new" class="form-control shadow-none mb-3" placeholder="New Password">
                                                <div class="invalid-tooltip rounded-3">
                                                    * Enter New Password
                                                </div>
                                            </div>

                                            <div class="position-relative">
                                                <label for="confirm">Confirm Password:</label>
                                                <input type="password" name="confirm" id="confirm" class="form-control shadow-none mb-4-2" placeholder="Confirm Password">
                                                <div class="invalid-tooltip rounded-3">
                                                    * Enter Confirm Password
                                                </div>
                                            </div>

                                            <div class="d-flex gap-3">
                                                <button type="reset" class="btn btn-outline-danger shadow-none w-100" id="resetbut">Reset</button>
                                                <button type="submit" name="saveprofile" value="<?=$row["id"]?>" class="btn btn-outline-green shadow-none w-100">Submit</button>
                                            </div>
                                        </div>

                                    </div>
                                </form>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>
    <script src="../js/timepicker.js"></script>

    <!-- javascript imports -->

    <script>
        $(function() {


            /* Showing the toast message. */
            $('.toast').toast('show');

            /* Validating the form. */
            $("#saveprofileform").on("submit", function(e) {

                debugger;

                var testemail = new RegExp("[a-z0-9]+@[a-z]+\.[a-z]{2,3}");
                var testphone = new RegExp("^[6-9][0-9]{9}$");

                var newp = $("#new").val();
                var confirmp = $("#confirm").val();



                if (confirmp != "") {
                    $("#confirm").removeClass("is-invalid");
                } else {
                    $("#confirm").addClass("is-invalid");
                    e.preventDefault();
                }


                if (newp != "") {
                    $("#new").removeClass("is-invalid");
                } else {
                    $("#new").addClass("is-invalid");
                    e.preventDefault();
                }


                if (newp == confirmp) {
                    $("#titlep").removeClass("is-invalid");
                } else {
                    $("#titlep").addClass("is-invalid");
                    e.preventDefault();
                }


            })

            $("#resetbut").on("click", function() {

                $("input,textarea,select").removeClass("is-invalid")
                $("textarea").css("height", "auto");
                    $("#titlep").removeClass("is-invalid");

            })



            $("input,textarea,select").on("keydown change", function() {

                $(this).removeClass("is-invalid")
                    $("#titlep").removeClass("is-invalid");

            })


        })
    </script>


</body>

</html>