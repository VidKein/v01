<?php
    //Все ошибки которые появляются в результате выполнения скрипта
    ini_set('display_errors', 'Off');//отображение на дисплее выключаем
    ini_set('log_errors', 'On');//отображение в логе включаем
    ini_set('error_log', $_SERVER['DOCUMENT_ROOT'] . '/logs/log_errors.log');//метод и путь перенаправления ошибок
    //ПОДГОТОВКА И ОТПРАКА ПИСЬМА  
     // обработка только ajax запросов (при других запросах завершаем выполнение скрипта)
   if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit();
    }
    // обработка данных, посланных только методом POST (при остальных методах завершаем выполнение скрипта)
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        exit();
    }  
    //Постоянные данные
    const TO = "vidkein75@gmail.com";//адресс получателя
    //Получаем данные
    $Subject = $_POST['Subject_sender'];//тема письма + кодируем в случае русского языка
    $From_name = $_POST['From_sender_name'];//имя отправителя + кодируем в случае русского языка
    //кодируем в случае русского языка
    $patern = "/([\x7F-\xFF][^<>\r\n]*)/s";//условия кодируем если наброно кирилицой
        if (preg_match($patern,$Subject)) {
            $Subject_ = '=?utf-8?b?'.base64_encode($Subject)."?=";
            }
            else{$Subject_ = $Subject;
                }
        if (preg_match($patern,$From_name)) {
            $From_name_ = '=?utf-8?b?'.base64_encode($From_name)."?=";
            }
            else{
                $From_name_ = $From_name;
                }         
    $From_mail = $_POST['From_sender_mail'];//e-mail отправителя
    $Body_letter = $_POST['Body_letter'];//сообшение
    $Date_letter = $_POST['Date_letter'];//дата отправления
    //Данные отправителя
    $headers  = 'From: ' . $From_name_ . ' <' . $From_mail . '>' . "\r\n";//имя + e-mail отправителя
    $headers .= 'Reply-To: '. $From_mail . "\r\n";//e-mail отправителя
    //Данные почтовой программы
    $headers .= 'X-Mailer: PHP/ '. phpversion() . "\r\n";
    // Устанавливаем заголовок Content-type+MIME-Version необходимый для отправки HTML-письма
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-Type: text/html; charset=utf-8' . "\r\n";
   
    //HTML -письмо
    $Letter = '
    <html>
    <head>
      <title>Сообшение пришло с сайта Constantin Vidyuschenko.</title>
    </head>
    <body>
            <table style="background-color:#f1f1f1; width:100%; text-align:center; width:100%; border:0" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td style="text-align:center; vertical-align:top; padding:30px 0; text-align:center">
                <table style="text-align:left; width:680px; margin:0 auto; font-size:14px; border-spacing:0px">
                    <tbody>
                    <tr>
                        <td style="padding: 15px; background-color::#fff">
                        <font style="color:#777; font-size:18px">' . $Subject . '</font>
                        </td>
                    </tr>
                    <tr>
                        <td style="height:25px"></td>
                    </tr>
                    <tr>
                        <td  style="padding: 15px; background-color:#fff">
        
                        Пользователь
                        <b>' . $From_name . '</b> оставил следующее сообщение:
                        <br><b>' . $Body_letter . '</b>
                        <hr> Email пользователя:
                        <b>' . $From_mail . '</b>
                        <br> Дата отправки:
                        <b>' . $Date_letter . '</b>
                        </td>
                    </tr>
                    <tr>
                        <td height="25"></td>
                    </tr>
                    <tr>
                        <td style="padding: 20px 15px; color: #777; font-size: 14px; background-color:#fff">
                        <p>&copy; 2021 Сообшение пришло с сайта -  <a href="http://'.$_SERVER['SERVER_NAME'].'/index.php">Constantin Vidyuschenko</a></p>
                        <img src = " http://'.$_SERVER['SERVER_NAME'].'/index.php?user_id = '.TO.'" width = "0" height = "0">
                        </td>
                    </tr>
                    </tbody>
                </table>
                </td>
            </tr>
            </tbody>
        </table>
    </body>
    </html>
    ';

    //Отправка письма
    if(mail(TO,//мой адрес - получатель
    $Subject_, //тема письма
    $Letter,//сообшение
    $headers)){//Письмо не отправлено
              $status = 'Письмо отправлено'; 
              }
              else{//Письмо отправлено
              $status ='Письмо не отправлено';              
              }
    //Подключаемся к бд
    try{
        $pdo = new PDO('mysql:host=localhost;dbname=mysql_kv',
                        'root',
                        '',
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING]);//Извлекает ошибки БД. Режим оброботки БД -ERRMODE_WARNING
    }
    catch(PDOException $e){
        echo "Невозможно установить связь с базой данных";
    }
    //connected to database
    $query = "INSERT INTO kv_email (id, subject, correspondent_name, correspondent_email, content, date, status) VALUES (NULL, '$Subject','$From_name', '$From_mail', '$Body_letter','$Date_letter', '$status');";
    $fail = $pdo -> query($query);    
?>