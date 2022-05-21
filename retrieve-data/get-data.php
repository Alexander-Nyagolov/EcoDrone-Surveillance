<?php
include('config.php');
global $conn;
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT co, co2, voc, tvoc, ozone, pm1, pm25, pm10, particles_03um, particles_05um, particles_10um, particles_25um, particles_50um, particles_100um, reading_time FROM Sensor order by reading_time desc limit 40";

$result = $conn->query($sql);

while ($data = $result->fetch_assoc()){
    $sensor_data[] = $data;
}

$readings_time = array_column($sensor_data, 'reading_time');

$i = 0;
foreach ($readings_time as $reading){
    $readings_time[$i] = date("H:i:s d-m-Y", strtotime("$reading"));
    $i += 1;
}

$co = array_reverse(array_column($sensor_data, 'co'));
$co2 = array_reverse(array_column($sensor_data, 'co2'));
$voc = array_reverse(array_column($sensor_data, 'voc'));
$tvoc = array_reverse(array_column($sensor_data, 'tvoc'));
$ozone = array_reverse(array_column($sensor_data, 'ozone'));
$pm1 = array_reverse(array_column($sensor_data, 'pm1'));
$pm25 = array_reverse(array_column($sensor_data, 'pm25'));
$pm10 = array_reverse(array_column($sensor_data, 'pm10'));
$particles_03um = array_reverse(array_column($sensor_data, 'particles_03um'));
$particles_05um = array_reverse(array_column($sensor_data, 'particles_05um'));
$particles_10um = array_reverse(array_column($sensor_data, 'particles_10um'));
$particles_25um = array_reverse(array_column($sensor_data, 'particles_25um'));
$particles_50um = array_reverse(array_column($sensor_data, 'particles_50um'));
$particles_100um = array_reverse(array_column($sensor_data, 'particles_100um'));
$readings_time = array_reverse($readings_time);
$readings_time = end($readings_time);

$co = end($co);
$co2 = end($co2);
$voc = end($voc);
$tvoc = end($tvoc);
$ozone = end($ozone);
$pm1 = end($pm1);
$pm25 = end($pm25);
$pm10 = end($pm10);
$particles_03um = end($particles_03um);
$particles_05um = end($particles_05um);
$particles_10um = end($particles_10um);
$particles_25um = end($particles_25um);
$particles_50um = end($particles_50um);
$particles_100um = end($particles_100um);

echo "$voc, $co, $co2, $tvoc, $ozone, $pm1, $pm25, $pm10, $particles_03um, $particles_05um, $particles_10um, $particles_25um, $particles_50um, $particles_100um, $readings_time";

$result->free();
$conn->close();
?>
