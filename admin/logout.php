<?php
   ob_start();
   session_start();
   //data to connect db
   require_once "../functions/config.php";
   $id = $_SESSION['id'];
   //last login
   $lastlogin = $_SESSION['lastlogin'];
   //exit login
   $exitlogin = date("Y-m-d H:i:s");   
   //отправляем в Б/Д
   mysqli_query($con,"UPDATE kv_users SET lastlogin = '$lastlogin' WHERE id = '$id'");
   mysqli_query($con,"UPDATE kv_users SET lastexit = '$exitlogin' WHERE id = '$id'");
   /* закрываем подключение */
   mysqli_close($con);   
   //Очишаем все сесии 
   $_SESSION = array(); //Удаляем все переменные сессии.
   // Замечание: Это уничтожит сессию, а не только данные сессии!
   if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000,
         $params["path"], $params["domain"],
         $params["secure"], $params["httponly"]
      );
   }
   session_destroy(); // Наконец, уничтожаем сессию.
   //возврашаемся на главную страницу
   header("Location: http://".$_SERVER['SERVER_NAME']);    
?>