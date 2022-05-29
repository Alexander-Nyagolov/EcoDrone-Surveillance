<?php require_once("./Php functions/switch_lang.php"); ?>
<!DOCTYPE html>
<html>
	<head>
        <title>EcoDrone Surveillance</title>
  		<link rel="shortcut icon" href="/project/images/favicon.ico" type="image/x-icon">
        <link rel='stylesheet' href=/project/css/style.css?v=1553116856>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src = "https://code.highcharts.com/highcharts.js"></script>
        <script src = "https://code.highcharts.com/highcharts-more.js"></script>
        <link href='project/css/phppot-style.css' rel='stylesheet' type='text/css' />
        <link href='project/css/multi-lingual-page.css' rel='stylesheet' type='text/css' />
	</head>
	<body>
    <?php
      if (! empty($result_lang)) {
      //foreach ($result_lang as $k => $v) {
    ?>
        <div class="header">
            <ul>
                <div class="header_space"></div>
                <h1>ECO DRONE</h1>
                <a href="index.php" class="active"><li><?php echo $result_lang[0][$lang.'_title']; ?></li></a>
                <a href="sensor_data.php" ><li><?php echo $result_lang[1][$lang.'_title']; ?></li></a>
                <a href="technical_information.php"><li><?php echo $result_lang[2][$lang.'_title']; ?></li></a>
                <a href="extras.php"><li><?php echo $result_lang[3][$lang.'_title']; ?></li></a>
            </ul>
        </div>

        <nav>
            <div class="logo">
                 <!--This provides space-->
            </div>
            <div class="lang-menu">
                <div class="selected-lang <?php echo $lang?>">
                    <?php echo $selection;?>
                </div>
                <ul>
                    <li>
                         <a class="bg language-link-item" href="<?=$page?>?lang=bg"
                        <?php if($lang == 'bg'){?> style="color: #ff9900;"
                        <?php } ?>>Български</a>
                    </li>
                    <li>
                        <a class="de language-link-item" href="<?=$page?>?lang=de"
                        <?php if($lang == 'de'){?> style="color: #ff9900;"
                        <?php } ?>>Deutsch</a>
                    </li>
                    <li>
                        <a class="ru language-link-item" href="<?=$page?>?lang=ru"
                        <?php if($lang == 'ru'){?> style="color: #ff9900;"
                        <?php } ?>>Руский</a>
                    </li>
                    <li>
                        <a class="en language-link-item" href="<?=$page?>?lang=en"
                        <?php if($lang == 'en'){?> style="color: #ff9900;"
                        <?php } ?>>English</a>
                    </li>
                </ul>

            </div>
        </nav>
        <div class="enclosing">
        <div class="contents">
            <div class="centerbox">
                <div class="boxcontents">
                    <div class="boxheader" style="margin-top:0px;">
                    <h1><?php echo $result_lang[1][$lang.'_title']; ?>:</h1>
                    </div>
                         <div class="container index" id="container"></div>
                    <a href="sensor_data.php"><button class="animated_button"><?php echo $result_lang[3][$lang.'_title']; ?></button></a>
                </div>
                <br>
            </div>
            <div class="centerbox" style="margin-top:10px">
                <div class="boxheader">
                <h2><?php echo $result_lang[4][$lang.'_title']; ?>:</h2>
                </div>
                <div class="boxcontents">
                    <p style="font-size:30px;">
                        <?php echo $result_lang[4][$lang.'_description']; ?>
                    </p>
                    <br>
                    <?php
                        //}
                    } else {
                        ?>
                    <div class="no-result"><?php echo $language["NOTIFY_NO_RESULT"]; ?></div>
                    <?php
                    }
                    ?>
                </div>
                <div class="boxcontents">
                    <div class="boxheader">
                        <h2><?php echo $result_lang[9][$lang.'_title']; ?>:</h2>
                    </div>
                    <div class="boxlist">
                            <div class="img-cell">
                                <div class="gallery">
                                    <div class="circular--landscape">
                                        <img src="project/images/profile_alex.jpg"/>
                                    </div>
                                    <div class="desc">
                                    <p>
                                         <?php echo $result_lang[5][$lang.'_title']; ?><br>
                                         <?php echo $result_lang[5][$lang.'_description']; ?>
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
                                         <?php echo $result_lang[6][$lang.'_title']; ?><br>
                                         <?php echo $result_lang[6][$lang.'_description']; ?>
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
                                         <?php echo $result_lang[7][$lang.'_title']; ?><br>
                                         <?php echo $result_lang[7][$lang.'_description']; ?>
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
                                         <?php echo $result_lang[8][$lang.'_title']; ?><br>
                                         <?php echo $result_lang[8][$lang.'_description']; ?>
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
			valText = "<?php echo $result_lang[11][$lang.'_description']; ?>";
		   }
      	   else if(last == 0)
		   {
			valText = "<?php echo $result_lang[11][$lang.'_description']; ?>";
		   }
		   else if(last == 1.5)
		   {
			valText = "<?php echo $result_lang[12][$lang.'_description']; ?>";
		   }
		   else if(last == 2.5)
		   {
			valText = "<?php echo $result_lang[13][$lang.'_description']; ?>";
		   }
		   else if(last == 3.5)
		   {
			valText = "<?php echo $result_lang[14][$lang.'_description']; ?>";
		   }
            var chart = {
               type: 'gauge',
               plotBackgroundColor: null,
               plotBackgroundImage: null,
               plotBorderWidth: 0,
               plotShadow: false
            };
            var title = {
               text: '<?php echo $result_lang[10][$lang.'_title']; ?>'
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
                  text: '<?php echo $result_lang[11][$lang.'_title']; ?>: ' + valText
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
               name: '<?php echo $result_lang[15][$lang.'_title']; ?>',
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
            xmlhttp.open("GET", "./retrieve-data/get-data.php", true);
            xmlhttp.send();
		}, 3000 ) ;
    </script>
        </div>
    </body>
</html>