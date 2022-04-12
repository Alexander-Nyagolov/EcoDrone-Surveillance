<?php
include ('config.php');
global $conn;
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, co, co2, voc, tvoc, ozone, pm1, pm25, pm10, reading_time FROM Sensor order by reading_time desc limit 40";

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

$co = json_encode(array_reverse(array_column($sensor_data, 'co')), JSON_NUMERIC_CHECK);
$co2 = json_encode(array_reverse(array_column($sensor_data, 'co2')), JSON_NUMERIC_CHECK);
$voc = json_encode(array_reverse(array_column($sensor_data, 'voc')), JSON_NUMERIC_CHECK);
$tvoc = json_encode(array_reverse(array_column($sensor_data, 'tvoc')), JSON_NUMERIC_CHECK);
$ozone = json_encode(array_reverse(array_column($sensor_data, 'ozone')), JSON_NUMERIC_CHECK);
$pm1 = json_encode(array_reverse(array_column($sensor_data, 'pm1')), JSON_NUMERIC_CHECK);
$pm25 = json_encode(array_reverse(array_column($sensor_data, 'pm25')), JSON_NUMERIC_CHECK);
$pm10 = json_encode(array_reverse(array_column($sensor_data, 'pm10')), JSON_NUMERIC_CHECK);
$reading_time = json_encode(array_reverse($readings_time), JSON_NUMERIC_CHECK);

//echo "$co, $co2, $voc, $ozone, $pm1, $pm25, $pm10, $reading_time";

$result->free();
$conn->close();

//header("Refresh:3");
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
    <div id="co" class="container"></div>
    <div id="chart-tvoc" class="container"></div>
    <div id="chart-ozone" class="container"></div>
	<div id = "pm" class="container"></div>
<script>

var co = <?php echo $co; ?>;
var co2 = <?php echo $co2; ?>;
var voc = <?php echo $voc; ?>;
var tvoc = <?php echo $tvoc; ?>;
var ozone = <?php echo $ozone; ?>;
var pm1 = <?php echo $pm1; ?>;
var pm25 = <?php echo $pm25; ?>;
var pm10 = <?php echo $pm10; ?>;
var reading_time = <?php echo $reading_time; ?>;

Highcharts.chart('co', {
	chart: {
    	zoomType: 'x'
    },
    title: {
        text: 'Въглеродни оксиди'
    },

    yAxis: {
        title: {
            text: 'Нива (ppm)'
        }
    },

    xAxis: {
        accessibility: {
            rangeDescription: 'Range: 2010 to 2017'
        },
      type: 'datetime',
    categories: reading_time
    },

    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
          	animation: false
        }
    },

    series: [ {
        name: 'CO',
        data: co
    }, {
        name: 'CO²',
        data: co2
    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});

var chartVOC = new Highcharts.Chart({
  chart:{ renderTo:'chart-tvoc' },
  title: { text: 'Летливи органични частици' },
  series: [{
      name: 'Показания',
    showInLegend: false,
    data: tvoc
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
    title: { text: 'VOC (ppb)' }
  },
  credits: { enabled: false }
});


var chartOzone = new Highcharts.Chart({
  chart:{ renderTo:'chart-ozone' },
  title: { text: 'Нива на озон' },
  series: [{
      name: 'Показания',
    showInLegend: false,
    data: ozone
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

Highcharts.chart('pm', {
	chart: {
    	zoomType: 'x'
    },
    title: {
        text: 'Финни прахови частици'
    },

    yAxis: {
        title: {
            text: 'PM (μg/m³)'
        }
    },

    xAxis: {
        accessibility: {
            rangeDescription: 'Range: 2010 to 2017'
        },
      type: 'datetime',
    categories: reading_time
    },

    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
          	animation: false
        }
    },

    series: [ {
        name: 'PM2.5',
        data: pm25
    }, {
        name: 'PM10',
        data: pm10
    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});
</script>
</body>
</html>