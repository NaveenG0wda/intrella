<?php

/* Including the csrf,database files. */
require '../config/php-csrf.php';
require "../config/database.php";

/* Starting a session and requiring the database.php file. */
session_start();


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

    <title>Intrella - All Slots</title>

    <!-- css imports -->

    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.css" />
    <link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />

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
                <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white" href="myslots.php"><i class="fa-solid fa-business-time fa-lg mx-1"></i> My Slots</a>
                <a class="list-group-item list-group-item-white list-group-item-action p-3 gradient-custom-2 shadow-none border-white active" href="createuser.php"><i class="fa-solid fa-check-to-slot fa-lg mx-1"></i> All Slots</a>
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

                <div class="row justify-content-center my-3 g-3">
                    <div class="col-md-4">
                        <div class="d-flex justify-content-center mb-2 gap-2">
                            <button class="btn btn-green shadow-none changerange" onclick="calendar.prev();">
                                Previous
                            </button>
                            <button class="btn btn-green shadow-none changerange" onclick="calendar.today();document.getElementById('selectdate').value=''">
                                Today
                            </button>
                            <button class="btn btn-green shadow-none changerange" onclick="calendar.next();">
                                Next
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center align-items-center gap-1 lead">
                        [ <span id="startrange"></span> - <span id="endrange"></span> ]
                    </div>
                    <div class="col-md-4 d-flex justify-content-center align-items-center gap-2">
                        <label for="selectdate">Select:</label>
                        <input type="date" name="selectdate" id="selectdate" class="form-control shadow-none">
                    </div>
                    <div class="col-md-11">
                        <div id="calendar" style="height:90vh;"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- javascript imports -->

    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js"></script>

    <?php

    $queryv = "select * from tickets_2022_slots";
    $result = mysqli_query($link, $queryv);
    $data = [];
    $count = 0;
    foreach ($result as $row) 
    {
        $data[] = array(
            'id' => "event".$count++,
            'calendarId' => "cal".$count++,
            'title' => ucfirst($row["type"]),
            'state' => ucfirst($row["employeestatus"]),
            'attendees' => [ucfirst($row["employeename"])],
            'start' => $row["date"]."T".$row["starttime"],
            'end' => $row["date"]."T".$row["endtime"],
        );
    }

    ?>
    <!-- javascript imports -->

    <script>
        const Calendar = tui.Calendar;
        const container = document.getElementById('calendar');
        const calendar = new Calendar(container, {
            defaultView: 'month',
            isReadOnly: true,
            useDetailPopup: true,
            zones: [{
                timezoneName: 'Asia/Calcutta',
                displayLabel: 'Mysore',
            }, ],
        });
        calendar.createEvents(<?=json_encode($data)?>);
        // [{
        //     id: 'event1',
        //     calendarId: 'cal1',
        //     body: 'body',
        //     title: 'Weekly meeting',
        //     location: 'location',
        //     attendees: ['attendees'],
        //     state: 'state',
        //     start: '2022-09-07T09:00:00',
        //     end: '2022-09-07T10:00:00',
        // }, ]

        $("#startrange").text(new Date(calendar.getDateRangeStart()).toLocaleDateString("en-IN"))

        $("#endrange").text(new Date(calendar.getDateRangeEnd()).toLocaleDateString("en-IN"))


        $(function() {

            $(".changerange").on("click", function() {

                $("#startrange").text(new Date(calendar.getDateRangeStart()).toLocaleDateString("en-IN"))

                $("#endrange").text(new Date(calendar.getDateRangeEnd()).toLocaleDateString("en-IN"))
            })

            $("#selectdate").on("change", function() {

                debugger;

                var setdate = $(this).val();

                calendar.setDate(String(setdate));

                $("#startrange").text(new Date(calendar.getDateRangeStart()).toLocaleDateString("en-IN"))

                $("#endrange").text(new Date(calendar.getDateRangeEnd()).toLocaleDateString("en-IN"))
            })

        })
    </script>

</body>

</html>