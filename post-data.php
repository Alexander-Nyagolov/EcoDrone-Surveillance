<?php
/*
  Rui Santos
  Complete project details at https://RandomNerdTutorials.com
  
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files.
  
  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.
*/

include ('config.php');
global $conn;
// Keep this API Key value to be compatible with the ESP32 code provided in the project page. If you change this value, the ESP32 sketch needs to match
$api_key_value = "tPmAT5Ab3j7F9";

$api_key = $co = $co2 = $voc = $tvoc = $ozone = $pm1 = $pm25 = $pm10 = $particles_03um = $particles_05um = $particles_10um = $particles_25um = $particles_50um = $particles_100um = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {
        $co = test_input($_POST["co"]);
        $co2 = test_input($_POST["co2"]);
        $voc = test_input($_POST["voc"]);
      	$tvoc = test_input($_POST["tvoc"]);
      	$ozone = test_input($_POST["ozone"]);
        $pm1 = test_input($_POST["pm1"]);
        $pm25 = test_input($_POST["pm25"]);
      	$pm10 = test_input($_POST["pm10"]);
      	$particles_03um = test_input($_POST["particles_03um"]);
      	$particles_05um = test_input($_POST["particles_05um"]);
      	$particles_10um = test_input($_POST["particles_10um"]);
        $particles_25um = test_input($_POST["particles_25um"]);
        $particles_50um = test_input($_POST["particles_50um"]);
      	$particles_100um = test_input($_POST["particles_100um"]);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $sql = "INSERT INTO Sensor (co, co2, voc, tvoc, ozone, pm1, pm25, pm10, particles_03um, particles_05um, particles_10um, particles_25um, particles_50um, particles_100um)
        VALUES ('" . $co . "', '" . $co2 . "', '" . $voc . "', '" . $tvoc . "', '" . $ozone . "', '" . $pm1 . "', '" . $pm25 . "', '" . $pm10 . "', '" . $particles_03um . "', '" . $particles_05um . "', '" . $particles_10um . "', '" . $particles_25um . "', '" . $particles_50um . "', '" . $particles_100um . "')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    	
        $conn->close();
    }
    else {
        echo "Wrong API Key provided.";
    }

}
else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}