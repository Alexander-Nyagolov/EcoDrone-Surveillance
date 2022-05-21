<?php require_once("./Php functions/switch_lang.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
        <title>EcoDrone Surveillance</title>
  		<link rel="shortcut icon" href="/project/images/favicon.ico" type="image/x-icon">
        <link rel='stylesheet' href=/project/css/style.css?v=1553116856>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
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
            <div class="centerbox" style="align-items: center; display:block;margin: 20px 3%;">
                <div class="boxheader">
                    <h1 style="font-size: 200%; margin: 0px;"><?php echo $result_lang[2][$lang.'_title']; ?></h1>
                </div>
                <div class = "boxcontents">
                     <div class = "boxlist">
                        <img src="project/images/eco_drone_picture_1.jpg" style="margin: 0px auto;float:left; width:600px; height: 310px;">
                        <div class="textlimit">
                            <p style = "margin:0px;font-size: 17pt;"><?php echo $result_lang[22][$lang.'_description']; ?></p>
                        </div>
                        <img src="project/images/eco_drone_picture_2.jpg" style="margin: 0px auto;float:right; width:600px; height: 310px;">
                        <img src="project/images/drone_transparent.png" style="width:620px; height: 510px;">
                    </div>
                </div>
                <div class="boxheader">
                    <h1 style="font-size: 200%; margin: 0px;"><?php echo $result_lang[22][$lang.'_title']; ?></h1>
                </div>
                    <div class="boxcontents" style="margin-top: 10px; margin: auto">
                        <video width="1020" height="600" controls>
                        <source src="project/images/eco_drone_video.mp4" type="video/mp4">
                        <source src="vid.ogg" type="video/ogg">
                        <strong><h3 style="color: white"><?php echo $result_lang[23][$lang.'_title']; ?></h3></strong>
                        </video>
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
    </body>
</html>