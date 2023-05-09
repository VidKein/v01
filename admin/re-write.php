<?php 
	ob_start();
	session_start();
	require_once "../functions/functions.php"; //подключаем глобальные переменные
	if(!valid_session()){
        header('Location: ..');
    }
    $p_get = "Photos";
?>
<title>Admins Re-Write Photos</title>
	<!--Подключаем Font awesome 5/Иконки-->
    <link href="/fonts/fontawesome/css/all.min.css" type="text/css" rel="stylesheet">
	<!--Подключаем jquery-3.5.1-->
	<script src="/script/jquery/jquery-3.5.1.min.js"></script>
    <!-- Style -->
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="shortcut icon" href="../img/favicon.png">	
</head>
<body>
	<div class="container">
        <header>
            <h1>Added blank photo row to DB, if path not in no one row photos </h1>
            <p>
            <?php admin_menu(); ?>
            </p>
            
            <?php echo '<button><a href="/admin/admin.php?p='.$p_get.'">Go Back '.$p_get.'</a></button>'; ?>
            <hr>
        </header>

            <?php 
                re_write();
            ?>
        <hr>
    </div>
</body>