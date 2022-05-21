<?php require_once("./Php functions/switch_lang.php"); ?>
<!DOCTYPE html>
<html>
<head>
<title>Eco Drone Official Website</title>
    <link rel="shortcut icon" href="/project/images/favicon.ico" type="image/x-icon">
    <link rel='stylesheet' href=/project/css/style.css?v=1553116856>
    <link href='/project/css/phppot-style.css' rel='stylesheet' type='text/css' />
    <link href='/project/css/multi-lingual-page.css' rel='stylesheet' type='text/css' />
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <script src = "https://code.highcharts.com/highcharts.js"></script>
    <script src = "https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/stock/modules/export-data.js"></script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<body>
<?php
if (! empty($result_lang)) {
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
    <div class="contents">
        <div class="centerbox">
            <div class="boxheader" style="color:white; height:50px; margin:auto">
                <h2><?= $result_lang[17][$lang.'_title']; ?></h2>
            </div>
                <div class="centerbox-back" style="height:0px">
                    <div class="lds-ring-center">
                        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                    </div>
                </div>
            <div id = 'container' class='container'>
                <?php include('./retrieve-data/esp-chart.php'); ?>
            </div>
        </div>       
     </div>
    <?php
    } else {
    ?>
    <div class="no-result"><?php echo $language["NOTIFY_NO_RESULT"]; ?></div>
    <?php
    }
    ?>
        <!--<script>
            $(document).ready(function () {
            setInterval(function () {
                $( "#container" ).load("esp-chart.php" );
            }, 3000);
        });

        </script>-->
</body>
</html>
