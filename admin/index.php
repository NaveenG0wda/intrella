<?php

/* Including the php-csrf.php file. */
require '../config/php-csrf.php';

/* Including the database.php file. */
require "../config/database.php";

/* Starting a session and requiring the database.php file. */
session_start();

/* Checking if the admin is logged in. If the admin is logged in, it will redirect the admin to the dashboard. */
if (isset($_SESSION["admin"])) {
    echo "<script> location.replace('dashboard.php') </script>";
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

    <title>Intrella - Admin Login</title>

    <!-- css imports -->

    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.css" />

    <!-- css imports -->

</head>

<body>

    <div class="min-vh-100 d-flex flex-column bg-cover">

        <?php
        /* Checking if the session variable "fail" is set. If it is set, it will display a toast message. */
        if (isset($_SESSION["fail"])) {
        ?>

            <div class="position-fixed top-0 toastae start-50 translate-middle-x p-3" style="z-index: 11">
                <div id="liveToast" class="toast bg-danger bg-opacity-75 hide" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body ms-auto text-white">
                            Login Failed !
                        </div>
                        <button type="button" class="btn-close shadow-none btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>

        <?php
        }
        unset($_SESSION["fail"]);
        ?>


        <div class="container py-5 my-auto">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-md-12">
                    <div class="card rounded text-black border-0 shadow-sm">

                        <div class="row g-0">

                            <!-- left column -->

                            <div class="col-md-6">
                                <div class="card-body p-md-5 py-4 mx-md-4 mx-2">

                                    <div class="text-center">
                                        <img src="../images/user.png" width="80" alt="logo">
                                        <h4 class="mt-4 mb-4-2 text-decoration-underline tug-1">Admin Login</h4>
                                    </div>

                                    <!-- login form -->

                                    <form method="post" action="auth.php" id="adminloginform">

                                        <!-- Creating a hidden input field csrf -->
                                        <?= $csrf->input('adminloginform'); ?>

                                        <div class="input-group mb-4 position-relative">
                                            <span class="input-group-text" id="basic-email"><i class="fa-solid fa-user"></i></span>
                                            <input type="text" name="email" id="email" class="form-control shadow-none" placeholder="Email" aria-label="Email" aria-describedby="basic-email">
                                            <div class="invalid-tooltip rounded-3 alertemail">
                                                * Enter Valid Email
                                            </div>
                                        </div>

                                        <div class="input-group mb-4-2 position-relative">
                                            <span class="input-group-text" id="basic-password"><i class="fa-solid fa-key"></i></span>
                                            <input type="password" name="password" id="password" class="form-control shadow-none" placeholder="Password" aria-label="Password" aria-describedby="basic-password">
                                            <div class="invalid-tooltip rounded-3 ">
                                                * Enter Password
                                            </div>
                                        </div>

                                        <div class="text-center pt-1 pb-1">
                                            <button class="btn btn-outline-green w-100 shadow-none" type="submit">Log
                                                in</button>
                                        </div>

                                        <div class="text-center pt-4">
                                            <a href="../index.php" class="text-decoration-none"><i class="fa-solid fa-circle-arrow-left fa-lg text-green"></i> <span class=" text-green">Back</span></a>
                                        </div>

                                    </form>


                                </div>
                            </div>



                            <!-- right column -->

                            <div class="col-md-6 d-none d-md-flex align-items-center gradient-custom-2 rounded-end justify-content-center">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    <div class="text-center">
                                        <img src="../images/image.png" width="180" alt="logo">
                                    </div>
                                    <!-- <p class="mt-3 fs-5 text-center text-decoration-underline tug-1">Skilled Engineers Fully At Your Service</p> -->
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

<script>
    $(function() {

        /* Showing the toast message. */
        $('.toast').toast('show');


        /* This is a jQuery function. It is used to validate the form. */
        $("#adminloginform").on("submit", function(e) {
            debugger;

            var email = $("#email").val()
            var password = $("#password").val()
            var testemail = new RegExp("[a-z0-9]+@[a-z]+\.[a-z]{2,3}");
            var testphone = new RegExp("^[6-9][0-9]{9}$");

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

            if (password != "") {
                $("#password").removeClass("is-invalid");
            } else {
                $("#password").addClass("is-invalid");
                e.preventDefault();
            }

        })

        /* Removing the red border from the input fields when the user starts typing. */
        $("input,textarea,select").on("keydown change", function() {
            $(this).removeClass("is-invalid")
        })

    })
</script>

</html>