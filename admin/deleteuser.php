<?php

/* Including the csrf,database files. */
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
    if ($csrf->validate('deleteuserform')) 
    {
        $state = true;

        $id = mysqli_real_escape_string($link, trim($_POST['butdel']));

        /* This is a query to delete a user from the table. */
        $query = "delete from tickets_2022_users where id = '$id'";

        if (!mysqli_query($link, $query)) 
        {
            $state = false;
        }

        if ($state) 
        {
            $_SESSION["save"] = "yes";
            echo "<script> location.replace('manageusers.php') </script>";
        } 
        else 
        {
            $_SESSION["fail"] = "yes";
            echo "<script> location.replace('manageusers.php') </script>";
        }
    } 
    else 
    {
        echo "<script> location.replace('manageusers.php') </script>";
    }

    /* Closing the connection to the database. */
    mysqli_close($link);
}
