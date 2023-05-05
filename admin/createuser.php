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

/* Getting the max pid from the table and exploding it. */
$query = "select MAX(pid) as pid from tickets_2022_users";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_array($result);
if ($row["pid"] != '') {
    $pid = explode('_', $row["pid"]);
} else {
    $pid[0] = 'Proj';
    $pid[1] = date("Y");
    $pid[2] = 0;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Intrella - Create User</title>

    <!-- css imports -->

    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.16.4/tagify.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.css" />

    <!-- css imports -->

    <style>
        .tags-look .tagify__dropdown__item{
  display: inline-block;
  vertical-align: middle;
  border-radius: 3px;
  padding: .3em .5em;
  border: 1px solid #CCC;
  background: #F3F3F3;
  margin: .2em;
  font-size: .85em;
  color: black;
  transition: 0s;
}

.tags-look .tagify__dropdown__item--active{
  color: black;
}

.tags-look .tagify__dropdown__item:hover{
  background: lightyellow;
  border-color: gold;
}

.tags-look .tagify__dropdown__item--hidden {
    max-width: 0;
    max-height: initial;
    padding: .3em 0;
    margin: .2em 0;
    white-space: nowrap;
    text-indent: -20px;
    border: 0;
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
                <a class="list-group-item list-group-item-white list-group-item-action p-3 active gradient-custom-2 shadow-none border-white" href="createuser.php"><i class="fa-sharp fa-solid fa-user-plus fa-lg mx-1"></i> Create User</a>
                <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="manageusers.php"><i class="fa-solid fa-user-pen fa-lg mx-1"></i> Manage Students</a>
                <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="manageemployees.php"><i class="fa-sharp fa-solid fa-user-tie fa-lg mx-1"></i> Manage Employees</a>
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
                                User Created Successfully !
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
                                User Creation Failed !
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
            <div class="container-fluid my-auto">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card shadow-none border-green">
                            <div class="card-header py-2 gradient-custom-2">
                                <div class="row justify-content-evenly g-3">
                                    <div class="col-md-5 d-flex align-items-center lead justify-content-md-start text-white">
                                    <i class="fa-solid fa-user-plus me-2"></i>
                                        Create User
                                    </div>
                                    <div class="col-md-6 text-white d-flex gap-2 align-items-center">
                                        <label for="role">Role:</label>
                                        <select name="role" id="role" class="form-select  shadow-none" form="saveuserform">
                                            <option value="employee">Employee</option>
                                            <option value="student">Student</option>
                                        </select>
                                        <div class="invalid-tooltip rounded-3">
                                            * Select Role
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                <!-- save user form -->

                                <form action="saveuser.php" method="post" id="saveuserform">

                                    <!-- Creating a hidden input field csrf -->
                                    <?= $csrf->input('saveuserform'); ?>

                                    <div class="row justify-content-evenly my-3 g-3">
                                        <div class="col-md-5 position-relative studetails">
                                            <label for="title">Project Title:</label>
                                            <input type="text" name="title" id="title" class="form-control shadow-none" placeholder="Project Title">
                                            <div class="invalid-tooltip rounded-3">
                                                * Enter Project Title
                                            </div>
                                        </div>
                                        <div class="col-md-5 position-relative studetails">
                                            <label for="pid">Project Id:</label>
                                            <input type="text" name="pid" id="pid" class="form-control shadow-none" placeholder="Project Id" value="<?= $pid[0] . "_" . date("Y") . "_" . ($pid[2] + 1) ?>">
                                            <div class="invalid-tooltip rounded-3">
                                                * Enter Project Id
                                            </div>
                                        </div>
                                        <div class="col-md-5 position-relative studetails">
                                            <label for="course">Course:</label>
                                            <select name="course" id="course" class="form-select shadow-none">
                                                <option value="">Select Course</option>
                                                <option value="msc">M.Sc.</option>
                                                <option value="bsc">B.Sc.</option>
                                                <option value="mca">MCA</option>
                                                <option value="bca">BCA</option>
                                                <option value="mba">MBA</option>
                                                <option value="ma">M.A</option>
                                                <option value="ba">B.A</option>
                                                <option value="btech">B.Tech</option>
                                                <option value="mtech">M.Tech</option>
                                                <option value="be">B.E</option>
                                                <option value="me">M.E</option>
                                                <option value="bba">BBA</option>
                                                <option value="mcom">M.Com</option>
                                                <option value="bed">B.Ed</option>
                                                <option value="llm">LL.M.</option>
                                                <option value="others">Others</option>
                                            </select>
                                            <div class="invalid-tooltip rounded-3">
                                                * Select Course
                                            </div>
                                        </div>
                                        <div class="col-md-5 position-relative empdetails" style="display: none;">
                                            <label for="name">Name:</label>
                                            <input type="text" name="name" id="name" class="form-control shadow-none" placeholder="Name">
                                            <div class="invalid-tooltip rounded-3">
                                                * Enter Name
                                            </div>
                                        </div>
                                        <div class="col-md-5 position-relative empdetails" style="display: none;">
                                            <label for="name">Type:</label>
                                            <input type="text" name="type" id="type" class="form-control shadow-none" >
                                            <!-- <select name="type" id="type" class="form-select  shadow-none">
                                                <option value="development">Development</option>
                                                <option value="report">Report</option>
                                                <option value="configuration">Configuration</option>
                                            </select> -->
                                            <div class="invalid-tooltip rounded-3">
                                                * Select Type
                                            </div>
                                        </div>
                                        <div class="col-md-5 position-relative studetails">
                                            <label for="phone">Phone:</label>
                                            <input type="text" name="phone" id="phone" class="form-control shadow-none" placeholder="Phone No">
                                            <div class="invalid-tooltip rounded-3 alertphone">
                                                * Enter Valid Phone No
                                            </div>
                                        </div>
                                        <div class="col-md-5 position-relative">
                                            <label for="email">Email:</label>
                                            <input type="text" name="email" id="email" class="form-control shadow-none" placeholder="Email">
                                            <div class="invalid-tooltip rounded-3 alertemail">
                                                * Enter Valid Email
                                            </div>
                                        </div>
                                        <div class="col-md-5 position-relative">
                                            <label for="password">Password:</label>
                                            <input type="password" name="password" id="password" class="form-control shadow-none" placeholder="Password">
                                            <div class="invalid-tooltip rounded-3">
                                                * Enter Password
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <button type="reset" class="btn btn-outline-danger shadow-none w-100 mt-4" id="resetbut">Reset</button>
                                        </div>
                                        <div class="col-md-5">
                                            <button type="submit" class="btn btn-outline-green shadow-none w-100 mt-4">Submit</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.16.4/tagify.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.16.4/tagify.polyfills.min.js"></script>

    <!-- javascript imports -->

    <script>
        $(() => {

            /* Hiding the student details and showing the employee details if the
            role is employee. */
            $("#role").on("change", (e) => {

                var role = $(e.currentTarget).val();

                if (role == "employee") {
                    $(".studetails").hide();
                    $(".empdetails").show();
                } else {
                    $(".studetails").show();
                    $(".empdetails").hide();
                }

            })

            /* Hiding the student details if the role is employee. */
            var role = $("#role").val();

            if (role == "employee") {
                $(".studetails").hide();
                $(".empdetails").show();
            } else {
                $(".studetails").show();
                $(".empdetails").hide();
            }

            /* Showing the toast message. */
            $('.toast').toast('show');

            /* Removing the red border from the input fields when the user starts typing. */
            $("input,textarea,select").on("keydown change", function() {
                $(this).removeClass("is-invalid")
            })

            /* Validating the form. */
            $("#saveuserform").on("submit", (e) => {

                debugger;

                var testemail = new RegExp("[a-z0-9]+@[a-z]+\.[a-z]{2,3}");
                var testphone = new RegExp("^[6-9][0-9]{9}$");

                var phone = $("#phone").val() != '' ? JSON.parse($("#phone").val()) : "";
                var email = $("#email").val();
                var title = $("#title").val();
                var password = $("#password").val();
                var pid = $("#pid").val();
                var course = $("#course").val();
                var name = $("#name").val();
                var role = $("#role").val();
                var type = $("#type").val();


                if (role != 'student') {
                    if (name != "") {
                        $("#name").removeClass("is-invalid");
                    } else {
                        $("#name").addClass("is-invalid");
                        e.preventDefault();
                    }
                }


                if (role != 'employee') {
                    if (course != "") {
                        $("#course").removeClass("is-invalid");
                    } else {
                        $("#course").addClass("is-invalid");
                        e.preventDefault();
                    }
                }


                if (role != 'employee') {
                    if (pid != "") {
                        $("#pid").removeClass("is-invalid");
                    } else {
                        $("#pid").addClass("is-invalid");
                        e.preventDefault();
                    }
                }


                if (role != 'employee') {
                    if (title != "") {
                        $("#title").removeClass("is-invalid");
                    } else {
                        $("#title").addClass("is-invalid");
                        e.preventDefault();
                    }
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


                if (role != 'employee') {
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
                }


            })

        })
    </script>

    <script>
        // The DOM element you wish to replace with Tagify
        var input = document.querySelector('input[name=phone]');

        // initialize Tagify on the above input node reference
        var tagify = new Tagify(input, {
            pattern: /^[6-9][0-9]{9}$/,
        })

        /* Removing all the tags when the reset button is clicked. */
        document.querySelector('#resetbut').addEventListener('click', () => {
            tagify.removeAllTags.bind(tagify)
            $("input,textarea,select").removeClass("is-invalid")
        })

        var input2 = document.querySelector('input[name="type"]'),
            // init Tagify script on the above inputs
            tagify2 = new Tagify(input2, {
                whitelist: ["development", "report", "configuration"],
                userInput: false,
                placeholder: "Select Type",
                maxTags: 3,
                dropdown: {
                    maxItems: 20, // <- mixumum allowed rendered suggestions
                    classname: "tags-look", // <- custom classname for this dropdown, so it could be targeted
                    enabled: 0, // <- show suggestions on focus
                    closeOnSelect: false // <- do not hide the suggestions dropdown once an item has been selected
                }
            })
    </script>

</body>

</html>