<?php
try{
//Database details
$servername = "localhost";
$dbname = "sensor.sql";
$username = "root";
// REPLACE with Database user password
$password = "";


//Create connection and select DB
global $conn ;
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
}
catch(Error $e)
{
    
}