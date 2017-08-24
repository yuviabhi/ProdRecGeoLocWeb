<?php

$con=mysqli_connect("localhost","root","","prorec_db");

if (mysqli_connect_errno($con))
{
   echo "Failed to connect to Database: " . mysqli_connect_error();
}


?>