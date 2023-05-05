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

    <title>Intrella - Book Slot</title>

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
                <a class="list-group-item list-group-item-white list-group-item-action active p-3 gradient-custom-2 shadow-none border-white" href="bookslot.php"><i class="fa-regular fa-calendar-plus fa-lg mx-1"></i> Book Slot</a>
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
                                Slot Created Successfully !
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
                                Slot Creation Failed !
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
                                        <i class="fa-regular fa-calendar-plus mx-1"></i> Book Slot
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                <!-- save slot form -->

                                <form action="saveslot.php" method="post" id="saveslotform" enctype="multipart/form-data">

                                    <!-- Creating a hidden input field csrf -->
                                    <?= $csrf->input('saveslotform'); ?>

                                    <div class="row justify-content-evenly my-3 g-3">

                                        <div class="col-md-5 position-relative ">
                                            <label for="user">Email:</label>
                                            <input type="text" name="user" id="user" class="form-control bg-transparent shadow-none" placeholder="Enter User" value="<?= $_SESSION["user"] ?>" disabled>
                                            <div class="invalid-tooltip rounded-3">
                                                * Enter User
                                            </div>
                                        </div>

                                        <div class="col-md-5 position-relative  ">
                                            <label for="date">Slot Date:</label>
                                            <input type="date" name="date" id="date" class="form-control shadow-none" min="<?= date('Y-m-d'); ?>" placeholder="Enter Date">
                                            <div class="invalid-tooltip rounded-3 alertdate">
                                                * Enter Date
                                            </div>
                                        </div>

                                        <div class="col-md-5 position-relative ">
                                            <label for="type">Slot For:</label>
                                            <select name="type" id="type" class="form-select shadow-none bg-transparent" disabled>
                                                <option value="">Select Type</option>
                                                <option value="explanation">Explanation</option>
                                                <option value="configuration">Configuration</option>
                                                <option value="error">Project Errors</option>
                                                <option value="report">Report</option>
                                            </select>
                                            <div class="invalid-tooltip rounded-3">
                                                * Select Type
                                            </div>
                                        </div>

                                        <div class="col-md-5 position-relative startparent">
                                            <label for="start">Start Time:</label>
                                            <input type="text" name="start" id="start" class="form-control shadow-none" placeholder="Start Time" readonly>
                                            <div class="invalid-tooltip rounded-3">
                                                * Enter Start Time
                                            </div>
                                        </div>

                                        <div class="col-md-5 position-relative endparent">
                                            <label for="end">End Time:</label>
                                            <input type="text" name="end" id="end" class="form-control shadow-none" placeholder="End Time" readonly>
                                            <div class="invalid-tooltip rounded-3">
                                                * Enter End Time
                                            </div>
                                        </div>

                                        <div class="col-md-5 position-relative">
                                            <label for="employee">Employee:</label>
                                            <select name="employee" id="employee" class="form-select shadow-none">
                                                <option type="" value="">Select Employee</option>
                                                <?php
                                                $query = "select * from tickets_2022_employees";
                                                $result = mysqli_query($link, $query);
                                                while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                    <option ename="<?= $row["name"] ?>" type="<?= $row["type"] ?>" value="<?= $row["email"] ?>"><?= $row["name"] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-tooltip rounded-3">
                                                * Select Employee
                                            </div>
                                        </div>

                                        <div class="col-md-5 position-relative ">
                                            <label for="location">Location:</label>
                                            <select name="location" id="location" class="form-select shadow-none bg-transparent">
                                                <option value="">Select Location</option>
                                                <option value="chamundi puram">Chamundi Puram</option>
                                                <option value="ramakrishna nagar">Ramakrishna Nagar</option>
                                            </select>
                                            <div class="invalid-tooltip rounded-3">
                                                * Select Location
                                            </div>
                                        </div>

                                        <div class="col-md-5 position-relative">
                                            <label for="title">Project Title:</label>
                                            <input type="text" name="title" id="title" class="form-control shadow-none" placeholder="Project Title">
                                            <div class="invalid-tooltip rounded-3">
                                                * Enter Title
                                            </div>
                                        </div>

                                        <div class="col-md-5 position-relative">
                                            <label for="description">Project Description:</label>
                                            <textarea rows="1" name="description" id="description" class="form-control shadow-none" placeholder="Project Description"></textarea>
                                            <div class="invalid-tooltip rounded-3">
                                                * Enter Description
                                            </div>
                                        </div>

                                        <div class="col-md-5 position-relative ">
                                            <label for="contact">Contact No:</label>
                                            <input type="text" name="contact" id="contact" class="form-control shadow-none" placeholder="Contact No">
                                            <div class="invalid-tooltip rounded-3 alertphone">
                                                * Enter Valid Contact No
                                            </div>
                                        </div>

                                        <div class="col-md-5 position-relative reportcol" style="display:none ;">
                                            <label for="format">Report Format:</label>
                                            <select name="format" id="format" class="form-select shadow-none">
                                                <option value="">Select Type</option>
                                                <option value="srs">SRS</option>
                                                <option value="system_design">System Design</option>
                                                <option value="literature_survey">Literature Survey</option>
                                                <option value="full_report">Full Report</option>
                                            </select>
                                            <div class="invalid-tooltip rounded-3">
                                                * Select Format
                                            </div>
                                        </div>

                                        <div class="col-md-5 position-relative reportcol" style="display:none ;">
                                            <label for="file">Report File:</label>
                                            <input type="file" name="file" id="file" class="form-control shadow-none">
                                            <div class="invalid-tooltip rounded-3">
                                                * Select File
                                            </div>
                                        </div>

                                        <input type="hidden" name="employeename" id="employeename" value="">

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>
    <script src="../js/timepicker.js"></script>

    <!-- javascript imports -->

    <script>
        $(function() {


            /* Showing the toast message. */
            $('.toast').toast('show');

            /* Validating the form. */
            $("#saveslotform").on("submit", function(e) {

                debugger;

                var testemail = new RegExp("[a-z0-9]+@[a-z]+\.[a-z]{2,3}");
                var testphone = new RegExp("^[6-9][0-9]{9}$");

                var contact = $("#contact").val();
                var date = $("#date").val();
                var title = $("#title").val();
                var start = $("#start").val();
                var end = $("#end").val();
                var employee = $("#employee").val();
                var description = $("#description").val();
                var format = $("#format").val();
                var type = $("#type").val();
                var file = $("#file").val();
                var location = $("#location").val();

                $("#employeename").val($("#employee option:selected").attr("ename"));

                if (date != "") 
                {
                    if (new Date(date).getDay() == 0) {
                        $(".alertdate").text("* Select Only Weekdays");
                        $("#date").addClass("is-invalid");
                        e.preventDefault();
                    } 
                    else 
                    {
                        $("#date").removeClass("is-invalid");
                    }
                } 
                else 
                {
                    $(".alertdate").text("* Enter Date");
                    $("#date").addClass("is-invalid");
                    e.preventDefault();
                }
                

                if (location != "") {
                    $("#location").removeClass("is-invalid");
                } else {
                    $("#location").addClass("is-invalid");
                    e.preventDefault();
                }


                if (start != "") {
                    $("#start").removeClass("is-invalid");
                } else {
                    $("#start").addClass("is-invalid");
                    e.preventDefault();
                }


                if (end != "") {
                    $("#end").removeClass("is-invalid");
                } else {
                    $("#end").addClass("is-invalid");
                    e.preventDefault();
                }


                if (title != "") {
                    $("#title").removeClass("is-invalid");
                } else {
                    $("#title").addClass("is-invalid");
                    e.preventDefault();
                }


                if (description != "") {
                    $("#description").removeClass("is-invalid");
                } else {
                    $("#description").addClass("is-invalid");
                    e.preventDefault();
                }


                if (employee != "") {
                    $("#employee").removeClass("is-invalid");
                } else {
                    $("#employee").addClass("is-invalid");
                    e.preventDefault();
                }


                if (type != "") {
                    $("#type").removeClass("is-invalid");
                } else {
                    $("#type").addClass("is-invalid");
                    e.preventDefault();
                }


                if (type == 'report') {

                    if (format != "") {
                        $("#format").removeClass("is-invalid");
                    } else {
                        $("#format").addClass("is-invalid");
                        e.preventDefault();
                    }

                }

                if (type == 'report') {

                    if (file != "") {
                        $("#file").removeClass("is-invalid");
                    } else {
                        $("#file").addClass("is-invalid");
                        e.preventDefault();
                    }

                }


                if (contact != "") {
                    if (!testphone.test(contact)) {
                        $(".alertphone").text("* Enter Valid Contact No");
                        $("#contact").addClass("is-invalid");
                        e.preventDefault();
                    } else {
                        $("#contact").removeClass("is-invalid");
                    }
                } else {
                    $(".alertphone").text("* Enter Contact No");
                    $("#contact").addClass("is-invalid");
                    e.preventDefault();
                }

            })

            $("#resetbut").on("click", function() {

                $("input,textarea,select").removeClass("is-invalid")
                $("#start").attr("readonly", true);
                $("textarea").css("height", "auto");
                $(".reportcol").hide();
                $("#type").attr("disabled", true);

            })


            $("textarea").on('input focus', function() {
                this.style.height = 'auto';

                this.style.height =
                    (this.scrollHeight) + 'px';
            });


            $("input,textarea,select").on("keydown change", function() {

                $(this).removeClass("is-invalid")

            })

            $("#date").on("change", function() {

                var value = $(this).val();

                if (value == "") {
                    $("#type option[value='']").prop("selected", true).trigger("change");
                    $("#type").attr("disabled", true);
                } else {
                    $("#type").removeAttr("disabled");
                }

            })


            $("#start").on("change", function() {

                var value = $(this).val();

                var type = $("#type").val();

                if (value != '' && type == "explanation" || type == "configuration" || type == "error") {
                    $("#end").val(moment.utc(value, 'HH:mm:ss').add(1, 'hour').format('HH:mm:ss'))
                } else if (value != '' && type == "report") {
                    $("#end").val(moment.utc(value, 'HH:mm:ss').add(30, 'minutes').format('HH:mm:ss'))
                }

            })


            $("#type").on("change", function() {
                debugger;

                var dateval = $("#date").val();

                var value = $(this).val()

                var min = '10';

                if (moment().format("HH") > min && dateval == moment().format('YYYY-MM-DD')) {
                    min = moment().format("HH");
                }

                if (value == "explanation" || value == "configuration" || value == "error") {
                    $("#start").val("");
                    $("#end").val("");

                    $('#start').timepicker({
                        'disableTimeRanges': [
                            ['01:30pm', '03:00pm'],
                            ['06:30pm', '07:30pm'],
                        ],
                        'timeFormat': 'H:i:s',
                        'minTime': min,
                        'maxTime': '19',
                        'appendTo': $(".startparent"),
                        'className': 'w-92',
                        'disableTextInput': true,
                        'disableTouchKeyboard': true,
                    });

                    $("#start").removeAttr("readonly");
                    $(".reportcol").hide();
                    $("#employee option[value='']").prop("selected", true).trigger("change");

                } else if (value == "report") {
                    $("#start").val("");
                    $("#end").val("");

                    $('#start').timepicker({
                        'disableTimeRanges': [
                            ['02:00pm', '03:00pm'],
                            ['07:00pm', '07:30pm'],
                        ],
                        'timeFormat': 'H:i:s',
                        'minTime': min,
                        'maxTime': '19',
                        'appendTo': $(".startparent"),
                        'className': 'w-92',
                        'disableTextInput': true,
                        'disableTouchKeyboard': true,
                    });

                    $("#start").removeAttr("readonly");
                    $(".reportcol").show();
                    $("#employee option[value='']").prop("selected", true).trigger("change");

                } else {

                    $("#start").val("");
                    $("#end").val("");
                    $("#start").attr("readonly", true);
                    $(".reportcol").hide();
                    $("#employee option[value='']").prop("selected", true).trigger("change");

                }


                if (value == 'explanation') {
                    $("#employee option").not("[value = '']").hide();

                    $("#employee option").each(function() {
                        if ($(this).attr("type").indexOf("development") > -1)
                            $(this).show()
                    })
                } else if (value == 'configuration') {
                    $("#employee option").not("[value = '']").hide();
                    $("#employee option").each(function() {
                        if ($(this).attr("type").indexOf("configuration") > -1)
                            $(this).show()
                    })
                } else if (value == 'report') {
                    $("#employee option").not("[value = '']").hide();
                    $("#employee option").each(function() {
                        if ($(this).attr("type").indexOf("report") > -1)
                            $(this).show()
                    })
                } else if (value == 'error') {
                    $("#employee option").not("[value = '']").hide();
                    $("#employee option").each(function() {
                        if ($(this).attr("type").indexOf("development") > -1)
                            $(this).show()
                    })
                }

            })
        })
    </script>


</body>

</html>