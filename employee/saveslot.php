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
    if ($csrf->validate('saveslotform')) 
    {
        $qstate = true;
        $file = "";

        $type = mysqli_real_escape_string($link, trim($_POST['type']));
        $date = mysqli_real_escape_string($link, trim($_POST['date']));
        $starttime = mysqli_real_escape_string($link, trim($_POST['start']));
        $endtime = mysqli_real_escape_string($link, trim($_POST['end']));
        $employee = mysqli_real_escape_string($link, trim($_POST['employee']));
        $employeename = mysqli_real_escape_string($link, trim($_POST['employeename']));
        $location = mysqli_real_escape_string($link, trim($_POST['location']));
        $title = mysqli_real_escape_string($link, trim($_POST['title']));
        $description = mysqli_real_escape_string($link, trim($_POST['description']));
        $contact = mysqli_real_escape_string($link, trim($_POST['contact']));
        $reportformat = isset($_POST['format']) ? mysqli_real_escape_string($link, trim($_POST["format"])) : "";
        $email = $_SESSION['user'];

        $uid = "uid_" . substr(bin2hex(random_bytes(10)), 0, 10);

        $startseconds = strtotime("1970-01-01 $starttime UTC");
        $endseconds = strtotime("1970-01-01 $endtime UTC");

        $check = "SELECT * FROM tickets_2022_slots WHERE TIME_TO_SEC(starttime) >= '$startseconds' and TIME_TO_SEC(endtime) <= '$endseconds' and date = '$date' and employee = '$employee'";

        $result = mysqli_query($link, $check);

        $errcount = mysqli_num_rows($result);

        $values = [];

        while($row = mysqli_fetch_array($result))
        {
            array_push($values,$row["user"]);
        }

        $search = array_search($email,$values);
        
        // echo $check;

        if ($_FILES["file"]["size"] !== 0) 
        {

            if (($errcount > 0 && $employee != 'suniln@intrella.in') && ($errcount >= 2 && $employee == 'suniln@intrella.in') || array_search($email,$values) != "") 
            {
                $_SESSION["exists"] = 'yes';
                echo "<script> location.replace('bookslot.php') </script>";
            } 
            else 
            {
                $errors = null;
                $file_name = $_FILES['file']['name'];
                $file_size = $_FILES['file']['size'];
                $file_tmp = $_FILES['file']['tmp_name'];
                $file_type = $_FILES['file']['type'];
                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

                if (is_dir("../docs/" . $email)) 
                {
                    move_uploaded_file($file_tmp, "../docs/" . $email . "/" . $file_name);

                    $path = $email . "/" . $file_name;

                    $query = "insert into tickets_2022_slots (uid,starttime,endtime,date,type,employee,user,title,description,reportformat,reportfile,contact,userstatus,employeestatus,employeename,location) values('$uid','$starttime','$endtime','$date','$type','$employee','$email','$title','$description','$reportformat','$path','$contact','active','active','$employeename','$location')";

                    if (!mysqli_query($link, $query)) 
                    {
                        $qstate = false;
                    }
                } 
                else 
                {
                    mkdir("../docs/" . $email);

                    move_uploaded_file($file_tmp, "../docs/" . $email . "/" . $file_name);

                    $path = $email . "/" . $file_name;

                    $query = "insert into tickets_2022_slots (uid,starttime,endtime,date,type,employee,user,title,description,reportformat,reportfile,contact,userstatus,employeestatus,employeename,location) values('$uid','$starttime','$endtime','$date','$type','$employee','$email','$title','$description','$reportformat','$path','$contact','active','active','$employeename','$location')";

                    if (!mysqli_query($link, $query)) 
                    {
                        $qstate = false;
                    }

                    if ($qstate) 
                    {
                        $_SESSION["save"] = 'success';
                        echo "<script> location.replace('bookslot.php') </script>";
                    } 
                    else 
                    {
                        $_SESSION["fail"] = 'success';
                        echo "<script> location.replace('bookslot.php') </script>";
                    }
                }
            }
        } 
        else 
        {

            if (($errcount > 0 && $employee != 'suniln@intrella.in') && ($errcount >= 2 && $employee == 'suniln@intrella.in') || array_search($email,$values) != "") 
            {
                $_SESSION["exists"] = 'yes';
                echo "<script> location.replace('bookslot.php') </script>";
            } 
            else 
            {
                $query = "insert into tickets_2022_slots (uid,starttime,endtime,date,type,employee,user,title,description,reportformat,reportfile,contact,userstatus,employeestatus,employeename,location) values('$uid','$starttime','$endtime','$date','$type','$employee','$email','$title','$description','','','$contact','active','active','$employeename','$location')";

                if (!mysqli_query($link, $query)) 
                {
                    $qstate = false;
                }

                if ($qstate) 
                {
                    $_SESSION["save"] = 'success';
                    echo "<script> location.replace('bookslot.php') </script>";
                } 
                else 
                {
                    $_SESSION["fail"] = 'success';
                    echo "<script> location.replace('bookslot.php') </script>";
                }
            }
        }
    } 
    else 
    {
        echo "<script> location.replace('bookslot.php') </script>";
    }
} 
else
{
    echo "<script> location.replace('bookslot.php') </script>";
}

mysqli_close($link);
