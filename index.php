<!DOCTYPE html>
<html>
 
	<head>
        <title>EcoDrone Surveillance</title>
  		<link rel="shortcut icon" href="/project/images/favicon.ico" type="image/x-icon">
        <link rel='stylesheet' href=/project/style.css?v=1553116856>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
        </script>
        <script src = "https://code.highcharts.com/highcharts.js"></script>
        <script src = "https://code.highcharts.com/highcharts-more.js"></script>
	</head>
	<body>
        <div class="header">
        <ul>
            <div class="header_space"></div>
            <h1>ECO DRONE</h1>
            <a href="index.php" class="active"><li>Начална страница</li></a>
            <a href="sensor_data.php" ><li>Качество на въздуха</li></a>
            <a href="technical_information.html"><li>Техническа Информация</li></a>
            <a href="extras.html"><li>Допълнителна Информация</li></a>
        </ul>
        </div>
        <div class="enclosing">
        <div class="contents">
            <div class="centerbox">
                <div class="boxcontents">
                    <div class="boxheader" style="margin-top:0px;">
                    <h1>Качество на въздуха:</h1>
                    </div>
                         <div id = "container" style = "width: 600px; height: 500px; margin: 0 auto; border-radius: 20% 20% 20% 20%;"></div>
                    <a href="sensor_data.php"><button class="animated_button">Подробна информация</button></a>
                </div>
                <br>
            </div>
            <div class="centerbox" style="margin-top:10px">
                <div class="boxheader">
                <h2>Нашата цел:</h2>
                </div>
                <div class="boxcontents">
                    
                    <p style="font-size:30px;">
                        EcoDrone Surveillance е компания, чиято цел е чрез своите продукти и услуги да спомогне за превенцията и намаляването на замърсяването на въздуха, като по този начин подобри цялостното благосъстояние на околната среда.
                    </p>
                    <br>
                </div>
                <div class="boxcontents">
                    <div class="boxheader">
                        <h2>Нашият Екип:</h2>
                    </div>
                    <div class="boxlist">
                            <div class="img-cell">
                                <div class="gallery">
                                    <div class="circular--landscape">
                                        <img src="project/images/profile_alex.jpg"/>
                                    </div>
                                    <div class="desc">
                                    <p>
                                         Име: Александър Няголов<br>
                                         Роля: Мениджър, инженер и разработчик
                                    </p>
                                    </div>
                                </div>
                            </div>
                            <div class="img-cell">
                                <div class="gallery">
                                    <div class="circular--landscape">
                                        <img src="project/images/profile_ivona-crop.jpg" style="width:360px; height:460px"/>
                                    </div>
                                    <div class="desc">
                                    <p>
                                         Име: Ивона Николаева<br>
                                         Роля: Финансов мениджър 
                                    </p>
                                    </div>
                                </div>
                            </div>
                            <div class="img-cell">
                                <div class="gallery">
                                    <div class="circular--landscape">
                                        <img src="project/images/profile_ivo-crop.jpg" style="width:410px; height:440px;"/>
                                    </div>
                                    <div class="desc">
                                    <p>
                                         Име: Ивайло Банчев<br>
                                         Роля: Маркетингов мениджър, компютърен дизайн
                                    </p>
                                    </div>
                                </div>
                            </div>
                            <div class="img-cell">
                                <div class="gallery">
                                    <div class="circular--landscape">
                                        <img src="project/images/profile_roko.jpg"/>
                                    </div>
                                    <div class="desc">
                                    <p>
                                         Име: Ростислав Гордеев<br>
                                         Роля: Софтуерен разработчик и технически инспектор
                                    </p>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    <script>
function Save(result){
    var voc = result;
  	let values = result.split(', ');
    var calc = parseFloat(values[values.length - 15]);
    var last = parseFloat(calc);
  //alert(result);
    $(document).ready(function() {
          var valText;
          if(last == 0.5)
		   {
			valText = "Чисто";
		   }
      	   else if(last == 0)
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
               text: 'Ниво на замърсяване'
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
      setInterval(function ( ) {
			var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    result = this.responseText;
                    Save(result);
                }
            };
            xmlhttp.open("GET", "get-data.php", true);
            xmlhttp.send();
		}, 3000 ) ;
    </script>
        </div>
    </body>
</html>	