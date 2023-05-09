<?php
   ob_start();
   session_start();
   require_once("../functions/functions.php");
   if(valid_session()){
      header('Location: ../admin/admin.php?p=Info');//если пользователь авторизирован переходим на страницу Информация
   };
?>

<html lang = "en">
   
   <head>
      <title>login to admin</title>
      <!--Подключаем Font awesome 5/Иконки-->
	   <link href="/fonts/fontawesome/css/all.min.css" type="text/css" rel="stylesheet">
      <!--Подключаем jquery-3.5.1-->
	   <script src="/script/jquery/jquery-3.5.1.min.js"></script>
      <!-- Скрипт с анимацией -->
      <script src="/script/anime/anime.js"></script>
      <link rel="shortcut icon" href="../img/favicon.png">
      <link rel="stylesheet" href="../css/login.css">
   </head>
	
   <body>
      
      <div class="login">
         <div class="login_img"></div>
         <h1>Админ панель сайта</h1>          
            <?php
               if (isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) 
                  && !empty($_POST['password'])) {
                     $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING); // защита от XSS
                     $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING); // защита от XSS
                     if($_SERVER["REQUEST_METHOD"] == "POST") {
                        // username and password sent from form 
                        $error = login($username, $password);                        
                     }                  
               }
            ?>
    
         <div class = "container">            
            <?php
            if (isset($_POST['username']) && isset($_POST['password'])){            
               if (!empty($username) && !empty($password)){                
                  //счетчик сесии меньше 3 раз
                  $count = $_SESSION['count'];
                  if ($count < 3) {
                     if (!isset($_SESSION['count'])) $_SESSION['count'] = 0;
                     $_SESSION['count'] = $_SESSION['count'] + 1;
                  }else{ 
                     //Перенапрявляем на другую страницу
                     header("location: http://v01");
                     //Удаляем переменные сесси для текушего сценария
                     $_SESSION = [];
                     // Замечание: Это уничтожит сессию, а не только данные сессии!
                     if (ini_get("session.use_cookies")) {
                        $params = session_get_cookie_params();
                        setcookie(session_name(), '', time() - 42000,
                           $params["path"], $params["domain"],
                           $params["secure"], $params["httponly"]
                        );
                     }
                     // Наконец, уничтожаем сессию.
                     session_destroy();}                  
                  echo "<div class ='login_error'><strong>Ошибка: </strong>".$error."<span> Вы вошли - ".$_SESSION['count']."</span> раз(а) </div>";
               }else{echo "<div class ='login_error'><strong>Ошибка: </strong>Ни одно из поля не заполнено.<span></div>";}
            }
                  ?>

            <form class = "form-signin" role = "form" action = "login.php" method = "post">
               <p>
                  <label for="username">Имя пользователя</label>
                  <input type = "text" class = "form-controlName" name = "username">
               </p>
               <label for="wrapPass">Пароль</label>
               <div class="wrapPass">
                  <input type = "password" class = "form-controlPassword" name = "password">
                  <button type="button" class="vievPassword" title="Скрыть"><i class="far fa-eye"></i></button>
               </div>
               <p>
                  <input type = "checkbox" class = "rememberme" name = "rememberme" value="forever">
                  <label for="rememberme">Запомнить меня</label>
               </p>
               <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "login" value="Войти">Войти</button>
            </form>
            <div class="backtoblog">
               <a href="http://<?= $_SERVER['SERVER_NAME'];?>">← Перейти на сайт</a>
            </div>            
         </div>            
      </div>
      <?php
      //Опрдеделяем IP адресс
      //В базе указываем 45 символов.
      function GetIp(){
         if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = 'HTTP_CLIENT_IP - '.$_SERVER['HTTP_CLIENT_IP'];
         } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {$ip = 'HTTP_X_FORWARDED_FOR - '.$_SERVER['HTTP_X_FORWARDED_FOR'];
         } else {$ip = 'REMOTE_ADDR - '.$_SERVER['REMOTE_ADDR'];}
      return $ip;}
      echo GetIp();
      ?>
            
   </body>
</html>
