<?php 
	ob_start();
	session_start();
	require_once "../functions/functions.php"; //подключаем глобальные переменные
	if((!valid_session())&&($_SESSION['active'] != "Admin")){
        header('Location: ..');
    }
    $p_get = "ControlPhotos";
?>

<title>Admin Temp Folder <?php echo $_GET['p']; ?></title>
	<!--Подключаем Font awesome 5/Иконки-->
	<link href="/fonts/fontawesome/css/all.min.css" type="text/css" rel="stylesheet">
	<!--Подключаем jquery-3.5.1-->
	<script src="/script/jquery/jquery-3.5.1.min.js"></script>
    <!-- Style -->
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/create.css">
    <link rel="shortcut icon" href="../img/favicon.png">	
</head>
<body>
	<div class="container">
        <header>
            <h1>Admin Temp Folder - '<?php echo $p_get;?>' </h1>
            <!--<p>
            <?php /*admin_menu();*/ ?>
            </p>-->
            
            <?php echo '<button><a href="/admin/admin.php?p='.$p_get.'">Go Back '.$p_get.'</a></button>'; ?>
            <?php echo '<button><a href="#">Clean Folder</a></button>'; ?>
            <hr>
        </header>

        <?php
            list_temp_folder();
        ?>
        <hr>
    </div>
</body>