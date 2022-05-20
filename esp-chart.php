<?php
include ('config.php');
global $conn;
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, co, co2, voc, tvoc, ozone, pm1, pm25, pm10, particles_03um, particles_05um, particles_10um, particles_25um, particles_50um, particles_100um, reading_time FROM Sensor order by reading_time desc limit 150";

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
$particles_03um = json_encode(array_reverse(array_column($sensor_data, 'particles_03um')), JSON_NUMERIC_CHECK);
$particles_05um = json_encode(array_reverse(array_column($sensor_data, 'particles_05um')), JSON_NUMERIC_CHECK);
$particles_10um = json_encode(array_reverse(array_column($sensor_data, 'particles_10um')), JSON_NUMERIC_CHECK);
$particles_25um = json_encode(array_reverse(array_column($sensor_data, 'particles_25um')), JSON_NUMERIC_CHECK);
$particles_50um = json_encode(array_reverse(array_column($sensor_data, 'particles_50um')), JSON_NUMERIC_CHECK);
$particles_100um = json_encode(array_reverse(array_column($sensor_data, 'particles_100um')), JSON_NUMERIC_CHECK);
$reading_time = json_encode(array_reverse($readings_time), JSON_NUMERIC_CHECK);

//echo "$co, $co2, $voc, $ozone, $pm1, $pm25, $pm10, $reading_time";

$result->free();
$conn->close();

//header("Refresh:10");
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
<link rel="stylesheet" href="/project/css/style.css">
</head>
  <body>
    <div id="co" class="container"></div>
    <br>
    <div id="chart-tvoc" class="container"></div>
    <br>
    <div id="chart-ozone" class="container"></div>
	<br>
    <div id = "pm" class="container"></div>
    <br>
    <div id = "particles<1" class="container"></div>
    <br>
    <div id = "particles>1" class="container"></div>
<script>

var co = <?php echo $co; ?>;
var co2 = <?php echo $co2; ?>;
var voc = <?php echo $voc; ?>;
var tvoc = <?php echo $tvoc; ?>;
var ozone = <?php echo $ozone; ?>;
var pm1 = <?php echo $pm1; ?>;
var pm25 = <?php echo $pm25; ?>;
var pm10 = <?php echo $pm10; ?>;
var particles_03um = <?php echo $particles_03um; ?>;
var particles_05um = <?php echo $particles_05um; ?>;
var particles_10um = <?php echo $particles_10um; ?>;
var particles_25um = <?php echo $particles_25um; ?>;
var particles_50um = <?php echo $particles_50um; ?>;
var particles_100um = <?php echo $particles_100um; ?>;
var reading_time = <?php echo $reading_time; ?>;

var chartCO = new Highcharts.Chart({
  chart:{ 
    	renderTo:'co',
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
  chart:{ 
    	renderTo:'chart-tvoc',
        zoomType: 'x'
        },
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
  chart:{ 
    	renderTo:'chart-ozone',
  		zoomType: 'x'
  		},
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
  responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                  	events: {
                    load () {
                        this.xAxis[0].setExtremes(139, 149)
                        }
                    },
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            },
          	tooltip: {
              	followTouchMove: false
          		},
        }]
    },
  credits: { enabled: false }
});

