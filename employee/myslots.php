<?php

/* Including the csrf,database files. */
require '../config/php-csrf.php';
require "../config/database.php";

/* Starting a session and requiring the database.php file. */
session_start();

/* Setting the default timezone to Asia/Calcutta. */
date_default_timezone_set("Asia/Calcutta");

/* Checking if the admin is logged in. If the admin is logged in, it will redirect the admin to the dashboard. */
if (!isset($_SESSION["employee"])) {
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

    <title>Intrella - My Slots</title>

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
                <a class="list-group-item list-group-item-white list-group-item-action active p-3 gradient-custom-2 shadow-none border-white" href="myslots.php"><i class="fa-solid fa-business-time fa-lg mx-1"></i> My Slots</a>
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
                                    Slot Changed Successfully !
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


                <p class="text-start my-3 fs-3 text-green text-decoration-underline tug-2">My Slots</p>

                <div class="row mb-3 g-4">

                    <?php
                    /* Selecting all the slots from the database where the employee is the current employee and the date is greater than the current date. */
                    $query = "select * from tickets_2022_slots where employee = '" . $_SESSION["employee"] . "'";
                    $result = mysqli_query($link, $query);
                    while ($row = mysqli_fetch_array($result)) {
                    ?>

                        <div class="col-auto">
                            <div class="card border-green shadow-none">
                                <div class="card-header gradient-custom-2 py-2">
                                    <div class="today text-capitalize d-flex align-items-center justify-content-between text-white">
                                        <div class=" fs-5">
                                            <i class="fa-solid fa-diagram-project"></i>
                                            <?= $row["title"] ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="text-start mb-1 fs-6 text-green">
                                        <i class="fa-solid fa-calendar-days"></i>
                                        Date - <?= $row["date"] ?>
                                    </div>
                                    <div class="text-start mb-1 fs-6 text-green">
                                        <i class="fa-regular fa-at"></i>
                                        Student - <?= $row["user"] ?>
                                    </div>
                                    <div class="text-start mb-1 fs-6 text-green">
                                        <i class="fa-solid fa-clock"></i>
                                        Time - <?= $row["starttime"] ?> - <?= $row["endtime"] ?>
                                    </div>
                                    <div class="text-start mb-1 text-capitalize fs-6 text-green">
                                        <i class="fa-solid fa-user"></i>
                                        Student Status -
                                        <span class="<?= $row["userstatus"] == "closed" ? "text-danger" : "" ?> ">
                                            <?= $row["userstatus"] ?>
                                        </span>
                                    </div>
                                    <div class="text-start mb-1 text-capitalize fs-6 text-green">
                                        <i class="fa-solid fa-user-tie"></i>
                                        Your Status -
                                        <span class="<?= $row["employeestatus"] == "closed" ? "text-danger" : "" ?> ">
                                            <?= $row["employeestatus"] ?>
                                        </span>
                                    </div>
                                    <div class="text-start mb-1 text-capitalize fs-6 text-green">
                                        <i class="fa-solid fa-laptop-file"></i>
                                        Type - <?= $row["type"] ?>
                                        <?php
                                        if ($row["type"] == "report") {
                                        ?>
                                            <a href="../docs/<?= $row["reportfile"] ?>" download="../docs/<?= $row["reportfile"] ?>" class="text-green text-decoration-none">- Download</a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="text-start mb-1 text-capitalize fs-6 text-green">
                                        <i class="fa-solid fa-location-dot"></i>
                                        Location - <?= $row["location"] ?>
                                    </div>

                                    <?php

                                    if (($row["date"] == date("Y-m-d") && $row["starttime"] < date("H:i:s") && $row["employeestatus"] != "closed")) 
                                    {

                                    ?>

                                        <div class="text-start mt-4 gap-3 g-3 d-flex text-capitalize fs-6 text-green">
                                            <button type="submit" class="btn btn-sm btn-green shadow-none" name="deleteslot" data-bs-target="#deleteslotmodal-<?= $row["id"] ?>" role="button" data-bs-toggle="modal">
                                                <i class="fa-solid fa-circle-xmark me-md-1"></i>
                                                Close Slot
                                            </button>
                                            <button type="submit" class="btn btn-sm btn-green shadow-none" data-bs-target="#editslotmodal-<?= $row["id"] ?>" role="button" data-bs-toggle="modal">
                                                <i class="fa-solid fa-pen-to-square me-md-1"></i>
                                                Edit Slot
                                            </button>
                                        </div>

                                    <?php

                                    }

                                    ?>

                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="editslotmodal-<?= $row["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header gradient-custom-2">
                                        <h5 class="modal-title text-white" id="exampleModalLabel">Edit Slot</h5>
                                        <button type="button" class="btn-close bg-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="updateslot.php" method="POST" class="updateslotform">
                                        <div class="modal-body">
                                            <div class="row g-3">

                                                <!-- Creating a hidden input field csrf -->
                                                <?= $csrf->input('updateslotform'); ?>

                                                <div class="col-md-6 position-relative startparent">
                                                    <label for="title">Project:</label>
                                                    <input type="text" name="title" id="title" class="form-control shadow-none bg-transparent" value="<?= $row["title"] ?>" placeholder="Project Title" readonly>
                                                    <div class="invalid-tooltip rounded-3">
                                                        * Enter Project Title
                                                    </div>
                                                </div>

                                                <input type="hidden" name="type" id="type" value="<?= $row["type"] ?>">

                                                <input type="hidden" name="user" id="user" value="<?= $row["user"] ?>">

                                                <div class="col-md-6 position-relative ">
                                                    <label for="date">Slot Date:</label>
                                                    <input type="date" name="date" id="date" class="form-control shadow-none date" min="<?= date('Y-m-d'); ?>" placeholder="Enter Date">
                                                    <div class="invalid-tooltip rounded-3 alertdate">
                                                        * Enter Date
                                                    </div>
                                                </div>

                                                <div class="col-md-6 position-relative startparent">
                                                    <label for="start">Start Time:</label>
                                                    <input type="text" name="start" id="start" class="form-control shadow-none start" placeholder="Start Time" readonly>
                                                    <div class="invalid-tooltip rounded-3">
                                                        * Enter Start Time
                                                    </div>
                                                </div>

                                                <div class="col-md-6 position-relative endparent">
                                                    <label for="end">End Time:</label>
                                                    <input type="text" name="end" id="end" class="form-control shadow-none" placeholder="End Time" readonly>
                                                    <div class="invalid-tooltip rounded-3">
                                                        * Enter End Time
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-green shadow-none" name="updateslot" value="<?= $row["id"] ?>">Update
                                                changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="deleteslotmodal-<?= $row["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header gradient-custom-2">
                                        <h5 class="modal-title text-white" id="exampleModalLabel">Close Slot</h5>
                                        <button type="button" class="btn-close bg-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="deleteslot.php" method="POST" class="deleteslotform">
                                        <div class="modal-body">
                                            <div class="row g-3">

                                                <!-- Creating a hidden input field csrf -->
                                                <?= $csrf->input('deleteslotform'); ?>

                                                <div class="col-md-12 position-relative startparent">
                                                    <label for="comment">Comment:</label>
                                                    <textarea rows="3" name="comment" id="comment" class="form-control shadow-none bg-transparent" placeholder="Your Comment" required></textarea>
                                                    <div class="invalid-tooltip rounded-3">
                                                        * Enter Comment
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-green shadow-none" name="deleteslot" value="<?= $row["id"] ?>">Close
                                                Slot</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                    <?php
                    }
                    ?>

                </div>

            </div>
        </div>
    </div>

    <!-- javascript imports -->

    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/timepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>

    <!-- javascript imports -->

    <script>
        $(function() {
            /* Showing the toast message. */
            $('.toast').toast('show');

            $("input,textarea,select").on("keydown change", function() {

                $(this).removeClass("is-invalid")

            })

            $(".updateslotform").on("submit", function(e) {

                debugger;

                var date = $(this).find("#date").val();

                var start = $(this).find("#start").val();

                var end = $(this).find("#end").val();


                if (date != "") {
                    if (new Date(date).getDay() == 0) {
                        $(".alertdate").text("* Select Only Weekdays");
                        $("#date").addClass("is-invalid");
                        e.preventDefault();
                    } else {
                        $("#date").removeClass("is-invalid");
                    }
                } else {
                    $(".alertdate").text("* Enter Date");
                    $("#date").addClass("is-invalid");
                    e.preventDefault();
                }



                if (start != "") {
                    $(this).find("#start").removeClass("is-invalid");
                } else {
                    $(this).find("#start").addClass("is-invalid");
                    e.preventDefault();
                }


                if (end != "") {
                    $(this).find("#end").removeClass("is-invalid");
                } else {
                    $(this).find("#end").addClass("is-invalid");
                    e.preventDefault();
                }


            })


            $(document).on("change", ".date", function() {
                debugger;

                var date = $(this);

                var value = $(this).closest("form").find("#type").val()

                var min = '10';

                if (moment().format("HH") > min && date.val() == moment().format('YYYY-MM-DD')) {
                    min = moment().format("HH");
                }

                if (value == "explanation" || value == "configuration" || value == "error") {

                    date.closest("form").find("#start").val("");
                    date.closest("form").find("#end").val("");


                    date.closest("form").find('#start').timepicker({
                        'disableTimeRanges': [
                            ['01:30pm', '03:00pm'],
                            ['06:30pm', '07:30pm'],
                        ],
                        'timeFormat': 'H:i:s',
                        'minTime': min,
                        'maxTime': '19',
                        'appendTo': date.closest("form").find(".startparent"),
                        'className': 'w-92',
                        'disableTextInput': true,
                        'disableTouchKeyboard': true,
                    });

                    date.closest("form").find("#start").removeAttr("readonly");

                } else if (value == "report") {
                    date.closest("form").find("#start").val("");
                    date.closest("form").find("#end").val("");

                    date.closest("form").find('#start').timepicker({
                        'disableTimeRanges': [
                            ['02:00pm', '03:00pm'],
                            ['07:00pm', '07:30pm'],
                        ],
                        'timeFormat': 'H:i:s',
                        'minTime': min,
                        'maxTime': '19',
                        'appendTo': date.closest("form").find(".startparent"),
                        'className': 'w-92',
                        'disableTextInput': true,
                        'disableTouchKeyboard': true,
                    });

                    date.closest("form").find("#start").removeAttr("readonly");

                } else {

                    date.closest("form").find("#start").val("");
                    date.closest("form").find("#end").val("");
                    date.closest("form").find("#start").attr("readonly", true);

                }
            })


            $(".start").on("change", function() {

                var value = $(this).val();

                var type = $(this).closest("form").find("#type").val();

                $(this).closest("form").find("#end").removeClass("is-invalid");

                if (value != '' && type == "explanation" || type == "configuration" || type == "error") {
                    $(this).closest("form").find("#end").val(moment.utc(value, 'HH:mm:ss').add(1, 'hour').format('HH:mm:ss'))
                } else if (value != '' && type == "report") {
                    $(this).closest("form").find("#end").val(moment.utc(value, 'HH:mm:ss').add(30, 'minutes').format('HH:mm:ss'))
                }

            })


        })
    </script>


</body>

</html>