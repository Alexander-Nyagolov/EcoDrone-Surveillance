<!--
  Rui Santos
  Complete project details at https://RandomNerdTutorials.com
  
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files.
  
  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.

-->
<?php
include ('config.php');
global $conn;
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, value1, value2, value3, reading_time FROM Sensor order by reading_time desc limit 40";

$result = $conn->query($sql);

while ($data = $result->fetch_assoc()){
    $sensor_data[] = $data;
}

$readings_time = array_column($sensor_data, 'reading_time');

// ******* Uncomment to convert readings time array to your timezone ********
$i = 0;
foreach ($readings_time as $reading){
    // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
    $readings_time[$i] = date("H:i:s d-m-Y", strtotime("$reading"));
    // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
    //$readings_time[$i] = date("Y-m-d H:i:s", strtotime("$reading + 4 hours"));
    $i += 1;
}
header("Refresh:3");
$value1 = json_encode(array_reverse(array_column($sensor_data, 'value1')), JSON_NUMERIC_CHECK);
$value2 = json_encode(array_reverse(array_column($sensor_data, 'value2')), JSON_NUMERIC_CHECK);
$value3 = json_encode(array_reverse(array_column($sensor_data, 'value3')), JSON_NUMERIC_CHECK);
$reading_time = json_encode(array_reverse($readings_time), JSON_NUMERIC_CHECK);

/*echo $value1;
echo $value2;
echo $value3;
echo $reading_time;*/

$result->free();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
     <!-- <script src="https://code.highcharts.com/stock/highstock.js"></script>-->
  <script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/stock/modules/export-data.js"></script>
  <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src = "https://code.highcharts.com/highcharts.js"></script>
  <script src = "https://code.highcharts.com/highcharts-more.js"></script>
<link rel="stylesheet" href="/project/style.css">
</head>
  <body>
    <div id="chart-co" class="container"></div>
    <pre>
    <div id="chart-co2" class="container"></div>
    <div id="chart-voc" class="container"></div>
    <div id="chart-ozone" class="container"></div>
    <div id = "container" class="container"></div>

<script>

var value1 = <?php echo $value1; ?>;
var value2 = <?php echo $value2; ?>;
var value3 = <?php echo $value3; ?>;
var reading_time = <?php echo $reading_time; ?>;

var chartT = new Highcharts.Chart({
  chart:{ renderTo : 'chart-co' },
  title: { text: 'CO levels' },
  series: [{
    name: 'CO sensor',
    showInLegend: false,
    data: value1
  }],
  plotOptions: {
    line: { animation: false,
      dataLabels: { enabled: true }
    },
    series: { color: '#059e8a' }
  },
  xAxis: { 
    type: 'datetime',
    categories: reading_time
  },
  yAxis: {
    title: { text: 'CO (μg/m³)' }
  },
  credits: { enabled: false }
});

var chartK = new Highcharts.Chart({
  chart:{ renderTo : 'chart-co2' },
  title: { text: 'CO²  levels' },
  series: [{
    name: 'CO² sensor',
    showInLegend: false,
    data: value1
  }],
  plotOptions: {
    line: { animation: false,
      dataLabels: { enabled: true }
    },
    series: { color: '#059e8a' }
  },
  xAxis: {
    type: 'datetime',
    categories: reading_time
  },
  yAxis: {
    title: { text: 'CO² (μg/m³)' }
  },
  credits: { enabled: false }
});

var chartH = new Highcharts.Chart({
  chart:{ renderTo:'chart-voc' },
  title: { text: 'VOC Air Quality' },
  series: [{
      name: 'VOC sensor',
    showInLegend: false,
    data: value2
  }],
  plotOptions: {
    line: { animation: false,
      dataLabels: { enabled: true }
    }
  },
  xAxis: {
    type: 'datetime',
    //dateTimeLabelFormats: { second: '%H:%M:%S' },
    categories: reading_time
  },
  yAxis: {
    title: { text: 'VOC (ppm)' }
  },
  credits: { enabled: false }
});


var chartP = new Highcharts.Chart({
  chart:{ renderTo:'chart-ozone' },
  title: { text: 'Ozone Levels' },
  series: [{
      name: 'Ozone sensor',
    showInLegend: false,
    data: value3
  }],
  plotOptions: {
    line: { animation: false,
      dataLabels: { enabled: true }
    },
    series: { color: '#18009c' }
  },
  xAxis: {
    type: 'datetime',
    categories: reading_time
  },
  yAxis: {
    title: { text: 'O³ (ppb)' }
  },
  credits: { enabled: false }
});
</script>
    <script language = "JavaScript">

		$(document).ready(function() {
          var value2 = <?php echo $value2; ?>;
          var last = value2[value2.length - 1];
          var valText;
          if(last == 0.5)
		   {
			valText = "Чисто";
		   }
		   else if(last == 1.5)
		   {
			valText = "Ниско";
		   }
		   else if(last == 2.5)
		   {
			valText = "Средно";
		   }
		   else if(last == 3.5)
		   {
			valText = "Високо";
		   }
            var chart = {
               type: 'gauge',
               plotBackgroundColor: null,
               plotBackgroundImage: null,
               plotBorderWidth: 0,
               plotShadow: false
            };
            var title = {
               text: 'VOC Meter'
            };
            var pane = {
               startAngle: -90,
               endAngle: 90,
               background: null
            };

            // the value axis
            var yAxis = {
               min: 0,
               max: 4,

               minorTickInterval: 'auto',
               minorTickWidth: 1,
               minorTickLength: 5,
               minorTickPosition: 'inside',
               minorTickColor: '#666',

               tickPixelInterval: 30,
               tickWidth: 2,
               tickPosition: 'inside',
               tickLength: 10,
               tickColor: '#666',

               labels: {
                  step: 2,
                  rotation: 'auto'
               },
               title: {
                  text: 'Ниво: ' + valText
               },
               plotBands: [
				  {
                     from: 0,
                     to: 1,
                     color: '#D8D8D8' // grey
                  },
                  {
                     from: 1,
                     to: 2,
                     color: '#55BF3B' // green
                  },
                  {
                     from: 2,
                     to: 3,
                     color: '#DDDF0D' // yellow
                  },
                  {
                     from: 3,
                     to: 4,
                     color: '#DF5353' // red
                  }
               ]
            };
            var series = [{
               name: 'Степен',
               data: [last]
            }];
            var json = {};
            json.chart = chart;
            json.title = title;
            json.pane = pane;
            json.yAxis = yAxis;
            json.series = series;


            $('#container').highcharts(json);
         });
      </script>
</body>
</html>