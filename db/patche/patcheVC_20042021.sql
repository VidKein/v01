-- Добавляем таблицу kv_email
CREATE TABLE `kv_email` (
  `id` int(11) NOT NULL,
  `subject` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correspondent` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `status` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `kv_email`
--

INSERT INTO `kv_email` (`id`, `subject`, `correspondent`,`content`, `date`, `status`) VALUES
(1, 'Сайт обновлен', 'Лукашенко', 'тест н 2', '2020-04-06', 'Получен');

-- Добавляем таблицу kv_error
CREATE TABLE `kv_error` (
  `id` int(11) NOT NULL,
  `error` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `revision` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `kv_email`
--

INSERT INTO `kv_error` (`id`, `error`,`status`,`revision`) VALUES
(1, 'Ощибка соединения', 'Исправлена', 'Ошибка сама собой исправилась');

--
-- Индексы сохранённых таблиц
--
--
-- Индексы таблицы `kv_settings`
--
ALTER TABLE `kv_email`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `kv_error`
--
ALTER TABLE `kv_error`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--
--
-- AUTO_INCREMENT для таблицы `kv_settings`
--
ALTER TABLE `kv_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT для таблицы `kv_error`
--
ALTER TABLE `kv_error`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;