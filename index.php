<!DOCTYPE html>
<html>
 
	<head>
        <title>Eco Drone official website</title>
        <link rel="stylesheet" href="project/style.css">
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
      </script>
      <script src = "https://code.highcharts.com/highcharts.js"></script>
      <script src = "https://code.highcharts.com/highcharts-more.js"></script>
	</head>
	<body>
        <div class="header">
            <ul>
                <h1>ECO DRONE</h1>
                <a href="index.php" class="active"><li>Home</li></a>
                <a href="sensor_data.php"><li>Drone Data</li></a>
                <a href="technical_information.html"><li>Technical Information</li></a>
                <a href="extras.html"><li>Extra info and files</li></a>
            </ul>
        </div>
        <div class="contents">
            <div class="centerbox">
                <div class="boxheader">
                    
                </div>
                <div class="boxcontents">
                    <h2>Our Mission:</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <br>
                    <h1>Качество на въздуха:</h1>
                         <div id = "container" style = "width: 550px; height: 400px; margin: 0 auto"></div>
                    <h>Active data from drone:</h><br>
                    <a href="sensor_data.php"><button class="animated_button">Look at data</button></a>
                </div>
                <br>
            </div>
            <div class="centerbox" style="margin-top:10px">
                <div class="boxcontents">
                    <h2>Our Team:</h2>
                    <div class="boxlist">
                            <div class="gallery">
                                <div class="circular--landscape">
                                    <img src="profile_alex.jpg"/>
                                </div>
                                <div class="desc">
                                     Име: Александър Няголов<br>
                                     Роля: Главен инженер, програмист и мениджър на екипа
                                </div class="desc">
                            </div>
                            <div class="gallery">
                                <div class="circular--landscape">
                                    <img src="profile_alex.jpg"/>
                                </div>
                                <div class="desc">
                                     Име: Ивона Николаева<br>
                                     Роля: Главен финансов анализатор и юрисконсулт
                                </div class="desc">
                            </div>
                            <div class="gallery">
                                <div class="circular--landscape">
                                    <img src="profile_alex.jpg"/>
                                </div>
                                <div class="desc">
                                     Име: Ивайло Банчев<br>
                                     Роля: Главен дизайнер, компютърен аниматор
                                </div class="desc">
                            </div>
                            <div class="gallery">
                                <div class="circular--landscape">
                                    <img src="profile_alex.jpg"/>
                                </div>
                                <div class="desc">
                                     Име: Ростислав Гордеев<br>
                                     Роля: Главен разработчик, технически инспектор
                                </div class="desc">
                            </div>
                    </div>
                </div>
            </div>
        </div>
    <script>
var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    result = this.responseText;
                    Save(result);
                }
            };
            xmlhttp.open("GET", "get-data.php", true);
            xmlhttp.send();

function Save(result){
    var voc = result;
     var calc = voc[voc.length - 4]+'.'+voc[voc.length - 2];
     var last = parseFloat(calc);
    $(document).ready(function() {
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
               text: 'Air Quality Meter'
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
}
    </script>
    </body>
</html>	