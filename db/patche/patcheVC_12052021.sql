-- Изменяем типа столбца date таблицу kv_email
ALTER TABLE `kv_email` CHANGE `date` `date` varchar(30) NOT NULL;
-- Изменяем название столбца correspondent -> correspondent_name таблицу kv_email
ALTER TABLE `kv_email` CHANGE `correspondent` `correspondent_name` varchar(30) NOT NULL;
ALTER TABLE `kv_email` ADD `correspondent_email` varchar(30) NOT NULL AFTER `correspondent_name`;
REPLACE INTO `kv_email` (`id`, `subject`, `correspondent_name`,`correspondent_email`,`content`, `date`, `status`) VALUES
(1, 'Тема сообшения', 'Имя отправителя', 'Email отправителя', 'Текст сообшения', 'Дата отправки', 'Статус-отправлен/не отправлен');
REPLACE INTO `kv_error` (`id`, `error`, `status`,`revision`) VALUES
(1, 'Ошибка с описанием', 'Статус - исправлена/не исправленна', 'Журнал изменений');