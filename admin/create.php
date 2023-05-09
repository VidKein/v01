<?php 
	ob_start();
	session_start();
	require_once "../functions/functions.php"; //подключаем глобальные переменные
	if(!valid_session()){
        header('Location: ..');
    }
    if(isset($_GET['p'])) {
        $p_get=$_GET['p'];
    }
    if(isset($_POST['p'])){
        $p_get=$_POST['p'];
    } 
    if(!isset($_POST['p'])&&!isset($_GET['p'])){
        $p_get='Photos';
    }
    if(isset($_POST['url_500'])){
        $url_500_post=$_POST['url_500'];
    } 
    if(isset($_POST['url_1200'])){
        $url_1200_post=$_POST['url_1200'];
        } 
;
?>
<title>Admins Create New <?php echo $_GET['p']; ?></title>
	<!--Подключаем Font awesome 5/Иконки-->
	<link href="/fonts/fontawesome/css/all.min.css" type="text/css" rel="stylesheet">
	<!--Подключаем jquery-3.5.1-->
	<script src="/script/jquery/jquery-3.5.1.min.js"></script>
    <!-- Скрипт с анимацией -->
    <script src="/script/anime/anime.js"></script>
    <!-- Style -->
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/create.css">
    <link rel="shortcut icon" href="../img/favicon.png">	
</head>
<body>
	<div class="container">
        <header>
            <h1>Create New - '<?php echo $p_get;?>' </h1>
            <p>
            <?php admin_menu(); ?>
            </p>
            
            <?php echo '<button><a href="/admin/admin.php?p='.$p_get.'">Go Back '.$p_get.'</a></button>'; ?>
            <hr>
        </header>

            <?php 
                if(isset($_POST['url_500']) && isset($_POST['url_1200'])){
                    if($_POST['p'] == "Photos"){
                        create_new_photo($_POST['p'], $_POST['url_500'], $_POST['url_1200']);
                    }
                }
                else {
                    if(isset($_POST['p'])){
                        create_data_row($_POST['p'],$_POST['name'],$_POST['description'],$_POST['section_code'],  
                        $_POST['location'], $_POST['code'],$_POST['photopage_500'], $_POST['photopage_1200'],
                        $_POST['access'], $_POST['comment'],
                        $_POST['ru'], $_POST['ua'],$_POST['en'],
                        $_POST['login'], $_POST['password'],$_POST['nik'],$_POST['role'],$_POST['email'],
                        $_POST['short'],$_POST['category']);
                    } else create_obj($p_get);
                }
            ?>
        <hr>
    </div>
<!-- Проверка на валидность введеного Password -->
<?php
if ($_GET['p'] == 'Users') {
    echo'<script src="/script/anime/passGeneration.js"></script>';}
?>
</body>