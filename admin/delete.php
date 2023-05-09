<?php 
	ob_start();
	session_start();
	require_once "../functions/functions.php"; //подключаем глобальные переменные
	if(!valid_session()){
        header('Location: ..');
    }
    if(isset($_POST['p'])){
        $p_get=$_POST['p'];
        if(isset($_POST['id'])){            
            del_row($p_get, $_POST['id']);
            header('Location: ../admin/admin.php?p='.$p_get);
        }
    }
?>