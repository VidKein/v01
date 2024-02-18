<?php //нужно для вычитки всех фото
		function array_images($path,$category,$extension){  // "img/".$trip."/*.jpg"
				if(empty($path)) $path = "img/";
				if(empty($extension)) $extension = "/*.jpg";
				$path_trip = $path.$category.$extension; //смотрим только указанную папку и ищим только такие файлы
				return glob($path_trip);
		}

        class PageData{
            public $code;
            public $name;
            public $description;
            public $section;
            public $img;
        }
        
        //data to connect db
        require_once "config.php";
 
        //connected to database
        function connect_kv(){
            $con = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
            // Check connection
            if (!$con) {
                die("Ошибка подключения к базе данных ( номер -- ".mysqli_connect_errno()."): описание - ".mysqli_connect_error());//выводит ошибки: номер+описание
            } else return $con;
        }
//admin part
        
        //login fubction, set session to acsess data
        function login($postname, $postpassword){
            $con = connect_kv();
            //Экранирует специальные символы в строке для использования в SQL-выражении, используя текущий набор символов соединения
            $myusername = mysqli_real_escape_string($con,$postname);
            $mypassword = mysqli_real_escape_string($con,$postpassword);

            $sql = "SELECT * FROM kv_users WHERE login = '$myusername' and password = '$mypassword'";
            $result = mysqli_query($con,$sql);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $user_id = $row['id'];
            $user_role = $row['roles'];
            $user_nikname = $row['nikname'];

            $sql_ = "SELECT * FROM kv_roles WHERE id = '$user_role'";
            $res = mysqli_query($con,$sql_);
            $row_ = mysqli_fetch_array($res,MYSQLI_ASSOC);
            $active = $row_['name'];            
                     
            $count = mysqli_num_rows($result);
            
            /* закрываем подключение */
            $con->close();
            // If result matched $myusername and $mypassword, table row must be 1 row
                     
            if($count == 1) {                
                $_SESSION['valid'] = true;//статус валидации
                $_SESSION['timeout'] = date("H:i:s");//????
                $_SESSION['lastlogin'] = date("Y-m-d H:i:s");//время входа
                $_SESSION['username'] = $myusername;//имя пользователя
                $_SESSION['active'] = $active;//статус
                $_SESSION['nikname'] = $user_nikname;//ник пользователя которое отображается
                $_SESSION['id'] = $user_id;//id пользователя
                header("location: admin.php?p=Info");
            }else {
               return " Ваше имя пользователя и пароль не правильны.";
              }
        }

        //check valid session
        function valid_session(){
            if($_SESSION['valid'] && !empty($_SESSION['valid'])){
                return true;
            } else {return false;}
        }

        //menu list db 
        function admin_menu(){
            echo '<a href = "admin.php?p=Photos" title = "Photos">Photos</a> + '.
                '<a href = "admin.php?p=Categorys" title = "Categorys">Categorys</a> + '.
                '<a href = "admin.php?p=Pages" title = "Pages">Pages</a> + ';
            if($_SESSION['active'] == "Admin"){
                echo '<a href = "admin.php?p=Users" title = "Users">Users</a> + '.
                    '<a href = "admin.php?p=Roles" title = "Roles">Roles</a> + '.
                    '<a href = "admin.php?p=Parameters" title = "Parameters">Parameters</a> + '.
                    '<a href = "admin.php?p=Email" title = "Email">Email</a> + '.
                    '<a href = "admin.php?p=ErrorLog" title = "ErrorLog">ErrorLog</a> + ';
            }
            echo '['.$_SESSION['username']."-".$_SESSION['active'].']'.
                '- <button><a href = "..\admin\logout.php" title = "Logout">Logout</a></button>';
        }

        
        function admin_view_list(){
            
            if(isset($_GET['p'])) $p = $_GET['p'];
            if( isset($_GET['p']) && $p == "Users" &&  $_SESSION['active'] !== 'Admin'){$styleNoAdmin = "style = 'display: none'";} 
            echo '<table class="tablemanager">
                    <thead>
                        <tr>
                        <th class="disableSort">Controls</th>
                        <th '. $styleNoAdmin . ' >Number</th>';
            switch ($p) {
                case 'Photos':
                    list_photos($p);
                    break;
                case 'Categorys':
                    list_categorys($p);
                    break;
                case 'Pages':
                    list_pages($p);	
                    break;
                case 'Users':
                    list_users($p);
                    break;
                case 'Roles':
                    list_roles($p);
                    break;
                case 'Parameters':
                    list_settings($p);
                    break;
                case 'Email':
                    list_email($p);
                    break;
                case 'ErrorLog':
                    list_error($p);
                    break;
            }
            echo '</tbody>
                </table>';
        }

        function list_data($tablename){
            $con = connect_kv();
            $sql = "SELECT * FROM $tablename";
            $res = mysqli_query($con, $sql);
            mysqli_close($con);
            return $res;
        }

        function list_pages($p){
            echo '<th>Code</th>
                        <th>Name</th>
                        <th>Descriptions</th>
                        <th>Section code</th>
                        <th>Photo for page</th>
                    </tr>
                </thead>
                <tbody>';

            $res = list_data('kv_pages');

            if (mysqli_num_rows($res) > 0) {
            // output data of each row
            $i = 0;
                while($row = mysqli_fetch_assoc($res)) {
                  if($_SESSION['active'] == "Admin"){  
                    echo '<tr>
                        <td >'.controls_button_list('edit',$p,$row["id"]).controls_button_list('delete',$p,$row["id"]).'</td>';}
                        else{echo '<tr>
                            <td >'.controls_button_list('edit',$p,$row["id"]).'</td>';}
                    echo 
                        '<td >'.++$i.'</td>
                        <td >'.$row["code"].'</td>
                        <td >'.$row["name"].'</td>
                        <td style="text-align: left;" >'.$row["description"].'</td>
                        <td >'.$row["section"].'</td>
                        <td >'.$row["photo"].'</td>
                    </tr>';
                }
            } 
        }

        function list_categorys($p){
            echo '<th>Name</th>
                  <th>Descriptions</th>
                  <th>Location</th>
                  </tr>
                  </thead>
                  <tbody>';

            $res = list_data('kv_categories');
            
            if (mysqli_num_rows($res) > 0) {
            // output data of each row
            $i = 0;
                while($row = mysqli_fetch_assoc($res)) {
                  if($_SESSION['active'] == "Admin"){  
                    echo '<tr>
                    <td >'.controls_button_list('edit',$p,$row["id"]).controls_button_list('delete',$p,$row["id"]).controls_button_list('folder',$p,$row["id"]);}
                    else{echo '<tr>
                        <td >'.controls_button_list('edit',$p,$row["id"]).'</td>';}
                    
                    echo '</td>
                        <td >'.++$i.'</td>
                        <td >'.$row["name"].'</td>
                        <td >'.$row["description"].'</td>
                        <td >'.$row["location"].'</td>
                    </tr>';
                }
            }
        }

        function list_roles($p){
            if($_SESSION['active'] == "Admin"){
                echo '<th>Name</th>
                        <th>access</th>
                        <th>comment</th>
                    </tr>
                </thead>
                <tbody>';

                $res = list_data('kv_roles');

                if (mysqli_num_rows($res) > 0) {
                // output data of each row
                    while($row = mysqli_fetch_assoc($res)) {
                        echo '<tr>
                        <td >'.controls_button_list('edit',$p,$row["id"]).controls_button_list('delete',$p,$row["id"]).'</td>
                            <td >'.$row["id"].'</td>
                            <td >'.$row["name"].'</td>
                            <td >'.$row["access"].'</td>
                            <td >'.$row["comment"].'</td>
                        </tr>';
                    }
                }
            }
        }

        function list_users($p){
                echo '<th>login</th>
                      <th>password</th>
                      <th>date last login</th>
                      <th>date exit login</th>
                      <th>nikname</th>
                      <th>date create</th>
                      <th>date last edit</th>
                      <th>roles-id*</th>
                      <th>email</th>
                      </tr>
                    </thead>
                    <tbody>';
        if($_SESSION['active'] == "Admin"){
                    $res = list_data('kv_users');
                if (mysqli_num_rows($res) > 0) {
                    // output data of each row 
                    $i=0;           
                        while($row = mysqli_fetch_assoc($res)) {
                            echo '<tr>
                            <td >'.controls_button_list('edit',$p,$row["id"]).controls_button_list('delete',$p,$row["id"]).'</td>
                                <td >'.++$i.'</td>
                                <td >'.$row["login"].'</td>
                                <td >'.$row["password"].'</td>
                                <td >'.$row["lastlogin"].'</td>
                                <td >'.$row["lastexit"].'</td>
                                <td >'.$row["nikname"].'</td>
                                <td >'.$row["createdate"].'</td>
                                <td >'.$row["updatedate"].'</td>
                                <td >'.get_name_from_id('Roles',$row["roles"]).'</td>
                                <td >'.$row["email"].'</td>
                            </tr>';  
                        }
                    }
                }else{
                $profail = get_row_by_id($p,$_SESSION['id']);
                echo '<tr>
                <td >'.controls_button_list('edit',$p,$profail["id"]).'</td>
                    <td >'.$profail["login"].'</td>
                    <td >'.$profail["password"].'</td>
                    <td >'.$profail["lastlogin"].'</td>
                    <td >'.$profail["lastexit"].'</td>
                    <td >'.$profail["nikname"].'</td>
                    <td >'.$profail["createdate"].'</td>
                    <td >'.$profail["updatedate"].'</td>
                    <td >'.get_name_from_id('Roles',$profail["roles"]).'</td>
                    <td >'.$profail["email"].'</td>
                </tr>';
            }
        }

        function list_settings($p){
            if($_SESSION['active'] == "Admin"){
                echo '<th>Code</th>
                            <th>Ru</th>
                            <th>UA</th>
                            <th>EN</th>
                        </tr>
                    </thead>
                    <tbody>';

                $res = list_data('kv_settings');

                if (mysqli_num_rows($res) > 0) {
                // output data of each row
                    while($row = mysqli_fetch_assoc($res)) {
                        echo '<tr>
                        <td >'.controls_button_list('edit',$p,$row["id"]).'</td>
                            <td >'.$row["id"].'</td>
                            <td >'.$row["code"].'</td>
                            <td >'.$row["ru"].'</td>
                            <td >'.$row["ua"].'</td>
                            <td >'.$row["en"].'</td>
                        </tr>';
                    }
                }
            }
        }

        function list_email($p){
            if($_SESSION['active'] == "Admin"){
                echo '<th>Subject</th>
                      <th>Correspondent_name</th>
                      <th>Correspondent_email</th>
                      <th>Content</th>
                      <th>Date</th>
                      <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>';

                $res = list_data('kv_email');

                if (mysqli_num_rows($res) > 0) {
                // output data of each row
                $i=0;
                    while($row = mysqli_fetch_assoc($res)) {
                        echo '<tr>
                        <td >'.controls_button_list('delete',$p,$row["id"]).'</td>
                            <td >'.++$i.'</td>
                            <td >'.$row["subject"].'</td>
                            <td >'.$row["correspondent_name"].'</td>
                            <td >'.$row["correspondent_email"].'</td>
                            <td >'.$row["content"].'</td>
                            <td >'.$row["date"].'</td>
                            <td >'.$row["status"].'</td>
                        </tr>';
                    }
                }
            }
        }

        function list_error($p){
            if($_SESSION['active'] == "Admin"){
                echo '<th>Error Log</th>
                      <th>Status</th>
                      <th>Revision Log</th>
                        </tr>
                    </thead>
                    <tbody>';

                $res = list_data('kv_error');

                if (mysqli_num_rows($res) > 0) {
                // output data of each row
                $i = 0;
                    while($row = mysqli_fetch_assoc($res)) {
                        echo '<tr>
                        <td >'.controls_button_list('edit',$p,$row["id"]).controls_button_list('delete',$p,$row["id"]).'</td>
                            <td >'.++$i.'</td>
                            <td >'.$row["error"].'</td>
                            <td >'.$row["status"].'</td>
                            <td >'.$row["revision"].'</td>
                        </tr>';
                    }
                }
            }
        }

        function list_photos($p){
                echo '<th style="width: 5%";>Name</th>
                      <th>Url photo 500</th>
                      <th>Url photo 1200</th>
                      <th>Descriptions</th>
                      <th>Category</th>
                      <th>Short Descriptions</th>
                      <th style="width: 8%">Date Upload</th>
                      <th style="width: 8%">Date Modify</th>
                      </tr>
                        </thead>
                        <tbody>';

                $res = list_data('kv_photo');

                if (mysqli_num_rows($res) > 0) {
                // output data of each row
                $i = 0;
                    while($row = mysqli_fetch_assoc($res)) {
                        if($_SESSION['active'] == "Admin"){
                        echo '<tr>
                            <td >'.controls_button_list('edit',$p,$row["id"]).controls_button_list('delete',$p,$row["id"]).'</td>';}
                            else{echo '<tr>
                                <td >'.controls_button_list('edit',$p,$row["id"]).'</td>';}
                        echo     
                            '<td >'.++$i.'</td>
                            <td >'.$row["name"].'</td>
                            <td style="text-align: center;"  >
                            <img class="lazy" data-src="'.$row["url_500"].'" width="100" height="auto" alt="'.$row["name"].'"><br>'.
                            $row["url_500"].'</td>
                            <td style="text-align: center;"  >
                            <img class="lazy" data-src="'.$row["url_500"].'" width="100" height="auto" alt="'.$row["name"].'"><br>'.
                            $row["url_1200"].'</td>     
                            <td >'.$row["description"].'</td>
                            <td >'.get_name_from_id("Categorys",$row["category_id"]).'</td>
                            <td >'.$row["short_description"].'</td>
                            <td >'.$row["upload_photo"].'</td>
                            <td >'.$row["update_photo"].'</td>
                        </tr>';
                    }
                }
            
        }
        
        function list_profile(){
            echo "<link rel='stylesheet' href='../css/create.css'>";
            edit_obj_user('Users', $_SESSION['id']);
            echo "<script src='/script/anime/passGeneration.js'></script>";
        }
        //Сохраняем информацию - Социальные сети, Данные по хосту
        if (!empty($_POST["name"])) { 
            if(is_numeric($_POST["edit"])){//для Социальной сети
                $name = $_POST["name"];
                //вычитываем информацию
                $jsonFale = file_get_contents('json/'.$_POST["fale"]);
                //декодируем
                $jsonDecodPapki = json_decode($jsonFale, true);
                //вычитываем значение
                $countFail = $jsonDecodPapki[$name];
                //добавляем +1
                $count = $_POST['edit'] + $countFail; 
                //записываем в файл
                foreach ($jsonDecodPapki as $key => $value) {
                    if($name == $key){
                        $jsonDecodPapki[$key] = $count;
                    }    
                }
                file_put_contents('json/'.$_POST["fale"], json_encode($jsonDecodPapki));
                unset ($jsonDecodPapki);
                }else{//для Хоста
                $name = $_POST["edit"];
                $valueInput = $_POST["name"];
                //вычитываем информацию
                $jsonFale = file_get_contents('json/'.$_POST["fale"]);
                //декодируем
                $jsonDecodPapki = json_decode($jsonFale, true);
                //вычитываем значение
                $countFail = $jsonDecodPapki[$name];    
                //записываем в файл
                foreach ($jsonDecodPapki as $key => $value) {
                    if($name == $key){
                        $jsonDecodPapki[$key] = $valueInput;
                    }    
                }
                file_put_contents('json/'.$_POST["fale"], json_encode($jsonDecodPapki));
                unset ($jsonDecodPapki);
                }
        }        
        function list_info(){                         
            //Функции по обьему и информации обьема сайта+папок
            //Вычитываем Директорию для расчета всей информации
            define('DIRECTORI',$_SERVER["DOCUMENT_ROOT"]);
            //Класс для работы с Директорией
            class HostSait{
                //определяем размер всего
                public static function dirSize($direct) {
                    $size = 0;
                    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($direct)) as $file){
                        $size+=$file->getSize();
                    }
                    $summaSize = $size/1048576;// Байты в МВ
                    return $size = $summaSize;
                }
                //вычитываем текст информацию всего
                public static function getInfo($lies){
                    //вычитываем информацию
                    $jsonFale = file_get_contents(dirname(__FILE__).$lies);
                    //декодируем
                    $jsonDecodPapki = json_decode($jsonFale, true);
                    return $jsonDecodPapki;
                }            
                //Обшая таблица с графиками -> расчет свободно/занято + Проверка на ПЕРЕПОЛНЕНИЕ
                public static function fullScheduleDirektori($direct){
                    //Массив с обшей информацмей
                    $sumInfoFull =[];
                    //размер предоставляемый провайдером
                    $common = self::getInfo("/json/info.json")['allocated space'];
                    /*занятое*/
                    //МВ
                    $busy = round(self::dirSize($direct),2);
                    //%
                    $partBusy = round($busy*100/$common,2);
                    /*Свободное*/
                    //МВ
                    $free = round($common-$busy,2);
                    //проценты               
                    $partfree = round(100-$partBusy,2);
                    //Проверка на ПЕРЕПОЛНЕНИЕ
                    $attention = ($partBusy <= 70) ? true : false ;
                    $sumInfoFull = array('attention'=> $attention,'busy' => $busy, 'partBusy' => $partBusy, 'free' => $free, 'partFree' => $partfree);
                    return $sumInfoFull;
                }
                //Таблица на временные файлы с графиками -> расчет свободно/занято + Проверка на ПЕРЕПОЛНЕНИЕ
                public static function privatScheduleDirektori($direct){
                    //Массив с обшей информацмей
                    $sumInfoPrivat =[];
                    //Обший размер занимаемый на хосте
                    $common = self::fullScheduleDirektori(DIRECTORI)['busy'];
                    /*занятое*/
                    //МВ
                    $busy = round(self::dirSize($direct),2);
                    //%
                    $partBusy = round($busy*100/$common,2);
                    /*Свободное*/
                    //МВ
                    $free = round($common-$busy,2);
                    //проценты                
                    $partfree = round(100-$partBusy,2);
                    //Проверка на ПЕРЕПОЛНЕНИЕ
                    $attention = ($partBusy <= 35) ? true : false ;
                    $sumInfoPrivat = array('attention'=> $attention,'busy' => $busy, 'partBusy' => $partBusy, 'free' => $free, 'partFree' => $partfree);
                    return $sumInfoPrivat;
                }
                //Осталось дней до окончания хоста
                public static function timeLeft(){
                    $dateHost = new DateTime(self::getInfo("/json/info.json")['termination date']);
                    $date = new DateTime();
                    $interval = $date->diff($dateHost);
                    $timeLeft = $interval->days;
                    return $timeLeft;
                }
            }
            //Вычисляем количество папок+файлов
            $dirname = DIRECTORI;
            function scanDirs($dirname) { // Объявляем переменные замены глобальными  
                global $count_files, $count_dirs;  
                // Открываем текущую директорию  
                $dir = opendir($dirname);  
                // Читаем в цикле директорию  
                while (($file = readdir($dir)) !== false)  
                {  
                // Если файл обрабатываем его содержимое  
                    if($file != "." && $file != "..")  
                    {  
                        // Если имеем дело с файлом - производим подсчет  
                        if(is_file($dirname."/".$file))  
                        {  
                        $count_files++;  
                        }  
                        // Если перед нами директория, вызываем рекурсивно  
                        // функцию scan_dir  
                        if(is_dir($dirname."/".$file))  
                        {  
                        $count_dirs++;  
                        scanDirs($dirname."/".$file);  
                        }  
                    }  
                }  
                // Закрываем директорию  
                closedir($dir);
                $summa = [];
                $summa['dir'] = $count_dirs;
                $summa['files'] = $count_files/2;
                return $summa;             
            } ?>
                <div class="wrapInfoPanel">
                    <div class="metaboxInfoPanel">
                    <div class="infoBoxOne"  id="contener-1">
                        <div class="fullInfo">
                            <h2 id="showFullInfo" class="showFullInfo">Обшая информация о сайте</h2>
                            <div class="wrapInfoFullinfo" >
                                <p><b>Сайт -  </b><span><?= $_SERVER['SERVER_NAME'];?></span></p>
                                <p><b>Цель -  </b><span>Сайт фотографа путешествинника Видющенко КН</span></p>
                                <div class="contentInfo">
                                    <div class="leftFullInfoBox">
                                        <ul>
                                            <li>Количество разделов : <span><?= mysqli_num_rows(list_data("kv_categories"));?></span></li>
                                            <li>Обшее количество фотографий : <span><?= ALLroow("all");?></span></li>
                                        </ul>
                                    </div>
                                    <div class="riteFullInfoBox">
                                    <p><b>Разделы :</b></p>                           
                                        <ul>
                                            <?php
                                            foreach (set_array_trips() as $key => $value) {?>
                                            <li><?=$value;?> : <span><?= ALLroow($key);?></span></li>
                                            <?php }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php  if($_SESSION['active'] == "Admin"){?>
                        <div class="adminInfo">
                        <h2 id="showAdminInfo" class="showAdminInfo">Все для администрирования</h2>
                        <div class="wrapInfoAdmin">
                                <p><b>Количество пользователей:</b></p>
                                <div class="infousers">
                                    <button class="accordion">Всего - <span class="namber"><?= mysqli_num_rows(list_data("kv_users"));?></span></button>
                                    <div class="panel">
                                        <table class="infoTab">
                                            <tr>
                                                <th rowspan="2"></th>
                                                <th rowspan="2">имя</th>
                                                <th rowspan="2">дата регистрации</th>
                                                <th rowspan="2">дата обновления</th>
                                                <th colspan ="2">время</th>                                                                                        
                                            </tr>    
                                            <tr>
                                                <th>входа</th>
                                                <th>выхода</th>
                                            </tr>
                                        <?php
                                            $i = 0;
                                            $res = list_data('kv_users');
                                            while($row = mysqli_fetch_assoc($res)) {
                                                ?>                                            
                                        <tr>
                                            <td><?= ++$i;?></td><td><?= $row["login"];?></td><td><?= $row["createdate"];?></td><td><?= $row["updatedate"];?></td><td><?= $row["lastlogin"];?></td><td><?= $row["lastexit"];?></td></tr>
                                        <?php }
                                        ?>
                                        </table>
                                    </div>
                                    <?php
                                    $i = 0;
                                    $con = connect_kv();                                    
                                    $row = mysqli_query($con,"SELECT * FROM kv_users WHERE  roles = 1");
                                    ?>
                                    <button class="accordion">Администратор -  <span class="namber"><?= mysqli_num_rows($row);?></span></button>
                                    <div class="panel">
                                        <table class="infoTab">
                                            <tr>
                                                <th rowspan="2"></th>
                                                <th rowspan="2">имя</th>
                                                <th rowspan="2">дата регистрации</th>
                                                <th rowspan="2">дата обновления</th>
                                                <th colspan ="2">время</th>                                                                                        
                                            </tr>    
                                            <tr>
                                                <th>входа</th>
                                                <th>выхода</th>
                                            </tr>
                                        <?php                                     
                                        if(mysqli_num_rows($row) > 0){                                   
                                            while($res = mysqli_fetch_assoc($row)) {?>        
                                            <tr><td><?= ++$i;?></td><td><?= $res["login"];?></td><td><?= $res["createdate"];?></td><td><?= $res["updatedate"];?></td><td><?= $res["lastlogin"];?></td><td><?= $res["lastexit"];?></td></tr>
                                            <?php } 
                                        }else{ ?>
                                        <tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>      
                                        <?php } ?>   
                                        </table>
                                    </div>
                                    <?php
                                    $i = 0;
                                    $con = connect_kv();                                    
                                    $row = mysqli_query($con,"SELECT * FROM kv_users WHERE  roles = 2");
                                    ?>
                                    <button class="accordion">Менеджер -  <span class="namber"><?= mysqli_num_rows($row);?></span></button>
                                    <div class="panel">
                                        <table class="infoTab">
                                            <tr>
                                                <th rowspan="2"></th>
                                                <th rowspan="2">имя</th>
                                                <th rowspan="2">дата регистрации</th>
                                                <th rowspan="2">дата обновления</th>
                                                <th colspan ="2">время</th>                                                                                        
                                            </tr>    
                                            <tr>
                                                <th>входа</th>
                                                <th>выхода</th>
                                            </tr>
                                        <?php
                                        if(mysqli_num_rows($row) > 0){                                   
                                            while($res = mysqli_fetch_assoc($row)) {?>        
                                            <tr><td><?= ++$i;?></td><td><?= $res["login"];?></td><td><?= $res["createdate"];?></td><td><?= $res["updatedate"];?></td><td><?= $res["lastlogin"];?></td><td><?= $res["lastexit"];?></td></tr>
                                            <?php } 
                                        }else{ ?>
                                        <tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>      
                                        <?php } ?> 
                                        </table>
                                    </div>
                                    <?php
                                    $i = 0;
                                    $con = connect_kv();                                    
                                    $row = mysqli_query($con,"SELECT * FROM kv_users WHERE  roles = 3");
                                    ?>
                                    <button class="accordion">Пользователей -  <span class="namber"><?= mysqli_num_rows($row);?></span></button>
                                    <div class="panel">
                                        <table class="infoTab">
                                            <tr>
                                                <th rowspan="2"></th>
                                                <th rowspan="2">имя</th>
                                                <th rowspan="2">дата регистрации</th>
                                                <th rowspan="2">дата обновления</th>
                                                <th colspan ="2">время</th>                                                                                        
                                            </tr>    
                                            <tr>
                                                <th>входа</th>
                                                <th>выхода</th>
                                            </tr>
                                        <?php
                                        if(mysqli_num_rows($row) > 0){                                   
                                            while($res = mysqli_fetch_assoc($row)) {?>        
                                            <tr><td><?= ++$i;?></td><td><?= $res["login"];?></td><td><?= $res["createdate"];?></td><td><?= $res["updatedate"];?></td><td><?= $res["lastlogin"];?></td><td><?= $res["lastexit"];?></td></tr>
                                            <?php } 
                                        }else{ ?>
                                        <tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>       
                                        <?php } ?> 
                                        </table>
                                    </div>
                                </div>
                                <p><b>Поделились:</b></p>
                                <div class="infoShared" style="margin-bottom: 40px;">
                                    <ul class="shared">
                                        <li><i class="fab fa-pinterest-p"></i><span class="number"><?= HostSait::getInfo("/json/share.json")['pinterest'];?></span></li>
                                        <li><i class="fab fa-facebook-f"></i><span class="number"><?= HostSait::getInfo("/json/share.json")['facebook'];?></span></li>
                                        <li><i class="fab fa-twitter"></i><span class="number"><?= HostSait::getInfo("/json/share.json")['twitter'];?></span></li>
                                        <li><i class="far fa-envelope"></i><span class="number"><?= ALLemail();?></span></li>
                                    </ul>                            
                                </div>
                            </div>    
                        </div>
                        <?php
                    }?>
                    </div>
                    <div class="infoBoxTu"  id="contener-2">
                        <div class="hostingInfo">
                            <h2  id="showHostingInfo" class="showHostingInfo">Информация о хостинге</h2>
                            <div class="wrapInfoHosting">
                            <p class="label"><b>Имя хоста  </b><span id="nameHost"><?= HostSait::getInfo("/json/info.json")['host'];?> </span>
                            <?php if($_SESSION['active'] !== "Admin"){
                               $viewsaveTextHost = "display: none;";    
                            }?>
                            <button class="saveTextHost" id="Host" style="<?= $viewsaveTextHost;?>"></button>
                                <span style="display: none;">
                                <input id="valueHost" type="text" name="host" value="<?= HostSait::getInfo("/json/info.json")['host'];?>">
                                <button class="saveHost" name="Host" >сохранить</button>                
                                </span>
                            </p>
                            <p class="label"><b>Оплачено до </b><span id="nameHost"><?= HostSait::getInfo("/json/info.json")['termination date'];?> </span>
                            <button class="saveTextHost" id="Date" style="<?= $viewsaveTextHost;?>"></button>
                                <span style="display: none;">
                                <input id="valueDate" type="text" name="termination date" value="<?= HostSait::getInfo("/json/info.json")['termination date'];?>">       
                                <button class="saveHost" name="Date" >сохранить</button>                   
                                </span>                                
                            </p>                            
                            <p><b>Осталось </b>
                            <?php
                            //Предупреждение о маленьком сроке - 10 дней
                             $messegHostDate = HostSait::timeLeft();
                             if ($messegHostDate <= 10) {
                                 $styleHostDate = "font-weight: bold; color:red;";
                             }
                            ?>
                            <span style="<?= $styleHostDate;?>"><?= $messegHostDate;?></span> дня</p>
                            <p><b>Количество папок  </b><span><?= scanDirs($dirname)['dir'];?></span> шт</p>
                            <p><b>Количество файлов  </b><span><?= scanDirs($dirname)['files'];?></span> шт</p>
                            <p class="label"><b>Место на хостинге  </b><span id="nameHost"><?= HostSait::getInfo("/json/info.json")['allocated space'];?> МВ </span>  
                            <button class="saveTextHost" id="Size" style="<?= $viewsaveTextHost;?>"></button>
                                <span style="display: none;">
                                <input id="valueSize" type="text" name="allocated space" value="<?= HostSait::getInfo("/json/info.json")['allocated space'];?>">
                                <button class="saveHost" name="Size">сохранить</button>                          
                                </span>    
                            </p> 
                            <div class="host">
                            <?php if(HostSait::fullScheduleDirektori(DIRECTORI)["attention"] == false){                                  
                                    if (HostSait::fullScheduleDirektori(DIRECTORI)["partBusy"] >= 100) {                                    
                                        $busy = HostSait::getInfo("/json/info.json")['allocated space'];                                    
                                        $partBusy = "100";
                                        $free = "0";
                                        $partFree = "display: none;";
                                        $partFreeNamber = "0";
                                        $more = HostSait::fullScheduleDirektori(DIRECTORI)["free"];
                                        $attentionMeseg = "<b>У вас закончилась память. Переизбыток".$more."МВ</b>";
                                    }else{
                                        $busy = HostSait::fullScheduleDirektori(DIRECTORI)["busy"];                                    
                                        $partBusy = HostSait::fullScheduleDirektori(DIRECTORI)["partBusy"];
                                        $partFree = "width: ".HostSait::fullScheduleDirektori(DIRECTORI)["partFree"]."%;";
                                        $free = HostSait::fullScheduleDirektori(DIRECTORI)["free"];
                                        $partFreeNamber = HostSait::fullScheduleDirektori(DIRECTORI)["partFree"];
                                        $attentionMeseg = "<b>Внимание у вас закончивается память</b>";                                    
                                    }
                            }else{
                                $busy = HostSait::fullScheduleDirektori(DIRECTORI)["busy"];                                    
                                $partBusy = HostSait::fullScheduleDirektori(DIRECTORI)["partBusy"];
                                $partFree = "width: ".HostSait::fullScheduleDirektori(DIRECTORI)["partFree"]."%;";
                                $free = HostSait::fullScheduleDirektori(DIRECTORI)["free"];
                                $partFreeNamber = HostSait::fullScheduleDirektori(DIRECTORI)["partFree"];
                                $attentionView = "display: none;";
                            }
                            ?>
                                    <table>
                                        <tr class="infoSaziGrafik">
                                            <td colspan = "3">
                                            <div class="remainder" style="width: <?= $partBusy;?>%;"><b>занято</b></div>
                                            <div class="usedBy" style="<?= $partFree;?>"><b>свободно</b></div>                            
                                            </td>
                                        </tr>
                                        <tr class="infoSaziNamber">
                                            <td>
                                            <div class="usedByNamber"><?= $busy;?>MB / <?= $partBusy;?>%</div>
                                            </td>
                                            <td style="<?= $attentionView;?>">
                                            <p id="attention" style="color: red;"><?= $attentionMeseg;?></p>
                                            </td>
                                            <td>
                                            <div class="remainderNamber"><?= $free;?>MB / <?= $partFreeNamber;?>%</div>   
                                            </td>
                                        </tr>
                                    </table> 
                                </div>
                                <p><b>Размер временных файлов </b>(от занятого объема - <span><?= round(HostSait::dirSize(DIRECTORI),2);?>МВ</span>) - <span><?= round((HostSait::dirSize(DIRECTORI."/files"))+(HostSait::dirSize(DIRECTORI."/logs")),2);?>MB</span></p>
                                <div class="Fail">
                                    <table>
                                        <caption><mark>File (буфер изображений)</mark> - <span><?= round((HostSait::dirSize(DIRECTORI."/files")),2);?>MB</span></caption>
                                        <?php if(HostSait::privatScheduleDirektori(DIRECTORI."/files")["attention"] == false){  
                                            $attentionMesegFail = "Очистите папку";
                                         }else{$attentionViewFile = "display: none;";}
                                          ?>
                                        <tr class="infoSaziFail">
                                            <td class="buttonWidth"  colspan = "3">
                                            <div class="remainder" style="width: <?= HostSait::privatScheduleDirektori(DIRECTORI."/files")["partBusy"]?>%;"><b>занято</b></div>
                                            <div class="usedBy" style="width: <?= HostSait::privatScheduleDirektori(DIRECTORI."/files")["partFree"];?>%;"><b>свободно</b></div>                            
                                            </td>
                                            <td rowspan="2"><?php echo controls_button_list('clear','Info','files');?></td>
                                        </tr>
                                        <tr class="infoSaziFailNamber">
                                            <td>
                                            <div class="usedByNamber"><?= HostSait::privatScheduleDirektori(DIRECTORI."/files")["busy"];?>MB / <?= HostSait::privatScheduleDirektori(DIRECTORI."/files")["partBusy"];?>%</div>
                                            </td>
                                            <td style="<?= $attentionViewFile;?>">
                                            <p id="attention" style="color: blue;" ><b><?= $attentionMesegFail;?></b></p>
                                            </td>
                                            <td>
                                            <div class="remainderNamber"><?= HostSait::privatScheduleDirektori(DIRECTORI."/files")["free"];?>MB / <?=HostSait::privatScheduleDirektori(DIRECTORI."/files")["partFree"];?>%</div>   
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="Logs" style="margin-bottom: 20px;">
                                    <table>
                                        <caption><mark>Logf (ошибки)</mark> - <span><?= round((HostSait::dirSize(DIRECTORI."/logs")),2)?>MB</span></caption>
                                        <?php if(HostSait::privatScheduleDirektori(DIRECTORI."/logs")["attention"] == false){  
                                            $attentionMesegLog = "Очистите папку";
                                         }else{$attentionViewLog = "display: none;";}
                                          ?>
                                        <tr class="infoSaziLogs">
                                            <td class="buttonWidth" colspan="3">
                                            <div class="remainder" style="width: <?= HostSait::privatScheduleDirektori(DIRECTORI."/logs")["partBusy"];?>%;"><b>занято</b></div>
                                            <div class="usedBy" style="width: <?= HostSait::privatScheduleDirektori(DIRECTORI."/logs")["partFree"];?>%;"><b>свободно</b></div>                            
                                            </td>
                                            <td rowspan="2"><?php echo controls_button_list('clear','Info','logs')?></td>
                                        </tr>
                                        <tr class="infoSaziLogsNamber">
                                            <td>
                                            <div class="usedByNamber"><?= HostSait::privatScheduleDirektori(DIRECTORI."/logs")["busy"];?>MB / <?= HostSait::privatScheduleDirektori(DIRECTORI."/logs")["partBusy"];?>%</div>
                                            </td>
                                            <td style="<?= $attentionViewLog;?>">
                                            <p id="attention" style="color: blue;" ><b><?= $attentionMesegLog;?></b></p>
                                            <td>
                                            <div class="remainderNamber"><?= HostSait::privatScheduleDirektori(DIRECTORI."/logs")["free"];?>MB / <?= HostSait::privatScheduleDirektori(DIRECTORI."/logs")["partFree"];?>%</div>   
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php }      

        //forms show
        function create_obj($p){
            switch($p){
                case 'Categorys': create_new_category($p);
                    break;
                case 'Roles': create_new_role($p);
                    break;
                case 'Pages': create_new_page($p);
                    break;
                case 'Parameters': create_new_parameters($p);
                    break;
                case 'Users': create_new_user($p);
                    break;
                case 'Photos': create_new_photo($p);
                    break;
            }
        }

        //sql -> go to add row on table, перейти, чтобы добавить строку в таблицу
        function create_data_row($post_p,$post_name,$post_description,$post_section_code,$post_location,
                                $post_code,$post_urlphoto_500, $post_urlphoto_1200,
                                $post_access, $post_comment,
                                $post_ru, $post_ua, $post_en,
                                $post_login,$post_password,$post_nikname,$post_roles,$post_email,
                                $post_short,$post_category){
            switch($post_p){
                case 'Categorys':
                    add_category($post_name,$post_description,$post_location);
                    break;
                case 'Roles': add_role($post_name, $post_access, $post_comment);
                    break;
                case 'Pages': add_page($post_code,$post_name,$post_description,$post_section_code,$post_urlphoto_500);
                    break;
                case 'Parameters': add_setting($post_code, $post_ru, $post_ua,$post_en);
                    break;
                case 'Users': add_user($post_login,$post_password,$post_nikname,$post_roles,$post_email);
                    break;
                case 'Photos': add_photo($post_name,$post_urlphoto_500, $post_urlphoto_1200,$post_description,$post_short,$post_category);
                    break;
            }
            header('Location: ../admin/admin.php?p='.$post_p);
        }

    //edit form show
        function edit_obj($p, $id){
            switch($p){
                case 'Categorys': edit_obj_category($p, $id);
                    break;
                case 'Roles': edit_obj_role($p, $id);
                    break;
                case 'Pages': edit_obj_page($p, $id);
                    break;
                case 'Parameters': edit_obj_parameters($p, $id);
                    break;
                case 'ErrorLog': edit_obj_error($p, $id);
                    break;  
                case 'Users': edit_obj_user($p, $id);
                    break;
                case 'Photos': edit_obj_photo($p, $id);
                    break;    
            }
        }

        function edit_row($post_p,$post_name,$post_description, $post_section_code, $post_location,
                                $post_code,$post_urlphoto_500, $post_urlphoto_1200,
                                $post_access, $post_comment,
                                $post_ru, $post_ua, $post_en,
                                $post_login,$post_password,$post_nikname,$post_roles,$post_email,
                                $post_short,$post_category,$id,$post_error,$post_status,$post_revision){
            switch($post_p){
                case 'Categorys': edit_category($id, $post_name,$post_description,$post_location);
                    break;
                case 'Roles': edit_role($id, $post_name, $post_access, $post_comment);
                    break;
                case 'Pages': edit_page($id, $post_code,$post_name,$post_description,$post_section_code,$post_urlphoto_500);
                    break;
                case 'Parameters': edit_setting($id, $post_code, $post_ru, $post_ua,$post_en);
                    break;
                case 'ErrorLog': edit_error($id,$post_error,$post_status,$post_revision);
                    break;    
                case 'Users': edit_user($id, $post_login,$post_password,$post_nikname,$post_roles,$post_email);
                    break;
                case 'Photos': edit_photo($id, $post_name,$post_urlphoto_500, $post_urlphoto_1200,$post_description,$post_short,$post_category);
                    break;

            }
            header('Location: ../admin/admin.php?p='.$post_p);
        }

    //end edit form show
        
    //sql adding
        
        function add_edit_row($sql_string, $message){
            $con = connect_kv();
            
            $sql = $sql_string;
            if (mysqli_query($con, $sql)) {
                echo $message;
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
            }
              
            mysqli_close($con);
        }

        function add_category($post_name,$post_description,$post_location){
            $sql = "INSERT INTO kv_categories (id, name, description, location) 
                        VALUES (NULL,'$post_name', '$post_description', '$post_location');";
            add_edit_row($sql, $create_success);
        }

        function add_page($post_code,$post_name,$post_description,$post_section_code,$post_urlphoto_500){
            $sql = "INSERT INTO kv_pages (id, code, name, description, section, photo) 
                        VALUES (NULL, '$post_code', '$post_name', '$post_description', '$post_section_code', '$post_urlphoto_500');";
            add_edit_row($sql, $create_success);
        }
 
        function add_role($post_name, $post_access, $post_comment){
            $sql = "INSERT INTO kv_roles (id, name, access, comment) 
                        VALUES (NULL,'$post_name', '$post_access', '$post_comment');";
            add_edit_row($sql, $create_success);
        }

        function add_setting($post_code, $post_ru, $post_ua,$post_en){
            $sql = "INSERT INTO kv_settings (code, ru, ua, en) 
                        VALUES (NULL, '$post_code', '$post_ru', '$post_ua', '$post_en');";
            add_edit_row($sql, $create_success);
        }

        function add_user($post_login,$post_password,$post_nikname,$post_roles,$post_email){
            $today = date("Y-m-d H:i:s");
            $sql = "INSERT INTO kv_users (id, login, password, nikname, createdate, 
                                            updatedate, roles, email, lastlogin) 
                        VALUES (NULL, '$post_login', '$post_password', '$post_nikname', '$today',
                                         NULL, '$post_roles', '$post_email', NULL);";
            add_edit_row($sql, $create_success);
        }
        function add_photo($post_name,$post_urlphoto_500, $post_urlphoto_1200,$post_description,$post_short,$post_category){
            $path = "../img/".$post_category;

            $ext_file_path_500 = "../files/".$post_urlphoto_500;
            $new_file_path_500 = $path."/".$post_urlphoto_500;
            $ext_file_path_1200 = "../files/".$post_urlphoto_1200;
            $new_file_path_1200 = $path."/".$post_urlphoto_1200;
            if (!is_dir($path)) {
                if (!mkdir($path, 0777, true)) {
                    die('Не удалось создать директории...');
                }
            }
            
            copy($ext_file_path_500,$new_file_path_500);
            copy( $ext_file_path_1200,$new_file_path_1200);
            $today = date("Y-m-d H:i:s");
            $sql = "INSERT INTO kv_photo (id, name, url_500, url_1200, description, short_description, 
                                            category_id, upload_photo, update_photo) 
                        VALUES (NULL, '$post_name', '$new_file_path_500','$new_file_path_1200', '$post_description', '$post_short',
                                         '$post_category', '$today', NULL);";
            add_edit_row($sql, $create_success);
        }

        function re_write_sql($value_500,$value_1200,$category){//повторное записывание в БД
            // аргументы которые передает функция re_write УБРАТЬ------
            echo "Аргумент 1 - ".func_get_arg(0);echo"<br>";
            echo "Аргумент 2 - ".func_get_arg(1);echo"<br>";
            echo "Аргумент 3 - ".func_get_arg(2);echo"<br>";
            $today = date("Y-m-d H:i:s");
            $sql = "INSERT INTO kv_photo (id, name, url_500, url_1200, description, short_description, 
                                            category_id, upload_photo, update_photo) 
                        VALUES (NULL, 'Test_name', '$value_500','$value_1200', 'test_description', 'test_short',
                                         '$category', '$today', '$today');";
                                         
            add_edit_row($sql, $create_success);
        }
    //end sql adding

    //sql edit
        function edit_category($id,$post_name,$post_description,$post_location){
            $sql = "UPDATE kv_categories SET `name` = '$post_name', `description` = '$post_description', 
                        `location` = '$post_location' WHERE `id` = '$id';";
            add_edit_row($sql, $edit_success);
        }

        function edit_page($id,$post_code,$post_name,$post_description, $post_section_code, $post_urlphoto_500){
            $sql = "UPDATE kv_pages SET `code` = '$post_code', `name` = '$post_name', 
                        `description` = '$post_description', `section` = '$post_section_code', `photo` = '$post_urlphoto_500' WHERE `id` = '$id';";
            add_edit_row($sql, $edit_success);
        }

 
        function edit_role($id, $post_name, $post_access, $post_comment){
            $sql = "UPDATE kv_roles SET name = '$post_name', access = '$post_access', 
                        comment = '$post_comment' WHERE id = '$id';";
            add_edit_row($sql, $edit_success);
        }

        function edit_setting($id,$post_code, $post_ru, $post_ua,$post_en){
            $sql = "UPDATE kv_settings SET code = '$post_code', ru = '$post_ru', 
                        ua = '$post_ua', en = '$post_en' WHERE id = '$id';";
            add_edit_row($sql, $edit_success);
        }

        function edit_error($id,$post_error,$post_status,$post_revision){
            $sql = "UPDATE kv_error SET error = '$post_error', 
                        status = '$post_status', revision = '$post_revision' WHERE id = '$id';";
            add_edit_row($sql, $edit_success);
        }

        function edit_user($id,$post_login,$post_password,$post_nikname,$post_roles,$post_email){
            $today = date("Y-m-d H:i:s");
            $sql = "UPDATE kv_users SET login = '$post_login', password = '$post_password', 
                        nikname = '$post_nikname', updatedate = '$today', roles = $post_roles, 
                        email = '$post_email' WHERE `id` = '$id';";
            add_edit_row($sql, $edit_success);
        }

        function edit_photo($id,$post_name,$post_urlphoto_500, $post_urlphoto_1200,$post_description,$post_short,$post_category){
            $today = date("Y-m-d H:i:s");
            $sql = "UPDATE kv_photo SET name = '$post_name', url_500 = '$post_urlphoto_500', url_1200 = '$post_urlphoto_1200',
                        description = '$post_description', short_description = '$post_short', 
                        update_photo = '$today', category_id = '$post_category' WHERE id = '$id';";
            add_edit_row($sql, $edit_success);
        }
    //end sql adding
        
    // DELETE ROW BY id
        function del_row($p,$id_row){
            $con = connect_kv();
            if($p == "Photos"){
                $row = get_row_by_id($p,$id_row);
                unlink($row["url_500"]);
                unlink($row["url_1200"]);
            }
            $table_name = db_table_from_page($p);
            if(isset($table_name)&&$table_name !=""){
            
                $sql = "DELETE FROM $table_name WHERE id = $id_row";
                if (mysqli_query($con, $sql)) {
                    echo "Record on ".$p." with ID - ".$id_row." - was DELETED successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($con);
                }
            }
            mysqli_close($con);
            //Очишаем временные файлы в папках
            if($p == "Info"){
                $arrauFilesDelat = glob($_SERVER['DOCUMENT_ROOT']."/".$id_row."/*");
                    foreach($arrauFilesDelat as $file){ // iterate files
                      if(is_file($file))
                        unlink($file); // delete file
                    }
            }
        }

        function get_files_from_path(){
            $temp_path = "../files";
            $extension = "/*.jpg";
			$path_trip = $temp_path.$extension; //смотрим только указанную папку и ищим только такие файлы
			return glob($path_trip);
        }

        function list_temp_folder(){            
            echo '<table class="tablemanager">
                    <tbody>
                        <tr>
                        <th rowspan="2"><button>All</button></th>
                        <th rowspan="2">Number</th>
                        <th rowspan="2">Name</th>
                        <th colspan="2">Url photo</th>
                        </tr>
                        <tr>
                        <th>500</th>
                        <th>1200</th>';
            echo        '</tr>';
            $list_folder = get_files_from_path();
            $i = 1;
            foreach ($list_folder as $key => $value){
                echo   '<tr>
                        <td>
                        <input id="id'.($key+1).'" type="checkbox" checked>
                        </td>
                        <td>';
                echo    ($key+1).'</td>
                        <td>'.$value.'</td>                        
                        <td><img src="'.$value.'" width="100" height="auto" alt="'.$value.'"></td> 
                        <td><img src="'.$value.'" width="100" height="auto" alt="'.$value.'"></td> 
                        </tr>';
            }
            echo    '</tbody>
                </table>';
        }

    //forms adding
        function create_new_category($p){
            ?>
                <form action="/admin/create.php" method = "post">
                    <input type="hidden" id="p" name="p" value="<?php echo $p; ?>">
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Name*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="name" name="name" placeholder="Category named">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="subject">Description*</label>
                        </div>
                        <div class="col-75">
                            <textarea id="description" name="description" placeholder="Write something.." style="height:200px"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lname">Location</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="location" name="location" placeholder="location. can be null">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                    <input type="submit" value="Submit">
                    </div>
                </form>
            <?php
        }

        function create_new_page($p){
            ?>
                <form action="/admin/create.php" method = "post">
                    <input type="hidden" id="p" name="p" value="<?php echo $p; ?>">
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Code*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="code" name="code" placeholder="Page code">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Name*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="name" name="name" placeholder="Page named">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="description">Description*</label>
                        </div>
                        <div class="col-75">
                            <textarea id="description" name="description" placeholder="Write something.." style="height:200px"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="category">Section code</label>
                        </div>
                        <div class="col-75">
                            <select id="section_code" name="section_code">
                            <?php
                            $section_menus = array("top" => "Верхнее меню", "nav" => "Навигационное меню", "bottom" => "Нижнее меню", "top+nav" => "Верхнее и навигационно меню", "nav+bottom" => "Навигационно и нижнее меню", "top+bottom" => "Верхнее и нижнее меню", "top+nav+bottom" => "Верхнее, навигационно и нижнее меню" );
                            foreach ($section_menus as $key => $value) {
                                echo '<option value="'.$key.'">'.$value.'</option>';
                            }                                  

                        ?>
                            </select>
                        </div>
                   </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="phname">Url page</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="photopage" name="photopage_500" placeholder="Photo for page">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                    <input type="submit" value="Submit">
                    </div>
                </form>
            <?php
        }

        function create_new_role($p){
            ?>
                <form action="/admin/create.php" method = "post">
                    <input type="hidden" id="p" name="p" value="<?php echo $p; ?>">
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Name*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="name" name="name" placeholder="Category named">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="faccess">Access*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="access" name="access" placeholder="Role access">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lcomment">Comment</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="comment" name="comment" placeholder="comment for role">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                    <input type="submit" value="Submit">
                    </div>
                </form>
            <?php
        }

        function create_new_parameters($p){
            ?>
                <form action="/admin/create.php" method = "post">
                    <input type="hidden" id="p" name="p" value="<?php echo $p; ?>">
                    <div class="row">
                        <div class="col-25">
                            <label for="fcode">Code*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="code" name="code" placeholder="Parameter code">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fru">Rus*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="ru" name="ru" placeholder="Russian">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fua">Ukr*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="ru" name="ru" placeholder="Ukraine">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="pen">Eng*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="en" name="en" placeholder="English">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                    <input type="submit" value="Submit">
                    </div>
                </form>
            <?php
        }

        function create_new_user($p){
            ?>
                <form action="/admin/create.php" method = "post">
                    <input type="hidden" id="p" name="p" value="<?php echo $p; ?>">
                    <div class="row">
                        <div class="col-25">
                           <label for="flogin">login*</label>                           
                        </div>
                        <div class="col-75">
                            <input type="text" id="login" name="login" placeholder="login account">                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lnik">NikName*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="nik" name="nik" placeholder="account nikname">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lemail">Email*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="email" name="email" placeholder="account email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="roles">Roles</label>
                        </div>
                        <div class="col-75">
                            <select id="role" name="role">
                            <?php
                                $res = list_data('kv_roles');

                                if (mysqli_num_rows($res) > 0) {
                                // output data of each row
                                    while($row = mysqli_fetch_assoc($res)) {
                                        echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                                    }
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fpass">Password*</label>
                        </div>
                        <div class="col-67">
                            <input type="password" id="password" name="password" placeholder="account password">
                            <button type="button" class="vievPassword" title="Скрыть"><i class="far fa-eye"></i></button>
                            <button type="button" class="exitPassword" title="Отмена"><i class="fas fa-times"></i></button>                            
                            <div id="block_check"></div>
                        </div>
                        <div class="col-8">
                            <button type="button" class="generatePassword" title="Генерация кода">Generate</button>                            
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <button class="goBask"><a href="/admin/admin.php?p=<?= $p;?>">Go Back <?=$p;?></a></button>
                        <input type="submit" value="Submit">
                    </div>
                </form>
            <?php
        }

        function create_new_photo($p,$url_500,$url_1200){
            ?>
            <form action="/admin/create.php" method = "post">
                <input type="hidden" id="p" name="p" value="<?php echo $p; ?>">
                <div class="row">
                    <div class="col-25">
                        <label for="fname">Name*</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="name" name="name" placeholder="name photo">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="furl">Url*</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="photopage" name="photopage_500" placeholder="path to photo" value="<?php echo $url_500; ?>">
                        <input type="text" id="photopage" name="photopage_1200" placeholder="path to photo" value="<?php echo $url_1200; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="description">Description*</label>
                    </div>
                    <div class="col-75">
                        <textarea id="description" name="description" placeholder="Write something.." style="height:200px"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="short">Short Description*</label>
                    </div>
                    <div class="col-75">
                        <textarea id="short" name="short" placeholder="Write something.." style="height:100px"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="category">Category</label>
                    </div>
                    <div class="col-75">
                        <select id="category" name="category">
                        <?php
                            $res = list_data('kv_categories');

                            if (mysqli_num_rows($res) > 0) {
                            // output data of each row
                                while($row = mysqli_fetch_assoc($res)) {
                                    echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                                }
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="row">
                <input type="submit" value="Submit">
                </div>
            </form>
            <?php
        }

    //end forms adding

    //forms edit
        function edit_obj_category($p, $id){
            $row_ = get_row_by_id($p,$id);
            ?>
                <form action="/admin/edit.php" method = "post">
                    <input type="hidden" id="p" name="p" value="<?php echo $p; ?>">
                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Name*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="name" name="name" value="<?php echo $row_["name"]; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="subject">Description*</label>
                        </div>
                        <div class="col-75">
                            <textarea id="description" name="description" style="height:200px"><?php echo $row_["description"]; ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lname">Location</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="location" name="location" value="<?php echo $row_["location"]; ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                    <input type="submit" value="Submit">
                    </div>
                </form>
            <?php
        }

        function edit_obj_page($p, $id){
            $row_ = get_row_by_id($p,$id);
            ?>
                <form action="/admin/edit.php" method = "post">
                    <input type="hidden" id="p" name="p" value="<?php echo $p; ?>">
                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Code*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="code" name="code" value="<?php echo $row_["code"]; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Name*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="name" name="name" value="<?php echo $row_["name"]; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="description">Description*</label>
                        </div>
                        <div class="col-75">
                            <textarea id="description" name="description" style="height:200px"><?php echo $row_["description"];?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="category">Section code</label>
                        </div>
                        <div class="col-75">
                            <select id="section_code" name="section_code">
                            <?php
                            $section_menus = array("top" => "Верхнее меню", "nav" => "Навигационное меню", "bottom" => "Нижнее меню", "top+nav" => "Верхнее и навигационно меню", "nav+bottom" => "Навигационно и нижнее меню", "top+bottom" => "Верхнее и нижнее меню", "top+nav+bottom" => "Верхнее, навигационно и нижнее меню" );
                             foreach ($section_menus as $key => $value) {
                                    if($row_["section"] == $key){
                                        $selected = "selected='selected' ";} else { $selected = " "; }
                                    echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                            }
                        ?>
                            </select>
                        </div>
                   </div>
                   <div class="row">
                        <div class="col-25">
                            <label for="phname">Url page</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="photopage" name="photopage_500" value="<?php echo $row_["photo"]; ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                    <input type="submit" value="Submit">
                    </div>
                </form>
            <?php 
        }


        function edit_obj_role($p, $id){
            $row_ = get_row_by_id($p,$id);
            ?>
                <form action="/admin/edit.php" method = "post">
                    <input type="hidden" id="p" name="p" value="<?php echo $p; ?>">
                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Name*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="name" name="name" value="<?php echo $row_["name"]; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="faccess">Access*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="access" name="access" value="<?php echo $row_["access"]; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lcomment">Comment</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="comment" name="comment" value="<?php echo $row_["comment"]; ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                    <input type="submit" value="Submit">
                    </div>
                </form>
            <?php
        }

        function edit_obj_parameters($p, $id){
            $row_ = get_row_by_id($p,$id);
            ?>
                <form action="/admin/edit.php" method = "post">
                    <input type="hidden" id="p" name="p" value="<?php echo $p; ?>">
                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                    <div class="row">
                        <div class="col-25">
                            <label for="fcode">Code*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="code" name="code" value="<?php echo $row_["code"]; ?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fru">Rus*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="ru" name="ru" value="<?php echo $row_["ru"]; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fua">Ukr*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="ua" name="ua" value="<?php echo $row_["ua"]; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="pen">Eng*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="en" name="en" value="<?php echo $row_["en"]; ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                    <input type="submit" value="Submit">
                    </div>
                </form>
            <?php
        }

        function edit_obj_user($p, $id){
            $row_ = get_row_by_id($p,$id);
            ?>  
                <form action="/admin/edit.php" method = "post">
                    <input type="hidden" id="p" name="p" value="<?php echo $p; ?>">
                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                    <div class="row">
                        <div class="col-25">
                            <label for="flogin">login*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="login" name="login" value="<?php echo $row_["login"]; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lnik">NikName*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="nik" name="nik" value="<?php echo $row_["nikname"]; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lemail">Email*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="email" name="email" value="<?php echo $row_["email"]; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="roles">Roles</label>
                        </div>
                        <div class="col-75">
                            <select id="role" name="role">
                            <?php
                                $res = list_data('kv_roles');

                                if (mysqli_num_rows($res) > 0) {
                                // output data of each row
                                    while($row = mysqli_fetch_assoc($res)) {
                                        if($row_["roles"] == $row["id"]){
                                            $selected = "selected='selected' "; } else { $selected = " "; }
                                        echo '<option value="'.$row["id"].'" '.$selected.'>'.$row["name"].'</option>';
                                    }
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fpass">Password*</label>
                        </div>
                        <div class="col-67">
                            <input type="password" id="password" name="password" value="<?php echo $row_["password"]; ?>">
                            <button type="button" class="vievPassword" title="Скрыть"><i class="far fa-eye"></i></button>
                            <button type="button" class="exitPassword" title="Отмена"><i class="fas fa-times"></i></button>                            
                            <div id="block_check"></div>
                        </div>
                        <div class="col-8">
                            <button type="button" class="generatePassword" title="Генерация кода">Generate</button>                            
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <button class="goBask"><a href="/admin/admin.php?p=<?= $p;?>">Go Back <?=$p;?></a></button>
                        <input type="submit" value="Submit" title="Сохранить">
                    </div>
                </form>
            <?php
        }

        function edit_obj_photo($p, $id){
            $row_ = get_row_by_id($p,$id);
            ?>
            <div style="text-align: center;"><img style="display:inline-block; margin: 10px 10px;" src="<?php  echo $row_['url_500']; ?>" width="500" height="auto" alt="<?php echo $row_['name'];?>"><img style="display:inline-block; margin: 10px 10px;" src="<?php  echo $row_['url_1200']; ?>" width="500" height="auto" alt="<?php echo $row_['name'];?>"></div>
            
            <form action="/admin/edit.php" method = "post">
                <input type="hidden" id="p" name="p" value="<?php echo $p; ?>">
                <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                <div class="row">
                    <div class="col-25">
                        <label for="fname">Name*</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="name" name="name" value="<?php echo $row_["name"];?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="furl">Url*</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="photopage" name="photopage_500" value="<?php echo $row_["url_500"];?>">
                        <input type="text" id="photopage" name="photopage_1200" value="<?php echo $row_["url_1200"];?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="description">Description*</label>
                    </div>
                    <div class="col-75">
                        <textarea id="description" name="description" style="height:200px"><?php echo $row_["description"];?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="short">Short Description*</label>
                    </div>
                    <div class="col-75">
                        <textarea id="short" name="short" style="height:100px"><?php echo $row_["short_description"];?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="category">Category</label>
                    </div>
                    <div class="col-75">
                        <select id="category" name="category">
                        <?php
                            $res = list_data('kv_categories');

                            if (mysqli_num_rows($res) > 0) {
                            // output data of each row
                                while($row = mysqli_fetch_assoc($res)) {
                                    if($row_["category_id"] == $row["id"]){
                                        $selected = "selected='selected' "; } else { $selected = " "; }
                                    echo '<option value="'.$row["id"].'" '.$selected.'>'.$row["name"].'</option>';
                                }
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="row">
                <input type="submit" value="Submit">
                </div>
            </form>
            <?php
        }

        function edit_obj_error($p, $id){
            $row_ = get_row_by_id($p,$id);
            ?>
                <form action="/admin/edit.php" method = "post">
                    <input type="hidden" id="p" name="p" value="<?php echo $p; ?>">
                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Error Log</label>
                        </div>
                        <div class="col-75">
                            <textarea style="background-color: whitesmoke; height:100px;" id="description" name="error" style="height:100px" readonly ><?php echo $row_["error"];?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="category">Status</label>
                        </div>
                        <div class="col-75">
                            <select id="section_code" name="status">
                            <?php
                            $section_menus = array("Исправленные" => "Исправленные", "Не исправленные" => "Не исправленные");
                            foreach ($section_menus as $key => $value) {
                                if($row_["status"] == $key){
                                    $selected = "selected='selected' ";} else { $selected = " "; }
                                echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                            }
                           ?>
                            </select>
                        </div>
                   </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lname">Revision Log*</label>
                        </div>
                        <div class="col-75">
                            <textarea id="description" name="revision" style="height:100px" ><?php echo $row_["revision"];?></textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                    <input type="submit" value="Submit">
                    </div>
                </form>
            <?php
        }

    //end forms edit

        function db_table_from_page($p){
            $db_table_name = "";
            switch ($p) {
                case 'Photos':
                    $db_table_name = "kv_photo";
                    break;
                case 'Categorys':
                    $db_table_name = "kv_categories";
                    break;
                case 'Pages':
                    $db_table_name = "kv_pages";
                    break;
                case 'Users':
                    $db_table_name = "kv_users";
                    break;
                case 'Roles':
                    $db_table_name = "kv_roles";
                    break;
                case 'Parameters':
                    $db_table_name = "kv_settings";
                    break;    
                case 'Email':
                    $db_table_name = "kv_email";
                    break;
                case 'ErrorLog':
                    $db_table_name = "kv_error";
                    break;    
            }
            return $db_table_name;
        }
        
        //edit | delete | create/delete - folder |
        function controls_button_list($do,$p,$id_row){
            $act = "";
            if($do == "edit"){
                $action = "/admin/edit.php";
                $button = "Edit";
                $act = '<input type="hidden" id="obj" name="obj" value="Edit">';
            }
            if($do == "delete"){
                $action = "/admin/delete.php";
                $button = "Delete";
            }
            if($do == "clear"){
                $action = "/admin/delete.php";
                $button = "Очистить";
            }
            if($do == "folder"){
                $button = "Create folder";
                $act = '<input type="hidden" id="act" name="act" value="create">';
                if(folder_check($id_row)){
                    $button = "Delete folder";
                    $act = '<input type="hidden" id="act" name="act" value="delete">';
                }
                $action = "/admin/folder.php";
            }
            return '<form action="'.$action.'" method = "post">
            <input type="hidden" id="p" name="p" value="'.$p.'">
            <input type="hidden" id="id" name="id" value="'.$id_row.'">
            '.$act.'
            <input type="submit" value="'.$button.'">
            </form>';
        }

        function folder_check($id){
            $path = "../img/".$id;
            return is_dir($path);
        }

        function folder_act($p, $id, $act){
            $path = "../img/".$id;
            if($act == "create"){
                if (!is_dir($path)) {
                    if(!mkdir($path, 0777,false))
                    {
                        echo'<p>Не удалось создать директорию.</p>';
                        echo "<a href='admin.php?p=".$p."'>Хотите вернутся ???</a>"; 
                        exit();   
                    }                                               
                }
                
            }
            if($act == "delete"){
                if (is_dir($path)) {
                    if (!rmdir($path)) {
                        echo'<p>Не удалось удалить директорию. Папка не пуста. Удалите Фотографии из папок</p>';
                        echo "<a href='admin.php?p=".$p."'>Хотите вернутся ???</a>"; 
                        exit();                      
                    }
                }
            }
        }
    //end admin part

    //part functions for Pages 
        function data_page_row($code_page){
            $con = connect_kv();

            $sql = "SELECT * FROM kv_pages WHERE code = '$code_page'";
            $res = mysqli_query($con,$sql);
            
            $row = mysqli_fetch_array($res,MYSQLI_ASSOC);

            $result = new PageData();

            $result->code = $row['code'];
            $result->name = $row['name'];
            $result->description = $row['description'];
            $result->section = $row['section'];
            $result->img = $row['photo'];

            return $result;
        }
//получить имя по индификатору id
        function get_name_from_id($p,$id){
            $con = connect_kv();
            $table_name = db_table_from_page($p);
            $sql = "SELECT * FROM $table_name WHERE id = '$id'";
            $res = mysqli_query($con,$sql);
            $row = mysqli_fetch_array($res,MYSQLI_ASSOC);
            mysqli_close($con);
            if($res){
                $name = $row['name'];
            }

            return $name;
        }
//получить строку по индификатору id        
        function get_row_by_id($p,$id){
            $con = connect_kv();
            $table_name = db_table_from_page($p);
            $sql = "SELECT * FROM $table_name WHERE id = '$id'";
            $res = mysqli_query($con,$sql);
            mysqli_close($con);
            $row = mysqli_fetch_array($res,MYSQLI_ASSOC);
            return $row;

        }
//функция добовления фото в БД ?????????????????????
        function re_write(){
            //прочитать весь список файлов во всех каталогах
            $path = "../img/";
            $extension_500 = "/*,w500.jpg";
            $extension_1200 = "/*,w1200.jpg";
            $res_glob = scandir($path,1);//Получает список файлов и каталогов, расположенных по указанному пути
            $dir_category = array();//массив категорий 
            $trips_category = array();//массив прохождения категорий
   
            
            foreach ($res_glob as $value){
                if($value != "." && $value != "..") {
                    $v_path = $path.$value;
                    if(is_dir($v_path)) {//Определяет, является ли имя файла директорией
                        array_push($dir_category, $v_path);//Добавляет один или несколько элементов в конец массива
                        array_push($trips_category, $value);//Добавляет один или несколько элементов в конец массива
                    }
                }
            }

            $array_trip_500 = array();//массив папки ../img c разделам по категориям
            $array_trip_1200 = array();//массив папки ../img c разделам по категориям
            

            foreach ($trips_category as $value){
                $v_path = $path.$value.$extension_500;
                $array_trip_500[$value] = glob($v_path);//Находит файловые пути, совпадающие с шаблоном --- ../img/1/*.jpg
                $v_path = $path.$value.$extension_1200;
                $array_trip_1200[$value] = glob($v_path);//Находит файловые пути, совпадающие с шаблоном --- ../img/1/*.jpg
           
            }

            $res = list_data('kv_photo');//подключаемся к базе
            

            $array_exist_500 = array();//массив сушествования файлов в папке ../img
            $array_exist_1200 = array();//массив сушествования файлов в папке ../img
           
            if (mysqli_num_rows($res) > 0) {
            // output data of each row--выходные данные каждой строки
                while($row = mysqli_fetch_assoc($res)) {//Извлекает результирующий ряд в виде ассоциативного массива из БД

                    foreach ($array_trip_500 as $key =>$array_value_500){

                        foreach ($array_value_500 as $i => $value_500){
                            if($row['url_500'] == $value_500){//$row['url_500']---вычитка из рядка url_500 БД, $value -- количество файлов в папке ../img/

                                array_push($array_exist_500, $value_500);//Добавляет один или несколько элементов в конец массива
                                unset($array_trip_500[$key][$i]);//Удаляет переменную
                            }
                        }
                    }
                    foreach ($array_trip_1200 as $key =>$array_value_1200){

                        foreach ($array_value_1200 as $i => $value_1200){
                            if($row['url_1200'] == $value_1200){//$row['url_1200']---вычитка из рядка url_500 БД, $value -- количество файлов в папке ../img/
                                array_push($array_exist_1200, $value_1200);//Добавляет один или несколько элементов в конец массива
                                unset($array_trip_1200[$key][$i]);//Удаляет переменную
                            }
                        }
                    }

                }
            }

            
            //Счетчик+добавление файлов в БД при их уделении из БД
            $count = 0;
            foreach ($array_trip_500 as $key =>$array_value_500){//$array_trip--массив из папки ../img/
               foreach ($array_value_500 as $i => $value_500){ 
                    re_write_sql($value_500, $value_1200, $key);//$key --- раздел фото в папке ../img/, $value -- содержание раздела
                    $count++;
                }
            }

            print_r("Added - ".$count." rows");
        }
    //end part functions for Pages 

//создаем массив фото
        function set_array_pages(){
            $res = list_data('kv_pages');
            $array_menu_pages = array();
            if (mysqli_num_rows($res) > 0) {
            // output data of each row
                while($row = mysqli_fetch_assoc($res)) {
                    $array_menu_pages[$row['code']] = $row['name'];
                }
            }
            return $array_menu_pages;
        }
//создаем массив поездок
        function set_array_trips(){
            $res = list_data('kv_categories');
            $array_menu_trips = array();
            if (mysqli_num_rows($res) > 0) {
            // output data of each row
                while($row = mysqli_fetch_assoc($res)) {
                    $array_menu_trips[$row['id']] = $row['name'];
                }
            }
            return $array_menu_trips;
        }
//Вычитка дополнительного текста по языку
        function set_array_settings($lang){
            $res = list_data('kv_settings');
            $array_settings = array();
            if (mysqli_num_rows($res) > 0) {
            // output data of each row
                while($row = mysqli_fetch_assoc($res)) {
                    $array_settings[$row['code']] = $row[$lang];
                }
            }
            return $array_settings;
        }
//???????
        function help_vars($array_sett, $var){
            if(isset($array_sett)){ 
                foreach($array_sett as $key => $value){
                    if($key == $var) {
                        return $value;
                    }
                }
            } else {/*
                switch($var){
                    case 'text_title_site': return "Видющенко КН-ФОТОГРАФ";
                        break;
                    case 'text_detail_body' : return "Тут должен был быть текст, но что то пошло не так...";
                        break;
                    
                    case 'text_no_img_category' : " In this category no one images found !";
                        break;
                    
                    case 'text_title' : "Constantin Vidyuschenko";
                        break;
                    case 'text_main' : "Constantin Vidyuschenko";
                        break;
                    case 'text_prof' : "photographer";
                        break;
                    case 'title_prof' : "photographer";
                        break;
                    case 'text_right' : "Фотограф путишественник";
                        break;
                    case 'text_contact' : "contact";
                        break;                            
                    case 'text_top_nav' : "ПОЕЗДКИ";
                        break;
                    case 'title_top_nav' : "Все поездки";
                        break;
                }*/
            }
        }
//функция для ПРЕДЗАГРУЗКИ фото в папку ../files
        function file_uploads(){
            # ВАЖНАЯ ИНФОРМАЦИЯ!

            # В вашем "php.ini" должны быть следующие три параметра:
            #
            # file_uploads = On
            #
            # ^ включаем поддержку загружаемых файлов.
            #
            # upload_tmp_dir = ПОЛНЫЙ_ПУТЬ_ДО_ПАПКИ_ГДЕ_БУДУТ_ХРАНИТЬСЯ_ЗАГРУЖАЕМЫЕ(ВРЕМЕННЫЕ)_ФАЙЛЫ
            #
            # ^ Например: upload_tmp_dir = d:/server/php/uploads
            #
            # и
            #
            # upload_max_filesize = 2M
            #
            # ^ Максимальный размер загружаемых файлов (в нашем случаем 2 МБ).

            // Куда сохраним файл?
            // Давайте в папке с этим скриптом,
            // создадим папку "files", туда-то и будем
            // сохранять все загружаемые файлы.

            //$path=GetCWD()."/files";
            $path="../files";

            // Проверяем на существование папку $path

            if(!file_exists($path))
            die("<b>Пожалуйста, создайте папку <font color=red>".$path."</font> и <a href=&#63;>повторите попытку загрузить файл</a>.</b>");

            // Выводим форму для загрузки файла.
            if(empty($_FILES['UserFile_500']['tmp_name']) && empty($_FILES['UserFile_1200']['tmp_name'])){
                echo "<form method=post enctype=multipart/form-data>
                    <div class = 'row' style='padding-bottom: 15px;'>Выберите файл с разрешение 500рх(w500):  <input type=file name=UserFile_500></div>
                    <div class = 'row' style='padding-bottom: 15px;'>Выберите файл с разрешение 1200рх(w1200):  <input type=file name=UserFile_1200></div>
                    <hr>
                    <div class = 'row' style='display:grid;' ><input type=submit value=Отправить></div>
                    </form>";

            }
            // Если один из файлов не был загружен по каким-то причинам, выводим ошибку.
            elseif(!is_uploaded_file($_FILES['UserFile_500']['tmp_name']) || !is_uploaded_file($_FILES['UserFile_1200']['tmp_name']))
               die("<b><font color=red>Один из файлв не был загружен! Попробуйте <a href=&#63;>повторить попытку</a>!</font></b>");
            // Если файл удачно загружён на сервер, делаем вот что...

            else {
                    // Переносим загружённый файл в папку $path

                if(@!copy($_FILES['UserFile_500']['tmp_name'],$path.chr(47).$_FILES['UserFile_500']['name']))
                  // Если не удалось перенести файл, выводим ошибку:
                   die("<b><font color=red>Файл с расширением 500рх(w500) не был загружен! Попробуйте <a href=&#63;>повторить попытку</a>!</font></b>");
                if(@!copy($_FILES['UserFile_1200']['tmp_name'],$path.chr(47).$_FILES['UserFile_1200']['name']))
                   // Если не удалось перенести файл, выводим ошибку:
                   die("<b><font color=red>Файл с расширением 1200рх(w1200) не был загружен! Попробуйте <a href=&#63;>повторить попытку</a>!</font></b>");   
                   // Если всё Ok, то выводим инфо. о загружённом файле.
                   else{
                        echo
                            "<center><b>Файл c расширением 500рх(w500) - <font color=red>".$_FILES['UserFile_500']['name']."</font> успешно загружён во временную папку - <b>files</b> !</font></b></center>".
                            "Тип файла: <b>".$_FILES['UserFile_500']['type']."</b><br>".
                            "Размер файла: <b>".round($_FILES['UserFile_500']['size']/1024,2)." кб.</b>".
                            "<hr>".
                            "<center><b>Файл с расширением 1200рх(w1200) - <font color=red>".$_FILES['UserFile_1200']['name']."</font> успешно загружён во временную папку - <b>files</b> !</font></b></center>".
                            "Тип файла: <b>".$_FILES['UserFile_1200']['type']."</b><br>".
                            "Размер файла: <b>".round($_FILES['UserFile_1200']['size']/1024,2)." кб.</b>";

                            $p = "Photos";
                            echo '<center><form action="/admin/create.php" method = "post">
                                <input type="hidden" id="p" name="p" value="'.$p.'">
                                <input type="hidden" id="url" name="url_500" value="'.$_FILES["UserFile_500"]["name"].'">
                                <input type="hidden" id="url" name="url_1200" value="'.$_FILES["UserFile_1200"]["name"].'">
                                <hr>
                                <div class = "row" style= "display:grid;"><input type="submit" value="Добавить файлы в проект"></div>
                            </form></center>';
                        }
            }
        }
//end set data vars from DB
//main_my
    // вычитываем таблицу kv_photo из б/д mysql_kv
    function get_single_img(){
        global $con;
        $single = $con->query("SELECT * FROM kv_photo");//достаем данные из таблифы kv_photo
        return $single;
       }

    //Выгрузка фото категорий по id
    function category_id($categories){
        global $con;
        $singl_id_category = "SELECT * FROM kv_photo WHERE category_id = '$categories'";//выборка по категории из таблифы kv_photo
        $id_categori= $con->query($singl_id_category);//извлекаем данные из таблифы kv_photo по категорям
        return $id_categori;
    }
    //функция считывания ЗАПРОСА
    function read_request(){
        $uri = $_REQUEST;
        $request_uri = $uri["categories"];
        return $request_uri;
    }
//slider_my
    //Функция расчета количество картинок   
    function ALLroow($categories) {
            global $con;
        if ($categories == "all") {//всего
            $result_all = mysqli_query($con, "SELECT COUNT(*) FROM kv_photo WHERE id");
            $namb_roow = mysqli_fetch_array( $result_all);
            return $namb_roow[0];
        }else{//по категориям
            $result = mysqli_query($con, "SELECT * FROM kv_photo WHERE category_id = '$categories'");
            $namb_roow = mysqli_num_rows($result);
            return $namb_roow;
        }
    }
    //Вычитываем названия категорий для вставки в слайдере - инфо панель
    function NameCategory($request){
        global $con;
        $singl_id_name_category = "SELECT * FROM kv_categories WHERE id = '$request'";//выборка по категории из таблифы kv_photo
        $NameCategory= $con->query($singl_id_name_category);//извлекаем данные из таблифы kv_photo по категорям
        return $NameCategory;          
    }      
    //Вычитываем информацию из kv_pages - выборка по содержанию - section
    function page_view($section){
        $con = connect_kv();
        $sql = "SELECT * FROM kv_pages where section = '$section' ";
        $res = mysqli_query($con, $sql);
        mysqli_close($con);
        return $res;
    }
    //функция вариантов отображения дополнительных страниц - контакт,обо мне, копирайтинг
    function page_see_nav($section, $array_menus){
        $pref = "";
        $a_class ="";
        $suf = "";
        $suf0 = "";

        switch($section){
            case 'nav':
                $pref = "<li>";
                $a_class ="sheet-inner-content-1";
                $suf = "</li>";
                veiw_section('nav',$array_menus,$pref,$a_class,$suf,$suf0);
                veiw_section('top+nav',$array_menus,$pref,$a_class,$suf,$suf0);
                veiw_section('nav+bottom',$array_menus,$pref,$a_class,$suf,$suf0);
                veiw_section('top+nav+bottom',$array_menus,$pref,$a_class,$suf,$suf0);
                break;
            case 'top':
                $a_class ="contact";
                veiw_section('top',$array_menus,$pref,$a_class,$suf,$suf0);
                veiw_section('top+nav',$array_menus,$pref,$a_class,$suf,$suf0);
                veiw_section('top+bottom',$array_menus,$pref,$a_class,$suf,$suf0);
                veiw_section('top+nav+bottom',$array_menus,$pref,$a_class,$suf,$suf0);
                break;
            case 'bottom':
                $a_class ="inner-content-3";
                veiw_section('bottom',$array_menus,$pref,$a_class,$suf,$suf0);
                veiw_section('nav+bottom',$array_menus,$pref,$a_class,$suf,$suf0);
                veiw_section('top+bottom',$array_menus,$pref,$a_class,$suf,$suf0);
                veiw_section('top+nav+bottom',$array_menus,$pref,$a_class,$suf,$suf0);
                break;
        }
      
    }
    //функция визуализации дополнительных страниц
    function veiw_section($section,$array_menus,$pref,$a_class,$suf,$suf0){
        $res = page_view($section);
        while($row = mysqli_fetch_assoc($res)) {
            if (($section == "bottom") && ($row['code'] =="copyright")){
                $suf0 = " © ".date('Y');
                
            }
            echo $pref."<a class=".$a_class." title=".$array_menus[$row['code']]." href=".$_SERVER['PHP_SELF']."?page=".$row['code'].">".$array_menus[$row['code']].$suf0."</a>".$suf;   
        }
    }
 //email my
 //Функция расчета количество писем   
 function ALLemail() {
    global $con;
   //всего
    $result_all_mail = mysqli_query($con, "SELECT COUNT(*) FROM kv_email WHERE id");
    $namb_roow_mail = mysqli_fetch_array( $result_all_mail);
    return $namb_roow_mail[0];
}
 //error my
 //Функция расчета количество ошибок   
 function ALLerror() {
    global $con;
   //всего
    $result_all_error = mysqli_query($con, "SELECT COUNT(*) FROM kv_error WHERE id");
    $namb_roow_error = mysqli_fetch_array( $result_all_error);
    return $namb_roow_error[0];
}
?>