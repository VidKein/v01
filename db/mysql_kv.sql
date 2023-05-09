-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 30 2023 г., 14:46
-- Версия сервера: 10.3.22-MariaDB-log
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `mysql_kv`
--

-- --------------------------------------------------------

--
-- Структура таблицы `kv_categories`
--

CREATE TABLE `kv_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `kv_categories`
--

INSERT INTO `kv_categories` (`id`, `name`, `description`, `location`) VALUES
(1, 'Египет', 'Египет.', 'Синайский полуостров '),
(2, 'Животные', 'Животные.', 'Царство млекопитающихся'),
(3, 'Птицы', 'Птицы.', 'Царство птиц'),
(4, 'Архитектура', 'Фотографии строений.', 'Мир');

-- --------------------------------------------------------

--
-- Структура таблицы `kv_email`
--

CREATE TABLE `kv_email` (
  `id` int(11) NOT NULL,
  `subject` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correspondent_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correspondent_email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `kv_email`
--

INSERT INTO `kv_email` (`id`, `subject`, `correspondent_name`, `correspondent_email`, `content`, `date`, `status`) VALUES
(1, 'Тема сообшения', 'Имя отправителя', 'Email отправителя', 'Текст сообшения', 'Дата отправки', 'Статус-отправлен/не отправлен'),
(14, 'gg', 'Константин Видющенко', 'landdru@ukr.net', 'ggg', '15.05.2021, 21:41:49', ''),
(15, 'error', 'Константин Видющенко', 'uuuuks@yps.ua', 'error logs 2', '15.05.2021, 21:46:31', 'Письмо отправлено'),
(16, 'Письмо об разговоре', 'Елена Видющенко', 'lend@ukr.net', 'Если вы хотите обсудить фотографии, спросить о лицензировании изображения или узнать еще что-то, то заполните форму, я отвечу как можно скорее. С уважением Константин Видющенко.', '19.05.2021, 09:05:27', 'Письмо отправлено'),
(23, 'hellow', 'Hay', 'landdru@ukr.net', 'Hellow', '24.12.2021, 18:07:17', 'Письмо отправлено');

-- --------------------------------------------------------

--
-- Структура таблицы `kv_error`
--

CREATE TABLE `kv_error` (
  `id` int(11) NOT NULL,
  `error` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `revision` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `kv_error`
--

INSERT INTO `kv_error` (`id`, `error`, `status`, `revision`) VALUES
(1, 'Ошибка с описанием', 'Не исправленные', 'Журнал изменений'),
(2, 'Ошибка ввода', 'Не исправленное', 'IP - 123.32.36.36'),
(3, 'Ошибка переполнения', 'Не исправленное', 'Размер на сервере переполнен на 15мб'),
(4, 'Ошибка работы сервера', 'Не исправленное', '07.11.2021 с 11-00 по 16-00 сервер не работал');

-- --------------------------------------------------------

--
-- Структура таблицы `kv_pages`
--

CREATE TABLE `kv_pages` (
  `id` int(11) NOT NULL,
  `code` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `kv_pages`
--

INSERT INTO `kv_pages` (`id`, `code`, `name`, `description`, `section`, `photo`) VALUES
(1, 'contact', 'КОНТАКТЫ', 'Если вы хотите обсудить фотографии, спросить о лицензировании изображения или узнать еще что-то, то заполните форму, я отвечу как можно скорее. С уважением Константин Видющенко.', 'top+nav', 'img/aboyt/fox.jpg'),
(2, 'about', 'ОБО МНЕ', 'Всю свою жизнь мне было интересно наблюдать и наслаждаться красотой окружающего меня МИРА.\r\n<br><br>\r\nС появлением в моей жизни фотоаппарата я стал регулярно и неистово собирать и приумножать мой ФОТОАЛЬБОМ. С наслаждением и воодушевлением я находился в постоянном поиске различных направлений в фотоискустве.\r\n<br><br>\r\nМеня всегда удивляло ошибочное мнение людей, что для хорошего фото нужно ехать в экзотические страны. Рядом с нами находится столько удивительного, прекрасного и не вероятного - что дух захватывает.\r\n<br><br>\r\nВ связи с этим, я пытаюсь не акцентироваться на местности или на объекте, я стараюсь передать красоту и не повторимость окружающего мира, мира - которого я вижу рядом, пускай это будет мой двор, сад, а может завтра - глубины нашего океана.  \r\n<br><br>\r\nНадеюсь, вам понравится мой сайт! С уважением КОНСТАНТИН ВИДЮЩЕНКО!', 'nav', 'img/aboyt/Mai_foto.jpg'),
(3, 'copyright', 'Copyright', 'Надеюсь, вам понравится мой сайт.\r\n<br><br>\r\nКак и в случае со всеми творческими начинаниями, законы об авторском праве регулируют то, как может быть использован контент, который вы здесь найдете.\r\nВсе фотографии и изображения, размещенные в домене cvphotographer.com, являются исключительной собственностью Константина Видющенко и защищены законодательством Украины и международными законами об авторском праве.\r\nВсе изображения и текст, представленные на этом веб-сайте, являются исключительной собственностью Константина Видющенко. Весь контент не может быть загружен, кроме как через обычный процесс просмотра в браузере.\r\nКонтент не может быть скопирован на другой компьютер, передан, опубликован, воспроизведен, сохранен, обработан, спроецирован или изменен каким-либо образом, включая любую оцифровку или синтез изображений отдельно или с любым другим материалом, с использованием компьютера или другого электронного оборудования или любой другой метод или средство, известное сейчас или в будущем, без письменного разрешения Константина Видющенко в любой форме платно или бесплатно.\r\nНикакие изображения или текст не являются общественным достоянием. Использование любого изображения в качестве основы для другой фотографической концепции или иллюстрации является нарушением авторских прав.\r\nКонстантин Видющенко будет энергично защищать интересы авторских прав. В случае обнаружения нарушения вы получите уведомление и выставите счет на оплату, не менее чем в десять раз превышающую отраслевой стандарт, и/или привлечете к ответственности за нарушение авторских прав.\r\n<br><br>\r\nВход на этот сайт прямо на этих условиях, которые воплощают в себе все договоренности и обязательства между вовлеченными сторонами. Все записи регистрируются. Права на воспроизведение изображений могут быть получены посредством лицензирования. Пожалуйста, свяжитесь с Константином Видющенко, если у вас есть какие-либо вопросы об авторских правах.\r\n<br><br>\r\nСпасибо за уважение к моим авторским правам.С уважением Константин Видющенко!\r\n', 'bottom', '');

-- --------------------------------------------------------

--
-- Структура таблицы `kv_photo`
--

CREATE TABLE `kv_photo` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_500` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_1200` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `upload_photo` date NOT NULL,
  `update_photo` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `kv_photo`
--

INSERT INTO `kv_photo` (`id`, `name`, `url_500`, `url_1200`, `description`, `short_description`, `category_id`, `upload_photo`, `update_photo`) VALUES
(1, 'Лисенок у норы', '../img/2/A_2,w500.jpg', '../img/2/A_2,w1200.jpg', 'Лисенок у норы, греется на солнышке.', 'Лисенок греется на солнышке.', 2, '2021-01-26', '2022-01-25'),
(2, 'Лошади приживальского', '../img/2/A_3,w500.jpg', '../img/2/A_3,w1200.jpg', 'Лошади приживальского - дикие лошади в природе.', 'Лошади приживальского в степи Аскании-Нова', 2, '2020-11-20', '2021-03-10'),
(3, 'Зебра', '../img/2/A_4,w500.jpg', '../img/2/A_4,w1200.jpg', 'Зебра в природных условиях - степях Аскании-Нова', 'Зебра в степях Аскании-Нова', 2, '2020-11-20', '2021-04-26'),
(4, 'Лисята возле норы', '../img/2/A_5,w500.jpg', '../img/2/A_5,w1200.jpg', 'Лисята стоят возле норы и наблюдаюд за людьми.', 'Наблюдающие лисята', 2, '2020-11-21', '2021-03-10'),
(5, 'Крадущийся лисенок', '../img/2/A_6,w500.jpg', '../img/2/A_6,w1200.jpg', 'Свою первую добычу всегда хочется съесть самому.', 'Нашел добычу и прячется от сородичей', 2, '2020-11-21', '2021-03-10'),
(6, 'Трио лисят', '../img/2/A_9,w500.jpg', '../img/2/A_9,w1200.jpg', 'Вечером возле норы в ожидании ужина.', 'Вечером возле норы', 2, '2020-11-21', '2021-03-10'),
(7, 'А попеть', '../img/2/A_10,w500.jpg', '../img/2/A_10,w1200.jpg', 'Утренние распевки лисят.', 'Ещё маленькие, но территорию пытаются поделить', 2, '2020-11-21', '2021-03-10'),
(8, 'Йорик', '../img/2/A_12,w500.jpg', '../img/2/A_12,w1200.jpg', 'Первая в жизни фотосессия на природе.', 'Маленький Йорик - тайский ариенталь', 2, '2020-11-21', '2021-03-10'),
(9, 'Бегущие лисята', '../img/2/A_13,w500.jpg', '../img/2/A_13,w1200.jpg', 'Догонялки возле норы.', 'Лисята играются', 2, '2020-11-21', '2021-03-10'),
(10, 'Солнечные ванны', '../img/2/A14,w500.jpg', '../img/2/A14,w1200.jpg', 'Так приятно ранним утром погреться первыми солнечными лучами.', 'Лисенок принимает сонечные ванны', 2, '2020-11-21', '2021-03-10'),
(11, 'Потягушки', '../img/2/A15,w500.jpg', '../img/2/A15,w1200.jpg', 'Выспавшийся лисенок потягивается как котёнок.', 'Лисенок потягивается', 2, '2020-11-21', '2021-03-10'),
(12, 'Любопытство', '../img/2/A16,w500.jpg', '../img/2/A16,w1200.jpg', 'Лисенок разглядывает незнакомую вещь.', 'Лисенок разглядывает рюкзак', 2, '2020-11-21', '2021-03-10'),
(13, 'Лисята и стулка', '../img/2/A17,w500.jpg', '../img/2/A17,w1200.jpg', 'Кто первый нашёл - того и добыча.', 'Лисята никак не поделят добычу.', 2, '2020-11-21', '2021-03-10'),
(14, 'Три богатыря', '../img/2/A18,w500.jpg', '../img/2/A18,w1200.jpg', 'Вечером возле норы в ожидании ужина.', 'В ожидании ужина', 2, '2020-11-21', '2021-03-10'),
(15, 'Игры', '../img/2/A19,w500.jpg', '../img/2/A19,w1200.jpg', 'Лисята вечером играют возле норы.', 'Вечерние игры', 2, '2020-11-21', '2021-03-10'),
(16, 'Мы позируем', '../img/2/A20,w500.jpg', '../img/2/A20,w1200.jpg', 'Мы позируем на камеру.', 'Фотосессия', 2, '2020-11-21', '2021-03-10'),
(17, 'Скворец - на водопое', '../img/3/B1,w500.jpg', '../img/3/B1,w1200.jpg', 'Скворец принимает ванну.', 'Купаемся', 3, '2020-11-21', '2021-03-10'),
(18, 'Зяблик', '../img/3/B2,w500.jpg', '../img/3/B2,w1200.jpg', 'Принятие ванны в солнечный день. ', 'Зяблик принимает ванну', 3, '2020-11-21', '2021-03-10'),
(19, 'Аист на гнезде', '../img/3/B3,w500.jpg', '../img/3/B3,w1200.jpg', 'Пара аистов на гнезде перед тем, как отложить яйца.', 'Аист в период гнездования', 3, '2020-11-21', '2021-03-10'),
(20, 'Аист - самка и самец.', '../img/3/B4,w500.jpg', '../img/3/B4,w1200.jpg', 'Брачный танец на гнезде.', 'Аисты на гнезде', 3, '2020-11-21', '2021-03-10'),
(21, 'Аисты', '../img/3/B5,w500.jpg', '../img/3/B5,w1200.jpg', 'Аист танцует на гнезде перед самкой.', 'В предверии размножения', 3, '2020-11-21', '2021-03-10'),
(22, 'На подлете к гнезду', '../img/3/B6,w500.jpg', '../img/3/B6,w1200.jpg', 'Аист в полете', 'Призимляемся к гнезду в солнечный день.', 3, '2020-11-21', NULL),
(23, 'Парим в воздухе', '../img/3/B7,w500.jpg', '../img/3/B7,w1200.jpg', 'Птица применяет восходяшие потоки, для взлета с гнезда.', 'Аист набирает высоту.', 3, '2020-11-21', '2021-03-10'),
(24, 'Трясогузка', '../img/3/B8,w500.jpg', '../img/3/B8,w1200.jpg', 'Трясогузка после принятия ванн - сохнет.', 'Трясогузка возле водопоя', 3, '2020-11-21', '2021-03-10'),
(25, 'Щурки', '../img/3/B9,w500.jpg', '../img/3/B9,w1200.jpg', 'Самцы выделуются перед самками в период размножения.', 'Самцы в брачный период', 3, '2020-11-21', '2021-03-12'),
(26, 'Зимородок', '../img/3/B10,w500.jpg', '../img/3/B10,w1200.jpg', 'Зимородок на ветке после сытного обеда.', 'Зимородок на ветке', 29, '2020-11-21', '2022-01-25'),
(27, 'Завтрак с видом на пальмы.', '../img/1/E_1,w500.jpg', '../img/1/E_1,w1200.jpg', 'Завтракаем на терассе с видом на пальмы.', 'Класный вид с терассы.', 1, '2020-11-21', '2021-03-10'),
(28, 'Вид из окна.', '../img/1/E_2,w500.jpg', '../img/1/E_2,w1200.jpg', 'Место для релоксации в отеле. Ранне утро, когда посетители спят.', 'Место для релоксации.', 1, '2020-11-21', '2021-03-10'),
(29, 'Восточные сладости', '../img/1/E_3,w500.jpg', '../img/1/E_3,w1200.jpg', 'Сладости ну просто пальчики оближеш.', 'Вкусняшки', 1, '2020-11-21', '2021-03-10'),
(30, 'Вид из номера', '../img/1/E_4,w500.jpg', '../img/1/E_4,w1200.jpg', 'Весна в Египте.', 'Пальмы за окном', 1, '2020-11-21', '2021-03-10'),
(31, 'Релоксация', '../img/1/E_5,w500.jpg', '../img/1/E_5,w1200.jpg', 'Класное место для созерцания.', 'Смотрим и отдыхаем', 1, '2020-11-21', '2021-03-10'),
(32, 'Пальмы и море.', '../img/1/E_6,w500.jpg', '../img/1/E_6,w1200.jpg', 'Пляж с шезлонгами возле отеля. Утро - средний бал на море. ', 'Место для загара. Весна в Египте.', 1, '2020-11-21', '2021-03-10'),
(33, 'Фикус и лестница', '../img/1/E_7,w500.jpg', '../img/1/E_7,w1200.jpg', 'Интерьер отеля в Египте весной.\r\n', 'Дорога на море', 1, '2020-11-21', '2021-03-10'),
(34, 'Место для двоих', '../img/1/E_8,w500.jpg', '../img/1/E_8,w1200.jpg', 'Тихо и спокойно. Весна в отеле.', 'Весенний пейзаж. Египет.', 1, '2020-11-21', '2021-03-10'),
(35, 'Чайное дерево', '../img/1/E_9,w500.jpg', '../img/1/E_9,w1200.jpg', 'В родной среде, чайное дерево вырастает до второго этажа.', 'Чайное дерево в цветах', 1, '2020-11-21', '2021-03-10'),
(36, 'Гостиница вечером', '../img/1/E_10,w500.jpg', '../img/1/E_10,w1200.jpg', 'Вечером возле басейна.', 'Релаксация возле бассейна', 1, '2020-11-21', '2021-03-10'),
(37, 'Дорога вдоль фикусов.', '../img/1/E11,w500.jpg', '../img/1/E11,w1200.jpg', 'Интерьер гостиницы в Египте весной', 'Место для прогулок', 1, '2020-11-21', '2021-03-10'),
(38, 'Пальмы', '../img/1/E12,w500.jpg', '../img/1/E12,w1200.jpg', 'Огромные Египетчкие пальмы весной.', 'Пальмы весной', 1, '2020-11-21', '2021-03-10'),
(39, 'Цветущее дерево', '../img/1/E13,w500.jpg', '../img/1/E13,w1200.jpg', 'Пейзаж возле номера.', 'Египетский пейзаж весной', 1, '2020-11-21', '2021-03-10'),
(40, 'Завтрак на террасе', '../img/1/E14,w500.jpg', '../img/1/E14,w1200.jpg', 'Хорошо наедаемся перед отдыхом на море.', 'Еда в Египте', 1, '2020-11-21', '2021-03-10'),
(41, 'Пальмы и фонари', '../img/1/E15,w500.jpg', '../img/1/E15,w1200.jpg', 'Вечерняя прогулка по Весеннему Египту.', 'Фонари и пальмы', 1, '2020-11-21', '2021-03-10'),
(42, 'Саженец пальмы', '../img/1/E16,w500.jpg', '../img/1/E16,w1200.jpg', 'Одна из разновидностей пальм.', 'Отросток царской пальмы', 1, '2020-11-21', '2021-03-10'),
(43, 'Интерьер в Гостинице', '../img/1/E17,w500.jpg', '../img/1/E17,w1200.jpg', 'Холл гостиницы в Восточном стиле.', 'Холл утром, когда никого нет. ', 1, '2020-11-21', '2021-03-10'),
(44, 'Восточный стиль', '../img/1/E18,w500.jpg', '../img/1/E18,w1200.jpg', 'Весенний экстерьер гостиницы в Восточном стиле.', 'Египетский стиль', 1, '2020-11-21', '2021-03-10'),
(45, 'Шармаль-Шейх', '../img/1/E19,w500.jpg', '../img/1/E19,w1200.jpg', 'Дорога в Шарм-эль-Шейх. Весна в Египте.', 'Будничные дни в городе  Шарм-эль-Шейх.', 1, '2020-11-21', '2021-03-10'),
(46, 'Молодая пальма.', '../img/1/E20,w500.jpg', '../img/1/E20,w1200.jpg', 'Экстерер в гостиницы Египда весной.', 'Зелень весной в Египде.', 1, '2020-11-21', '2021-01-25'),
(47, 'Красное море', '../img/1/E21,w500.jpg', '../img/1/E21,w1200.jpg', 'Корабли на море...', 'Девушка у моря', 1, '2021-01-25', '2021-03-10'),
(90, 'Мечеть.', '../img/4/C1,W500.jpg', '../img/4/C1,W1200.jpg', 'Мечеть Мустафы в старой части города Шарм-эш-Шейхе, Египет', 'Мечеть Мустафы', 4, '2022-01-24', '2022-01-24'),
(91, 'Коптская церковь.', '../img/4/C2,W500.jpg', '../img/4/C2,W1200.jpg', 'Коптская церковь.Собор в Шарм-эш-Шейхе, Египет', 'Современная Коптская церковь в Шарм-эш-Шейхе, Египет.', 4, '2022-01-24', NULL),
(92, 'Копская церковь.', '../img/4/C3,W500.jpg', '../img/4/C3,W1200.jpg', 'Витражи в Копской церкви', 'Витражи в Копской церкви', 4, '2022-01-24', NULL),
(97, 'Часовня в Палестине', '../img/29/C6,w500.jpg', '../img/29/C6,w1200.jpg', 'Доевние улочки', 'Доевние улочки в Палестине. ', 29, '2022-01-25', '2022-02-01');

-- --------------------------------------------------------

--
-- Структура таблицы `kv_roles`
--

CREATE TABLE `kv_roles` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `access` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `kv_roles`
--

INSERT INTO `kv_roles` (`id`, `name`, `access`, `comment`) VALUES
(1, 'Admin', '-1', 'access for all data'),
(2, 'Manager', '3', 'not can works with users'),
(3, 'User', '5', 'can change just yourself'),
(4, 'Guest', '0', 'no access to admin');

-- --------------------------------------------------------

--
-- Структура таблицы `kv_settings`
--

CREATE TABLE `kv_settings` (
  `id` int(11) NOT NULL,
  `code` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ru` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ua` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `en` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `kv_settings`
--

INSERT INTO `kv_settings` (`id`, `code`, `ru`, `ua`, `en`) VALUES
(1, 'text_title_site', 'Видющенко КН-ФОТОГРАФ', 'Видющенко КМ-ФОТОГРАФ', ' Vidyushchenko KN-PHOTOGRAPHER'),
(2, 'text_detail_body', 'Тут должен был быть текст, но что то пошло не так...', 'Тут должен был быть текст, но что то пошло не так...', 'Тут должен был быть текст, но что то пошло не так...'),
(3, 'text_no_img_category', 'Извините пока раздел пуст. Фотограф находится в поисках КОНТЕНТА !!!', ' Вибачте поки розділ порожній. Фотограф знаходиться в пошуках КОНТЕНТУ !!!', 'Sorry, this section is empty. The photographer is looking for CONTENT !!!'),
(4, 'text_title', 'Constantin Vidyuschenko', 'Constantin Vidyuschenko', 'Constantin Vidyuschenko'),
(5, 'text_main', 'Constantin Vidyuschenko', 'Constantin Vidyuschenko', 'Constantin Vidyuschenko'),
(6, 'text_prof', 'photographer', 'photographer', 'photographer'),
(7, 'title_prof', 'Все разделы', 'Все разделы', 'Все разделы'),
(8, 'text_right', 'Фотограф путешественник', 'Фотограф путешественник', 'Фотограф путешественник'),
(9, 'text_contact', 'contact', 'contact', 'contact'),
(10, 'text_top_nav', 'ВСЕ РАЗДЕЛЫ', 'ВСЕ РАЗДЕЛЫ', 'ВСЕ РАЗДЕЛЫ'),
(11, 'title_top_nav', 'Все разделы', 'Все разделы', 'Все разделы');

-- --------------------------------------------------------

--
-- Структура таблицы `kv_users`
--

CREATE TABLE `kv_users` (
  `id` int(11) NOT NULL,
  `login` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nikname` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdate` date DEFAULT NULL,
  `updatedate` datetime DEFAULT NULL,
  `roles` int(11) NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastlogin` datetime DEFAULT NULL,
  `lastexit` datetime DEFAULT NULL,
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `kv_users`
--

