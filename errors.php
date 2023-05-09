<?php
$codes = array(
       400 => array('400. Ошибочный запрос', 'Запрос не может быть обработан из-за синтаксической ошибки.'),
       403 => array('403. Доступ запрещен', 'Сервер отказывает в выполнении вашего запроса.', 'Пожалуйста перейдите на главную страницу.', 'http://'.$_SERVER['SERVER_NAME']),
       404 => array('404. Страница не найдена', 'Запрашиваемая страница не найдена на сервере. Попытайтесь правильно ввести адрес.', 'Или вернитесь на главную страницу.', 'http://'.$_SERVER['SERVER_NAME']),
       405 => array('405. Метод не допускается', 'Указанный в запросе метод не допускается для заданного ресурса.'),
       408 => array('408. Время ожидания истекло', 'Ваш браузер не отправил информацию на сервер за отведенное время.'),
       500 => array('500. Внутренняя ошибка сервера', 'Запрос не может быть обработан из-за внутренней ошибки сервера.'),
       502 => array('502. Плохой шлюз', 'Сервер получил неправильный ответ при попытке передачи запроса.'),
       504 => array('504. Истекло время ожидания шлюза', 'Вышестоящий сервер не ответил за установленное время.'),
);

if (isset($_SERVER['REDIRECT_STATUS'])){
    $status = $_SERVER['REDIRECT_STATUS'];
    $title = ' '.$codes[$status][0];
    $message = $codes[$status][1];
    $actions = $codes[$status][2];
    $adress = $codes[$status][3];
    }

if(!isset($title)){
    $title = $message = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status codes ERROR...</title>
    <link href="/fonts/fontawesome/css/all.min.css" type="text/css" rel="stylesheet"><!--Подключаем Font awesome 5/Иконки-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:700&display=swap&subset=cyrillic-ext" rel="stylesheet"><!--Шрифты googleapis-->
    <link rel="stylesheet" href="/css/errors.css">
</head>
<body>

    <div class="errors">
    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="exclamation-triangle" class="svg-inline--fa fa-exclamation-triangle fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="red" d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"></path></svg>
        <h3>Внимание! Обнаружена ошибка <?=$title; ?>!</h3>
        <h3><?=$message; ?></h3>
        <h3><?=$actions; ?></h3>
        <h3><a href="<?= $adress; ?>"><?= $adress; ?></a><h3>
    </div>
</body>
</html>
