<?php 
	ob_start();
	session_start();
	require_once "../functions/functions.php"; //подключаем глобальные переменные
	if(!valid_session()){
        header('Location: ..');
    }
    if(isset($_POST['p'])){
        if(isset($_POST['id'])){
            if(isset($_POST['act'])){
                folder_act($_POST['p'], $_POST['id'], $_POST['act']);
                header('Location: ../admin/admin.php?p='.$_POST['p']);
            }
        }
    }
?>