INSERT INTO `kv_users` (`id`, `login`, `password`, `nikname`, `createdate`, `updatedate`, `roles`, `email`, `lastlogin`, `lastexit`, `user_activation_key`) VALUES
(1, 'admin_K', '123456', 'VidKein', '2020-09-23', '2022-04-24 13:03:22', 1, 'landdru@ukr.net', '2023-04-30 14:27:22', '2023-04-30 14:29:28', ''),
(2, 'mr_dx10', '654321', 'tema 1010', '2020-09-23', '2022-01-04 17:37:17', 2, 'artemlukashenkox10@gmail.com', '2022-04-24 13:04:07', '2022-04-24 13:27:59', ''),
(41, 'admin_R', '00001', 'Ric', '2022-01-12', '2023-04-09 08:59:20', 3, 'ric@dogs.com', '2023-04-21 18:07:30', '2023-04-21 18:07:49', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `kv_categories`
--
ALTER TABLE `kv_categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `kv_email`
--
ALTER TABLE `kv_email`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `kv_error`
--
ALTER TABLE `kv_error`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `kv_pages`
--
ALTER TABLE `kv_pages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `kv_photo`
--
ALTER TABLE `kv_photo`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `kv_roles`
--
ALTER TABLE `kv_roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `kv_settings`
--
ALTER TABLE `kv_settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `kv_users`
--
ALTER TABLE `kv_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `kv_categories`
--
ALTER TABLE `kv_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `kv_email`
--
ALTER TABLE `kv_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `kv_error`
--
ALTER TABLE `kv_error`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `kv_pages`
--
ALTER TABLE `kv_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT для таблицы `kv_photo`
--
ALTER TABLE `kv_photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT для таблицы `kv_roles`
--
ALTER TABLE `kv_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `kv_settings`
--
ALTER TABLE `kv_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `kv_users`
--
ALTER TABLE `kv_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
