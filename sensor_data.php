<!DOCTYPE html>
<html lang="en">
<head>
	<title>EcoDrone Surveillance</title>
  	<link rel="shortcut icon" href="/project/images/favicon.ico" type="image/x-icon">
    <link rel='stylesheet' href=/project/css/style.css?v=1553116856>
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
            <a href="index.php"><li>Начална страница</li></a>
            <a href="sensor_data.php" class="active"><li>Качество на въздуха</li></a>
            <a href="technical_information.html"><li>Техническа Информация</li></a>
            <a href="extras.html"><li>Допълнителна Информация</li></a>
        </ul>
    </div>
    <div class="contents">
        <div class="centerbox">
            <div class="boxheader" style="color:white; height:50px; margin:auto">
                <h2>Подробна Информация</h2>   
            </div>
                <div class="centerbox-back" style="height:0px">
                    <div class="lds-ring-center">
                        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                    </div>
                </div>
            <div id = 'container' class='container'>
                <?php
                try{
                include('esp-chart.php');
                }
                catch(Error $e)
                {
                    //WARNING CLEAR-UP
                }
                ?>
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