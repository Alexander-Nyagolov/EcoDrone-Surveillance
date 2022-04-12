<!DOCTYPE html>
<html lang="en">
<head>
        <title>Eco Drone official website</title>
        <link rel="stylesheet" href="project/style.css">
    <script src = "https://code.highcharts.com/highcharts.js"></script>
  <script src = "https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/stock/modules/export-data.js"></script>
  <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	</head>
	<body>
        <div class="header">
            <ul>
                <h1>ECO DRONE</h1>
                <a href="index.php"><li>Home</li></a>
                <a href="sensor_data.php" class="active"><li>Drone Data</li></a>
                <a href="technical_information.html"><li>Technical Information</li></a>
                <a href="extras.html"><li>Extra info and files</li></a>
            </ul>
        </div>
        <div class="contents">
            <div class="centerbox">
                <div id="liveData" style="color: white; height: 50px;" class="boxheader">
                        <h2>Drone Live Data</h2>
                        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                        <div id = 'container' class='container'>
                            <?php
                            include('esp-chart.php')
                            ?>
                        </div>
                </div>
            </div>
        </div>
        <!--<script>
            $(document).ready(function () {
    setInterval(function () {
        $( "#container" ).load("esp-chart.php" );
    }, 3000);
});

        </script>-->
    </body>
</html>