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
    if ($csrf->validate('saveuserform')) 
    {
        $state = true;

        $role = mysqli_real_escape_string($link, trim($_POST['role']));

        if($role == 'employee')
        {        
            $email = mysqli_real_escape_string($link, trim($_POST['email']));
            $password = mysqli_real_escape_string($link, trim($_POST['password']));
            $name = mysqli_real_escape_string($link, trim($_POST['name']));
            $type = json_decode($_POST["type"]);
            $typestring = '';
        
            foreach ($type as $key => $value) 
            {
              $typestring .= $value->value.($key != count($type)-1?",":"");
            }
        }
        else
        {        
            $title = mysqli_real_escape_string($link, trim($_POST['title']));
            $course = mysqli_real_escape_string($link, trim($_POST['course']));
            $pid = mysqli_real_escape_string($link, trim($_POST['pid']));
            $email = mysqli_real_escape_string($link, trim($_POST['email']));
            $password = mysqli_real_escape_string($link, trim($_POST['password']));
            $phone = json_decode($_POST["phone"]);
            $phonestring = '';
        
            foreach ($phone as $key => $value) 
            {
              $phonestring .= $value->value.($key != count($phone)-1?",":"");
            }
        }

        $uid = "uid_".substr(bin2hex(random_bytes(10)),0, 10);

        if($role == 'student')
        {        
           /* This is checking if the email or pid already exists. */
           $checkrecord = mysqli_query($link, "SELECT * FROM tickets_2022_users WHERE    email='$email' or pid = '$pid'");

           $totalrows = mysqli_num_rows($checkrecord);

           if ($totalrows > 0) 
           {
               $_SESSION["exists"] = 'yes';
               echo "<script> location.replace('createuser.php') </script>";
           } 
           else 
           {
             /* query to insert the user. */
               $query = "insert into tickets_2022_users (uid,title,course,phone,email,password,pid) values ('$uid','$title','$course','$phonestring','$email','$password','$pid')";

               if (!mysqli_query($link, $query)) 
               {
                   $state = false;
               }

               if ($state) 
               {
                   $_SESSION["save"] = "yes";
                   echo "<script> location.replace('createuser.php') </script>";
               } 
               else 
               {
                   $_SESSION["fail"] = "yes";
                   echo "<script> location.replace('createuser.php') </script>";
               }
           }
        }
        else
        {
          /* This is checking if the email already exists. */
           $checkrecord = mysqli_query($link, "SELECT * FROM tickets_2022_employees WHERE    email='$email'");

           $totalrows = mysqli_num_rows($checkrecord);

           if ($totalrows > 0) 
           {
               $_SESSION["exists"] = 'yes';
               echo "<script> location.replace('createuser.php') </script>";
           } 
           else 
           {
             /* query to insert the user. */
               $query = "insert into tickets_2022_employees (uid,name,type,email,password) values ('$uid','$name','$typestring','$email','$password')";

               if (!mysqli_query($link, $query)) 
               {
                   $state = false;
               }

               if ($state) 
               {
                   $_SESSION["save"] = "yes";
                   echo "<script> location.replace('createuser.php') </script>";
               } 
               else 
               {
                   $_SESSION["fail"] = "yes";
                   echo "<script> location.replace('createuser.php') </script>";
               }
           }
        }       
    } 
    else 
    {
        echo "<script> location.replace('createuser.php') </script>";
    }

/* Closing the connection to the database. */
    mysqli_close($link);
}
