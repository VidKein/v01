<?php 
	ob_start();
	session_start();
	require_once "../functions/functions.php"; //подключаем глобальные переменные
	if(!valid_session()){
        header('Location: ..');//если пользователь не авторизирован возврат назад
	}
?>
<head>
	<title>Admins-<?php echo $_GET['p']; ?></title>
	<!--Подключаем Font awesome 5/Иконки-->
	<link href="/fonts/fontawesome/css/all.min.css" type="text/css" rel="stylesheet">
	<!--Подключаем jquery-3.5.1-->
	<script src="/script/jquery/jquery-3.5.1.min.js"></script>
	<!-- Style -->
	<link rel="stylesheet" href="../css/admin.css">
	<link rel="shortcut icon" href="../img/favicon.png">	
</head>
<body>
	<div class="adminbar">
		<div class="quicklinks">
			<ul class="admin-bar-root-default">
				<li class="admin-bar-site-name"><a href="admin.php?p=Info" class="ab-item" title="Информация о сайте"><?= $_SERVER['SERVER_NAME'];?></a>
					<div class="ab-sub-wrapper-out">
						<ul class="ab-submenu">
							<li class="admin-out"><a href="<?= "http://".$_SERVER['SERVER_NAME'];?>" class="ab-item" title="Перейти на сайт">Перейти на сайт</a></li>
						</ul>
					</div>
				</li>
				<li class="admin-bar-content"><a class="ab-item" title="Редактировать" >Редактировать</a>
					<div class="ab-sub-wrapper-left">
						<ul class="ab-submenu">
							<li class="admin-edit-foto"><a href="admin.php?p=Photos" class="ab-item" title="Фото">Фото</a></li>
							<li class="admin-edit-categorys"><a href="admin.php?p=Categorys" class="ab-item" title="Категории">Категории</a></li>
							<li class="admin-edit-ages"><a href="admin.php?p=Pages" class="ab-item" title="Страницу">Страницу</a></li>
							<li class="admin-edit-users"><a href="admin.php?p=Users" class="ab-item" title="Пользователей">Пользователей</a></li>
							<li class="admin-edit-roles"><a href="admin.php?p=Roles" class="ab-item" title="Администрирование">Аминистрирование</a></li>
							<li class="admin-edit-parameters"><a href="admin.php?p=Parameters" class="ab-item" title="Параметры">Параметры</a></li>
						</ul>
					</div>
				</li>
				<li class="admin-bar-email"><a href="admin.php?p=Email" class="ab-item" title="Почта">Почта<span><?= ALLemail();?></span></a></li>
				<li class="admin-bar-error"><a href="admin.php?p=ErrorLog" class="ab-item" title="Ошибки">Ошибки<span><?= ALLerror();?></span></a></li>
				
			</ul>
			<ul class="admin-bar-top-secondary">
				<li class="admin-bar-my-account"><a class="ab-item" href="admin.php?p=Info" title="Информация о сайте">Привет - <span style="color: #78ABE2;"><?= $_SESSION['nikname']?></span>  /  У вас статус - <span style="color: #78ABE2;"><?=$_SESSION['active'];?><span></a>				
					<div class="ab-sub-wrapper-right">
						<ul class="ab-submenu">
							<li class="admin-edit-profile"><a href="admin.php?p=Profile" class="ab-item" title="Изменить профиль">Изменить профиль</a></li>
							<li class="admin-bar-logout"><a href="/admin/logout.php" class="ab-item" title="Выйти">Выйти</a></li>
						</ul>
					</div>
				</li>
			</ul>
		</div>		
	</div>
	<div class="help">
		<div class="contextual-help-columns">
			<?php
				if (isset($_GET['p'])) {
				$json = file_get_contents($_SERVER['DOCUMENT_ROOT'] ." /help/" . $_GET['p'].".json");
				$text_help = json_decode($json, true);}?>				

			<p><?= $text_help['title'];?></p> 
            <p><?= $text_help['description'];?></p>
		</div>

	</div>
	<div class="screen-meta-links">
		<div id="help_metca" class="wrap-link">
			<button id="show-settings"  class="show-settings">Помощь</button>
		</div>
		
	</div>

	<div class="container">
	<header>
		<h1 style="margin: 5px 0;">Table Manager - '<?php echo $_GET['p'];?>' </h1>
		<!--<p>
        <?php /*admin_menu();*/?>
		</p>-->
		<?php 
		if ($_SESSION['active'] == "Admin") {//Какие кнопки отображать при регистрации Администратора
			if($_GET['p'] !== "Email" && $_GET['p'] !== "ErrorLog" && $_GET['p'] !== "Profile" && $_GET['p'] !== "Info"){
				if($_GET['p'] !== "Photos"){echo '<button><a href="/admin/create.php?p='.$_GET['p'].'">Create '.$_GET['p'].'</a></button>'; 
					}else{echo '<button><a href="/admin/upload.php">Create Photo </a></button>';}
				if($_GET['p'] == "Photos"){echo '<button><a href="/admin/re-write.php">Photo on dir checkout</a></button>';}
			}
		} else {//Какие кнопки отображать при регистрации НЕ администратора
			if($_GET['p'] !== "Email" && $_GET['p'] !== "ErrorLog" && $_GET['p'] !== "Profile" && $_GET['p'] !== "Info"){
				if($_GET['p'] == "Photos") echo '<button><a href="/admin/upload.php">Create Photo </a></button><button><a href="/admin/re-write.php">Photo on dir checkout</a></button>'; 
				if($_GET['p'] !== "Photos" && $_GET['p'] !== "Users" && $_GET['p'] !== "Roles" && $_GET['p'] !== "Parameters" && $_GET['p'] !== "Info")
				{echo '<button><a href="/admin/create.php?p='.$_GET['p'].'">Create '.$_GET['p'].'</a></button>';}
			}
		}			
		?>
		<hr>
	</header>

	<?php 
		  if(isset($_GET['p']) && $_GET['p'] == 'Info') {list_info();}
		  if(isset($_GET['p']) && $_GET['p'] == 'Profile') {list_profile();}
		  if(isset($_GET['p']) && $_GET['p'] !== 'Profile' && $_GET['p'] !== 'Info'){admin_view_list();}
    ?>
	</div>
 	<!-- Подключаем скрипты tableManager/таблицы-->
	<script type="text/javascript" src="../script/tableManager/tableManager.js"></script>
	<script type="text/javascript">
		// basic usage
		$('.tablemanager').tablemanager({
			firstSort: [3,0],//с какого столбца начинаем сортировку/по убыванию или возрастанию 
			disable: [2],//какой сталбец отключаем от сортировки
			appendFilterby: true,//подключение фильтра для фильтрации отображения
			dateFormat: [[4,"mm-dd-yyyy"]],//используется для обозначения столбца и формата даты
			debug: true,
			vocabulary: {//для перевода этикеток на названий поиска
		voc_filter_by: 'Filter By',
		voc_type_here_filter: 'Filter...',
		voc_show_rows: 'Rows Per Page'
		},
			pagination: true,// Это позволяет разбивать таблицу на страницы и добавлять контроллеры под таблицей
			showrows: [5,10,20,50,100],// количество отображаемых строк
			disableFilterBy: [1]// используется для отключения фильтра по определенным столбцам
		});
	</script>
	<!--Подключаем библиотеку JS-->
	<script>
		try {
		fetch(new Request("https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js", { method: 'HEAD', mode: 'no-cors' })).then(function(response) {
			return true;
		}).catch(function(e) {
			var carbonScript = document.createElement("script");
			carbonScript.src = "//cdn.carbonads.com/carbon.js?serve=CK7DKKQU&placement=wwwjqueryscriptnet";
			carbonScript.id = "_carbonads_js";
			document.getElementById("carbon-block").appendChild(carbonScript);
		});
		} catch (error) {
		console.log(error);
		}
	</script>
	<!--Подключение Google Analytics - это бесплатная служба веб-аналитики, которая отслеживает и сообщает о посещаемости веб-сайтов.-->
	<script type="text/javascript">

		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-36251023-1']);
		_gaq.push(['_setDomainName', 'jqueryscript.net']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();

	</script>
	<!--Плагин lazy_load - предзагрузка картинок в видимую зону-->
    <script src="/script/lazy_load/lazy-load.js"></script>
	<!--Скрипт анимации страницы--> 
	<script src="/script/anime/anime.js"></script>
</body>