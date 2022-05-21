<?php require_once("./Php functions/switch_lang.php"); ?>
<!DOCTYPE html>
<html>
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
            <div class="centerbox" style="margin: 20px">
                <div class="boxheader">
                    <h1><?php echo $result_lang[24][$lang.'_title']; ?></h1>
                </div>
                <div class="boxcontents" style="display:flex; align-items: center; margin:0px;margin-bottom:10px; flex-wrap: wrap;">
                    <a href="/project/downloads/legislation.docx" download="legislation.docx">
                    <button class="animated_button" style="margin: 0 20px 20px 20px"><?php echo $result_lang[24][$lang.'_description']; ?></button></a>
                    <a href="/project/downloads/drone_info.docx" download="drone_info.docx">
                    <button class="animated_button" style="margin: 0 20px 20px 20px"><?php echo $result_lang[25][$lang.'_title']; ?></button></a>
                    <a href="/project/downloads/block_diagram.jpg" download="block_diagram.jpg">
                    <button class="animated_button" style="margin: 0 20px 20px 20px"><?php echo $result_lang[25][$lang.'_description']; ?></button></a>
                    <a href="/project/downloads/business_canvas.png" download="business_canvas.png">
                    <button class="animated_button" style="margin: 0 20px 20px 20px"><?php echo $result_lang[26][$lang.'_title']; ?></button></a>
                    <a href="/project/downloads/annual_report.docx" download="annual_report.docx">
                    <button class="animated_button" style="margin: 0 20px 20px 20px"><?php echo $result_lang[27][$lang.'_description']; ?></button></a>
                    <a href="#" onclick="subscribe()"><button class="animated_button" style="margin: 0 20px 20px 20px">
                            <?php echo $result_lang[27][$lang.'_title']; ?></button></a>
                    <script>
                        function subscribe() {
                            alert("<?php echo $result_lang[26][$lang.'_description']; ?>");
                        }
                    </script>
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