var chartPM = new Highcharts.Chart({
  chart:{ 
    	renderTo:'pm',
    	zoomType: 'x'
    },
    title: {
        text: 'Главни фини прахови частици'
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
        name: 'PM1',
        data: pm1
    },{
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
var chartP1 = new Highcharts.Chart({
  chart:{ 
    	renderTo:'particles<1',
    	zoomType: 'x'
    },
    title: {
        text: 'Фини прахови частици (< 1 μg)'
    },

    yAxis: {
        title: {
            text: 'Particles (μg/0.1L air)'
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
        name: '0.3 μg',
        data: particles_03um
    },{
        name: '0.5 μg',
        data: particles_05um
    },{
        name: '0.3 μg',
        data: pm25
    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
              	events: {
                load () {
                    this.xAxis[0].setExtremes(139, 149)
                    }
                },
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});
var chartP10 = new Highcharts.Chart({
  chart:{ 
    	renderTo:'particles>1',
    	zoomType: 'x'
    },
    title: {
        text: 'Фини прахови частици (> 1 μg)'
    },

    yAxis: {
        title: {
            text: 'Particles (μg/0.1L air)'
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
        name: '10 μg',
        data: particles_10um
    },{
        name: '25 μg',
        data: particles_25um
    },{
        name: '50 μg',
        data: particles_50um
    },{
        name: '100 μg',
        data: particles_100um
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
  setInterval(function () {
  function setIntervalX(callback, delay, repetitions) {
    var x = 0;
    var intervalID = window.setInterval(function () {

       callback();

       if (++x === repetitions) {
           window.clearInterval(intervalID);
       }
    }, delay);
}
  setIntervalX(function () {
    var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var string = this.responseText;
      
      let values = string.split(', ');
      reading_time.push(values[values.length - 1])
      var time = reading_time;
      var co = parseFloat(values[values.length - 14]);
      var co2 = parseFloat(values[values.length - 13]);
      var tvoc = parseFloat(values[values.length - 12]);
      var ozone = parseFloat(values[values.length - 11]);
      var pm1 = parseFloat(values[values.length - 10]);
      var pm25 = parseFloat(values[values.length - 9]);
      var pm100 = parseFloat(values[values.length - 8]);
      var p3 = parseFloat(values[values.length - 7]);
      var p5 = parseFloat(values[values.length - 6]);
      var p10 = parseFloat(values[values.length - 5]);
      var p25 = parseFloat(values[values.length - 4]);
      var p50 = parseFloat(values[values.length - 3]);
      var p100 = parseFloat(values[values.length - 2]);
      var x = reading_time[reading_time.length - 1];
      
      if(chartCO.series[0].data.length > 150) {
        chartCO.series[0].addPoint([x, co], true, true, true);
        chartCO.series[1].addPoint([x, co2], true, true, true);
        chartCO.xAxis[0].setCategories(time);
      } else {
        chartCO.series[0].addPoint([x, co], true, false, true);
        chartCO.series[1].addPoint([x, co2], true, false, true);
        chartCO.xAxis[0].setCategories(time);
      }
      if(chartVOC.series[0].data.length > 150) {
        chartVOC.series[0].addPoint([x, tvoc], true, true, true);
        chartVOC.xAxis[0].setCategories(time);
      } else {
        chartVOC.series[0].addPoint([x, tvoc], true, false, true);
        chartVOC.xAxis[0].setCategories(time);
      }
      if(chartOzone.series[0].data.length > 150) {
        chartOzone.series[0].addPoint([x, ozone], true, true, true);
        chartOzone.xAxis[0].setCategories(time);
      } else {
        chartOzone.series[0].addPoint([x, ozone], true, false, true);
        chartOzone.xAxis[0].setCategories(time);
      }
      if(chartPM.series[0].data.length > 150) {
        chartPM.series[0].addPoint([x, pm1], true, true, true);
        chartPM.series[1].addPoint([x, pm25], true, true, true);
        chartPM.series[2].addPoint([x, pm100], true, true, true);
        chartPM.xAxis[0].setCategories(time);
      } else {
        chartPM.series[0].addPoint([x, pm1], true, false, true);
        chartPM.series[1].addPoint([x, pm25], true, false, true);
        chartPM.series[2].addPoint([x, pm100], true, false, true);
        chartPM.xAxis[0].setCategories(time);
      }
      if(chartP1.series[0].data.length > 150) {
        chartP1.series[0].addPoint([x, p3], true, true, true);
        chartP1.series[1].addPoint([x, p5], true, true, true);
        chartP1.series[2].addPoint([x, p10], true, true, true);
        chartP1.xAxis[0].setCategories(time);
      } else {
        chartP1.series[0].addPoint([x, p3], true, false, true);
        chartP1.series[1].addPoint([x, p5], true, false, true);
        chartP1.series[2].addPoint([x, p10], true, false, true);
        chartP1.xAxis[0].setCategories(time);
      }
      if(chartP10.series[0].data.length > 150) {
        chartP10.series[0].addPoint([x, p25], true, true, true);
        chartP10.series[1].addPoint([x, p50], true, true, true);
        chartP10.series[2].addPoint([x, p100], true, true, true);
        chartP10.xAxis[0].setCategories(time);
      } else {
        chartP10.series[0].addPoint([x, p25], true, false, true);
        chartP10.series[1].addPoint([x, p50], true, false, true);
        chartP10.series[2].addPoint([x, p100], true, false, true);
        chartP10.xAxis[0].setCategories(time);
      }
    }
  };
  xmlhttp.open("GET", "get-data.php", true);
  xmlhttp.send();
}, 1000, 5);
}, 60*1000);
</script>
</body>
</html>