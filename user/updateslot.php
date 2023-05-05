<?php

/* Including the php-csrf.php,database.php file. */
require '../config/php-csrf.php';
require "../config/database.php";

/* Starting a session. */
session_start();

/* Creating a new instance of the CSRF class. */
$csrf = new CSRF();


/* Checking if the request is post or not. */
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    /* Checking if the form is valid or not. */
    if ($csrf->validate('updateslotform')) 
    {
        $qstate = true;

        $id = mysqli_real_escape_string($link, trim($_POST['updateslot']));
        $type = mysqli_real_escape_string($link, trim($_POST['type']));
        $employee = mysqli_real_escape_string($link, trim($_POST['employee']));
        $date = mysqli_real_escape_string($link, trim($_POST['date']));
        $starttime = mysqli_real_escape_string($link, trim($_POST['start']));
        $endtime = mysqli_real_escape_string($link, trim($_POST['end']));
        $email = $_SESSION['user'];

        // $uid = "uid_" . substr(bin2hex(random_bytes(10)), 0, 10);

        $startseconds = strtotime("1970-01-01 $starttime UTC");
        $endseconds = strtotime("1970-01-01 $endtime UTC");

        $secondsdiff = $endseconds - $startseconds;        

        if($secondsdiff == "1800")
        {
            if(date("i",strtotime($starttime)) == "30")
            {
                $startseconds -= 1800;
            }
            else
            {
                $endseconds += 1800;
            }

            $check = "SELECT * FROM tickets_2022_slots WHERE TIME_TO_SEC(starttime) >= '$startseconds' and TIME_TO_SEC(endtime) <= '$endseconds' and date = '$date' and (employee = '$employee' or user = '$email')";
        }
        else
        {
            $check = "SELECT * FROM tickets_2022_slots WHERE TIME_TO_SEC(starttime) >= '$startseconds' and TIME_TO_SEC(endtime) <= '$endseconds' and date = '$date' and (employee = '$employee' or user = '$email')";
        }

        $result = mysqli_query($link, $check);

        $errcount = mysqli_num_rows($result);

        $values = [];

        while($row = mysqli_fetch_array($result))
        {
            array_push($values,$row["user"]);
        }

        // $search = array_search($email,$values);
        
        // echo $check;

            if (($errcount > 0 && $employee != 'suniln@intrella.in') || ($errcount >= 2 && $employee == 'suniln@intrella.in') || array_search($email,$values) != "") 
            {
                $_SESSION["exists"] = 'yes';
                echo "<script> location.replace('myslots.php') </script>";
            } 
            else 
            {
                $query = "update tickets_2022_slots set date = '$date', starttime = '$starttime', endtime = '$endtime', userstatus = 'active', employeestatus = 'active' where id = '$id'";

                if (!mysqli_query($link, $query)) 
                {
                    $qstate = false;
                }

                if ($qstate) 
                {
                    $_SESSION["save"] = 'success';
                    echo "<script> location.replace('myslots.php') </script>";
                } 
                else 
                {
                    $_SESSION["fail"] = 'success';
                    echo "<script> location.replace('myslots.php') </script>";
                }
            }
    } 
    else 
    {
        echo "<script> location.replace('myslots.php') </script>";
    }
} 
else
{
    echo "<script> location.replace('myslots.php') </script>";
}

mysqli_close($link);
