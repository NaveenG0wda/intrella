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
    if ($csrf->validate('deleteslotform')) 
    {
        $id = mysqli_real_escape_string($link, trim($_POST['deleteslot']));

        $query = "delete from tickets_2022_slots where id = '$id'";

        $result = mysqli_query($link,$query);

        if ($result) 
        {
            $_SESSION["save"] = "yes";
            echo "<script> location.replace('viewslots.php') </script>";
        } 
        else 
        {
            $_SESSION["fail"] = "yes";
            echo "<script> location.replace('viewslots.php') </script>";
        }
    } 
    else 
    {
        echo "<script> location.replace('viewslots.php') </script>";
    }

/* Closing the connection to the database. */
    mysqli_close($link);
}
