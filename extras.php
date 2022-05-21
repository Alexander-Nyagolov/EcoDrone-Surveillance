<!DOCTYPE html>
<html>
<head>
        <title>EcoDrone Surveillance</title>
  		<link rel="shortcut icon" href="/project/images/favicon.ico" type="image/x-icon">
        <link rel='stylesheet' href=/project/css/style.css?v=1553116856>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
	</head>
	<body>
        <div class="header">
            <ul>
                <h1>ECO DRONE</h1>
                <a href="index.php"><li>Начална страница</li></a>
                <a href="sensor_data.php"><li>Качество на въздуха</li></a>
                <a href="technical_information.php"><li>Техническа Информация</li></a>
                <a href="extras.html" class="active"><li>Допълнителна Информация</li></a>
            </ul>
        </div>
        <div class="contents">
            <div class="centerbox" style="margin: 20px">
                <div class="boxheader">
                    <h1>Допълнителни снимки и файлове:</h1>
                </div>
                <div class="boxcontents" style="display:flex; align-items: center; margin:0px;margin-bottom:10px; flex-wrap: wrap;">
                    <a href="/project/downloads/legislation.docx" download="legislation.docx"><button class="animated_button" style="margin: 0 20px 20px 20px">Легализация</button></a>
                    <a href="/project/downloads/drone_info.docx" download="drone_info.docx"><button class="animated_button" style="margin: 0 20px 20px 20px">Информация за дрон</button></a>
                    <a href="/project/downloads/block_diagram.jpg" download="block_diagram.jpg"><button class="animated_button" style="margin: 0 20px 20px 20px">Блок схема</button></a>
                    <a href="/project/downloads/activities.png" download="activities.png"><button class="animated_button" style="margin: 0 20px 20px 20px">Бизнес схема</button></a>
                    <a href="/project/downloads/summary.docx" download="summary.docx"><button class="animated_button" style="margin: 0 20px 20px 20px">Междинен отчет</button></a>
                    <a href="#" onclick="subscribe()"><button class="animated_button" style="margin: 0 20px 20px 20px">Иформация от дрона</button></a>
                    <script>
                        function subscribe() {
                            alert("Вие не сте абонат! За да изтеглите информацията, моля свържете се с нас!");
                        }
                    </script>
                </div>
             </div>
        </div>
    </body>
</html>