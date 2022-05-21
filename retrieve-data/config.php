<?php
//Database details
$servername = "localhost";
$dbname = "alexand7_Alldata";
$username = "alex";
// REPLACE with Database user password
$password = "blPWnaX1508**TAI";


//Create connection and select DB
global $conn ;
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}