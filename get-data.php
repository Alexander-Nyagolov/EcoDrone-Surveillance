<?php
include ('config.php');
global $conn;
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT voc, reading_time FROM Sensor order by reading_time desc limit 40";

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

$voc = json_encode(array_reverse(array_column($sensor_data, 'voc')), JSON_NUMERIC_CHECK);

echo $voc;

$result->free();
$conn->close();
?>
