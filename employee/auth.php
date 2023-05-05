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
    if ($csrf->validate('employeeloginform')) 
    {
        $email = mysqli_real_escape_string($link, trim($_POST['email']));
        $password = mysqli_real_escape_string($link, trim($_POST['password']));

        $query = "select * from tickets_2022_employees where email = '$email' and password = '$password'";

        $result = mysqli_query($link,$query);

        $row = mysqli_fetch_array($result);

       /* checking if the email and password are correct. */
       if (!empty($row["email"]) && !empty($row["password"])) 
        {
            $_SESSION["employee"] = $row["email"];
            $_SESSION["employeename"] = $row["name"];
            echo "<script> location.replace('dashboard.php') </script>";
        } 
        else 
        {
            $_SESSION["fail"] = "yes";
            echo "<script> location.replace('index.php') </script>";
        }
    } 
    else 
    {
        echo "<script> location.replace('index.php') </script>";
    }

/* Closing the connection to the database. */
    mysqli_close($link);
}
