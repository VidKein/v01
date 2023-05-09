<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width" initial-scale=1.0>
	<title><?php require_once $location_serv."functions/vars.php";
	echo help_vars($array_settings,'text_title_site');?></title>
	<!--Full info-https://ogp.me/ -->
    <!--Open Graph property -->
	<meta property="og:type" content="website"><!--тип добавляемого материала - ОСНОВНОЙ / type of added material - BASIC-->
    <meta property="og:site_name" content="Photographer Constantin Vidyuschenko"><!--название сайта - ДОПОЛНИТЕЛЬНЫЙ / site name - ADDITIONAL-->
	<meta property="og:url" content=""><!--ссылка на саму веб-страницу, которая добавляется в социальную сеть - ОСНОВНОЙ / link to the web page itself, which is added to the social network - BASIC-->
    <meta property="og:locale" content="ru_UA"><!--язык сайта - ДОПОЛНИТЕЛЬНЫЙ / site language - ADDITIONAL-->
    <meta property="og:locale:alternate" content="en_UA">
    <meta property="og:locale:alternate" content="ua_UA">
    <!--Open Graph property Twitter-->
    <meta name="twitter:creator" content="@vidyuschenko"><!--ник канала - ОСНОВНОЙ / channel nickname - BASIC-->
    <meta name="twitter:card" content="summary_large_image"><!--тип карточки «summary» - ОСНОВНОЙ / type of card «summary» - BASIC-->
    <meta property="twitter:image:src" content=""><!--ссылка на картинку, которая должна сопровождать материал-->
    <!--END Open Graph property Twitter-->
    <meta property="og:title" content="Constantin Vidyuschenko: Travel Photographer"><!--название материала - ОСНОВНОЙ / name of material - BASIC-->
    <meta property="og:description" content="With the advent of the camera in my life, I began to regularly and frantically collect and multiply my PHOTO ALBUM. With pleasure and inspiration, I was in constant search of various directions in photography."><!--описание материала - по желанию / material description -optional-->
    <meta property="og:image" content=""><!--ссылка на картинку, которая должна сопровождать материал - ОСНОВНОЙ / link to a picture that should accompany the material - BASIC-->
    <!--Рекомендации по размеру изображения - https://habr.com/ru/post/278459/ -->
    <meta property="og:image:width" content=""><!--размеры изображения - ускоряет скраппинг / image sizes - speeds up scraping-->
    <meta property="og:image:height" content="">
	<!--Подтверждение сайта на pinterest ДОДЕЛАТЬ!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
    <meta name="p:domain_verify" content="195f5691c1a4bbe76f604ec9506c0a4b"/>
	<!--Начальные параметры МЕТА-->
	<script>
		//вычитываем домен
		var origin_web = window.origin;
		//адрес сайта
		document.querySelector('meta[property="og:url"]').setAttribute("content", origin_web);
		//основная картинка сайта
		document.querySelector('meta[property="twitter:image:src"]').setAttribute("content", origin_web + "/img/aboyt/fox.jpg");
		document.querySelector('meta[property="og:image"]').setAttribute("content", origin_web + "/img/aboyt/fox.jpg");
		//Размер картинки в соц сетях
		var img_new = new Image();
			img_new.onload = function() {
				var width_img = this.width;
				var height_img = this.height;
				document.querySelector('meta[property="og:image:width"]').setAttribute("content", width_img);
				document.querySelector('meta[property="og:image:height"]').setAttribute("content", height_img);
			}
			img_new.src = origin_web +'/img/aboyt/fox.jpg';
	</script>	
	<!--моя иконка-->
	<link rel="shortcut icon" href="img/favicon.png">
	<!--рабочие стили страницы-->
	<link rel="stylesheet" href="css/css.css">
	<!--стили плагина wookmark-->
	<link rel="stylesheet" href="css/main.css">
	<!--Шрифты googleapis-->
	<link href="https://fonts.googleapis.com/css?family=Roboto:700&display=swap&subset=cyrillic-ext" rel="stylesheet">
	<!--Подключаем Font awesome 5/Иконки-->
	<link href="/fonts/fontawesome/css/all.min.css" type="text/css" rel="stylesheet">
	<!--Подключаем jquery-3.5.1/анимация кнопок/возможность войти в админку использывая камбинацию клавиш-->
	<script src="/script/jquery/jquery-3.5.1.min.js"></script>
	<!--Плагин lazy_load - предзагрузка картинок в видимую зону-->
	<script src="script/lazy_load/lazy-load.js"></script>
</head>
<body>
<!--Вся страница-->
<div class="wrapper">
        <header><?php require_once $location_serv."top.php"; //подкл верх ?></header>
		<nav><?php require_once $location_serv."nav.php"; // подкл навигацию?></nav>
		<aside>
				<?php 
					//определяем входные параметры
					if(isset($_GET['page'])) $page = $_GET['page'];
						else $page = null;
					if(isset($_GET['categories'])) $categories = $_GET['categories'];
						else $categories = null;
					if(isset($_GET['photo'])) $photo = $_GET['photo'];
						else $photo = null;	
					//Переход на страницы	
					if($page == null) 
						if($categories == null) 
						require_once $location_serv."pages/main.php"; //выводим галерею при index загрузке								
					if($page == "gallery") 
							if($categories > 0 || $categories == 'all') 
							require_once $location_serv."pages/main.php"; //выводим галерею при нажатии на кнопки
					//выводим страницы Обо мне/Контакт/copyright
					$res = list_data('kv_pages');//вычитываем информацию из БД
					while($row = mysqli_fetch_assoc($res)) {//составляем массив
						$pages = $row["code"];//вычитываем код запроса
						if($page == $pages) require_once $location_serv."pages/detailPage.php"; 
						}
					if($photo >= 1) require_once $location_serv."pages/slider.php"; // выводим слайды категории
				?>
		</aside> 
		<scroll><?php require_once $location_serv."scroll.php"; //подкл скролинг ?></scroll>
</div>
<!--Обрабатываем нажатие клавиш ctrl+shift(left) для перехода на страницу АДМИН.-->
<script>
	    var origin_web = window.origin;//вычитываем домен
		var isCtrl = false;
		$(document).keyup(function (e) {//отжатие клавиши на клавиатуре (условие срабатывает после отжатия клавиши)
		if(e.which == 17) isCtrl=false;}).keydown(function (e) {//нажатие клавиши на клавиатуре			
			if(e.which == 17) isCtrl=true;//при нажатии ctrl(17) isCtrl истина
			if(e.which == 192 && isCtrl == true) {//если нажаты клавиши ctrl + `
				document.location.replace(origin_web + "/admin/login.php");}			
			});

</script>
</body>
</html>