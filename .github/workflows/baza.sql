-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 09 2025 г., 21:26
-- Версия сервера: 8.0.19
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `forumdb`
--
CREATE DATABASE IF NOT EXISTS `forumdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `forumdb`;

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `post_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `content` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `content`, `created_at`) VALUES
(2, 14, 48, 'oxo', '2025-04-25 15:47:36'),
(3, 15, 48, 'anekey', '2025-04-25 15:50:52'),
(4, 15, 48, 'sonday', '2025-04-25 15:51:01'),
(5, 15, 48, 'endi ne qilamiz\r\n', '2025-04-25 17:52:24'),
(6, 16, 50, 'qalaysan', '2025-04-29 15:43:51'),
(7, 17, 51, 'oxo', '2025-04-29 16:44:40');

-- --------------------------------------------------------

--
-- Структура таблицы `likes_dislikes`
--

CREATE TABLE `likes_dislikes` (
  `id` int NOT NULL,
  `post_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `like_dislike` enum('like','dislike') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `likes_dislikes`
--

INSERT INTO `likes_dislikes` (`id`, `post_id`, `user_id`, `like_dislike`) VALUES
(4, 14, 48, 'like'),
(5, 15, 48, 'like'),
(6, 16, 50, 'like'),
(7, 16, 51, NULL),
(8, 19, 51, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `content` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `content`, `created_at`) VALUES
(14, 48, 'diyarbek', '2025-04-25 15:47:23'),
(15, 48, 'bul men', '2025-04-25 15:50:40'),
(16, 50, 'salemler\r\n\r\n\r\n', '2025-04-29 15:43:35'),
(17, 50, 'sol', '2025-04-29 15:44:24'),
(18, 51, 'qalay', '2025-04-29 16:45:47'),
(19, 51, 'qalay', '2025-04-29 16:46:10'),
(20, 56, 'salem', '2025-05-02 18:41:50');

-- --------------------------------------------------------

--
-- Структура таблицы `post_images`
--

CREATE TABLE `post_images` (
  `id` int NOT NULL,
  `post_id` int DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `post_images`
--

INSERT INTO `post_images` (`id`, `post_id`, `image_path`) VALUES
(3, 14, 'uploads/1745596043_120_140_90_1926720468.jpg'),
(4, 15, 'uploads/1745596240_DSC_0013.JPG'),
(5, 17, 'uploads/1745941464_Снимок экрана (1).png'),
(6, 19, 'uploads/1745945170_Снимок экрана (11).png');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(48, NULL, 'otkir@gmail.com', '$2y$10$0u.ixkf0mbB3WtbQvI5Kiuhb1tze5ElDCbOHQw5qjWjSGxNZrYBZe'),
(50, NULL, 'qudiyar@gmail.com', '$2y$10$ODSFamqPcsEVVJqDgmLQWuMSF8L748HwKJ0hXO3Kd8NDUFuxQWDb2'),
(51, NULL, 'asadd@gmail.com', '$2y$10$4C1J0qGrvrXpBB.eiqoRZOjXFJlFwxd3V.Uc35msJEcjX/qgpLMTO'),
(53, 'atash', 'atabek1@gmail.com', 'atash123'),
(55, NULL, 'atash@gmail.com', '$2y$10$GIxsp.rG3DX.ACQpB/Z/6.CYTl.n2Zb1bHlZOHNSmbWkvPcCAlTR2'),
(56, NULL, 'aybek@gmail.com', '$2y$10$CAnhCmj4/TlG8E7iRzCeRe6DYaTQq7nVRxJAfuLG..ej/jmZlgTku');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `likes_dislikes`
--
ALTER TABLE `likes_dislikes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `post_images`
--
ALTER TABLE `post_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `likes_dislikes`
--
ALTER TABLE `likes_dislikes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `post_images`
--
ALTER TABLE `post_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `likes_dislikes`
--
ALTER TABLE `likes_dislikes`
  ADD CONSTRAINT `likes_dislikes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `likes_dislikes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `post_images`
--
ALTER TABLE `post_images`
  ADD CONSTRAINT `post_images_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);
--
-- База данных: `freelancermarket`
--
CREATE DATABASE IF NOT EXISTS `freelancermarket` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `freelancermarket`;

-- --------------------------------------------------------

--
-- Структура таблицы `applications`
--

CREATE TABLE `applications` (
  `id` int NOT NULL,
  `job_id` int NOT NULL,
  `freelancer_id` int NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `applications`
--

INSERT INTO `applications` (`id`, `job_id`, `freelancer_id`, `message`, `created_at`) VALUES
(3, 22, 10, 'awa bilemen biraq stajim 2 ay', '2025-05-07 11:25:51'),
(4, 21, 10, 'murojat qiling', '2025-05-07 11:57:28');

-- --------------------------------------------------------

--
-- Структура таблицы `jobs`
--

CREATE TABLE `jobs` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(100) NOT NULL,
  `employer_id` int NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `description`, `category`, `employer_id`, `budget`, `created_at`) VALUES
(21, 'Web sayt dizayni', 'Yangi startap uchun zamonaviy landing page kerak. Figma dizayni kerak.', 'web', 2, '500.00', '2025-05-06 19:38:15'),
(22, 'PhotoShop', 'PhotoShop CorelDraw programmalarin paydalanip biliwi ham staji kerek (keminde 3 ay) ayliq kelisimli ham sagt waqti azangi 9:00 dan keshki 18:00', 'dizayn', 9, '200.00', '2025-05-07 06:02:54');

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `message` text NOT NULL,
  `sent_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `sent_at`) VALUES
(7, 9, 10, 'salem Diyar', '2025-05-07 11:27:02'),
(8, 9, 9, 'alo', '2025-05-07 11:27:15'),
(9, 9, 9, 'alo', '2025-05-07 11:39:30'),
(10, 9, 9, '1', '2025-05-07 11:42:38'),
(11, 9, 10, 'alo', '2025-05-07 11:50:25'),
(12, 10, 2, 'alo', '2025-05-07 11:57:40'),
(13, 2, 10, 'salem', '2025-05-07 11:58:17');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('freelancer','employer') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'OTKIRBEK', 'otkir@gmail.com', '$2y$10$GayqBokYS3VVWdeZaC0AHO9sSbP7jfB3l/CXGER1T3u5IjYc7Yy.i', 'freelancer', '2025-05-06 18:31:59'),
(2, 'batir', 'batir@gmail.com', '$2y$10$M3watKM5aK6NSGTnnj85..VouE8qerDONb9WyVU2UXqvqiYuxeSd2', 'employer', '2025-05-06 19:30:27'),
(9, 'Qudiyar', 'qudiyar@gmail.com', '$2y$10$7/K4swdatUG0ggAGsWt2fuQ78xq01SthrRWvhkFk.4TX6PQRSJiDC', 'employer', '2025-05-07 05:59:26'),
(10, 'diyar', 'diyar@gmail.com', '$2y$10$13Rf9W3GjppJCCdBBekI3uAVHYdAemHUx1pn257TAqm/fE4TR/mH6', 'freelancer', '2025-05-07 06:24:52');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `freelancer_id` (`freelancer_id`);

--
-- Индексы таблицы `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employer_id` (`employer_id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`),
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`freelancer_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`employer_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);
--
-- База данных: `newspaper`
--
CREATE DATABASE IF NOT EXISTS `newspaper` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `newspaper`;

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `news_id` int NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `comment` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `news_id`, `username`, `email`, `comment`, `created_at`) VALUES
(17, 1, 'Admin', '', 'yaxshi xabar ekan\r\n', '2025-05-09 17:44:13'),
(18, 2, 'Admin', '', 'jaqsigo\r\n', '2025-05-09 18:06:08');

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `message` text,
  `sender` enum('user','admin') NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `username`, `message`, `sender`, `created_at`) VALUES
(1, 'Batir', 'alo', 'user', '2025-05-09 17:28:01'),
(2, 'Batir', 'haw', 'admin', '2025-05-09 17:29:14'),
(3, 'diyar', 'men diyarman', 'user', '2025-05-09 17:42:57'),
(4, 'diyar', 'bilemen', 'admin', '2025-05-09 17:43:53'),
(5, 'diyar', 'ok', 'user', '2025-05-09 22:48:49');

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `category` varchar(100) DEFAULT 'Umumiy'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `image`, `created_at`, `category`) VALUES
(1, 'Franklin Templeton O‘zbekiston davlat aktivlarini xalqaro bozorlarda ro‘yxatga kiritadi', 'Franklin Templeton 2026-yil boshiga qadar O‘zbekistonning $1,7 milliardlik davlat aktivlarini xalqaro bozorlarda ro‘yxatga kiritishni rejalashtirmoqda. Bu tashabbus mamlakat iqtisodiyotini liberallashtirish va global investorlarni jalb qilish strategiyasining bir qismidir', '1746812354_One_Franklin_Parkway.jpg', '2025-05-09 17:50:37', 'Texnologiya'),
(2, 'Toshkentdagi Olimpiya shaharchasi boshqaruv kompaniyasi bilan ekspluatatsiya qilinadi', 'Toshkentdagi Olimpiya shaharchasi boshqaruv kompaniyasi bilan ekspluatatsiya qilinadi:\r\nToshkentdagi Olimpiya shaharchasini ekspluatatsiya qilish uchun boshqaruv kompaniyasi jalb etiladi. Bu kompaniya sport majmualarini saqlash, ommaviy tadbirlarni tashkil etish va ijara xizmatlarini ko‘rsatish bilan shug‘ullanadi. ', '1746812335_5Z6A6952-scaled.jpg', '2025-05-09 18:28:29', 'Texnologiya'),
(3, '❗️Айырым исбилерменлерге төлеген салығының бир бөлеги қайтарып бериледи', 'Министрлер Кабинети тәрепинен тастыйықланған ўақтыншалық нызамға муўапық (https://lex.uz/ru/pdfs/7206097), усы жылдың 1-октябринен баслап, туроператорлық ҳәм мийманхана хызметлерин көрсетиўши исбилерменлерге бюджетке төленген салықтың 20 проценти қайтарылыўы басланды.\r\n\r\n2025-жыл 1-январдан баслап болса, улыўма аўқатланыў хызметлерин көрсетиўши исбилерменлик субектлерине айлық товарларды (хызметлерди) реализациялаў бойынша айланысының нақ пульсыз бөлеги:\r\n\r\n➖ 60 процент ҳәм оннан жоқары болса — бюджетке төленген салықтың 40 проценти;\r\n➖ 60 проценттен аз болғанда — бюджетке төленген салықтың 20 проценти қайтарылады.\r\n\r\nИсбилерменлик субекти салық есабатын усыныўдан соң, бирақ 3 айдан кешиктирмей салықтың бир бөлегин қайтарыў ушын мүрәжат етиўге ҳақылы.\r\n\r\nБул нызам  2028-жыл 1-январға шекем әмел етеди.', '1746814138_photo_2025-05-09_23-08-13.jpg', '2025-05-09 23:08:58', 'Siyosat'),
(4, '9-май – Еслеў ҳәм қәдирлеў күни', 'Бүгин жүрегимизде мақтаныш, көзлеримизде болса миннетдаршылық жаслары. Ҳәр жылы 9-май – Еслеў ҳәм қәдирлеў күни сыпатында белгиленеди. Бул сәне қәлбимизде терең из қалдырған, бийбаҳа мәртлик үлгилерин еске салатуғын, тарийхты умытпаўға шақыратуғын муқаддес күн.\r\n\r\nБул күн – бизге тыныш турмыс, ашық аспан, еркинлик ҳәм бахытлы келешекти мийрас етип қалдырған ата-бабаларымызды ҳүрмет пенен еслеў күни. Урыстың аўыр жыллары, сабыр-тақат, пидайылық ҳәм мәртлик – булардың барлығы бүгинги күнимиздиң тийкары.\r\n\r\nӨткенлерди естелик пенен, тирилерди болса ҳүрмет пенен еске алайық. Олардың мәртлиги, сабыры ҳәм пидайылығы алдында бас ийемиз (https://t.me/karinformuz/11588).', '1746814338_photo_2025-05-09_23-11-59.jpg', '2025-05-09 23:12:18', 'Siyosat'),
(5, 'Қайсы мәўсимлик жумыслар толық бир жыл мийнет стажына өтеди?', 'Пахта тазалаў  кәрханаларында пахта тазалаў менен байланыслы төмендеги жумысларда  толық бир мәўсим ислеў  пенсия тайынлаў ушын бир жыл мийнет стажына өтеди: (https://lex.uz/docs/6236060#6239566)\r\n➖пахтаны кептириў;\r\n➖пахтаны тазалаў;\r\n➖пахтаны жүклеў, түсириў;\r\n➖пахтаны пневмотранспортқа артыў;\r\n➖кептириў-тазалаў цехын жыйнастырыў ҳәм ысытыў, ислеп шығарыў шығындыларын шығарып таслаў.', '1746814444_photo_2025-05-09_23-13-37.jpg', '2025-05-09 23:14:04', 'Siyosat'),
(6, '❓Егер инсан аз уйықласа, қандай кеселликлер пайда бола баслайды?', '➖ Ҳәлсизлик;;\r\n➖ Есте сақлаў жаманласады;\r\n➖ Териси қартайып баслайды;\r\n➖ Қан басымы көтериледи;\r\n➖ Қантлы диабетке шалыныў қәўипи артады;\r\n➖ Иммунитети төменлейди;\r\n➖ Жүрек кеселликлерине дуўшар болиўға бейимлилик артады.', '1746814623_photo_2025-05-09_23-16-41.jpg', '2025-05-09 23:17:03', 'Siyosat'),
(7, '❓Жәми 14 тәлим бағдары ушын сыртқы қабыллаў жабылғанын билесиз бе?', 'Президент қарары менен педагог кадрларды таярлаўшы ЖООның қосымшада көрсетилген 14 тәлим бағдары бойынша сыртқы тәлим формасына қабыллаў әмелге асырылмайды. (https://t.me/bilimlendiriw_uz/1518) Олар:\r\n\r\n60110600 — Математика ҳәм информатика;\r\n60110700 — Физика ҳәм астрономия;\r\n60110800 — Химия;\r\n60110900 — Биология;\r\n60111000 — География ҳәм экономикалық билим тийкарлары;\r\n60111400 — Өзбек тили ҳәм әдебияты;\r\n60111500 — Ана тили ҳәм әдебияты (тиллер бойынша);\r\n60111600 — Өзге тилли топарларда өзбек тили;\r\n60111700 — Өзге тилли топарларда рус тили;\r\n60111800 — Шет тили ҳәм әдебияты (тиллер бойынша);\r\n60112000 — Шақырыўға шекемги әскерий билимлендириў;\r\n60112500 — Мектеп менеджменти;\r\n60112600 — Мектепке шекемги ҳәм баслаўыш билимлендириўде шет тили (тиллер бойынша);\r\n60112700 — Арнаўлы педагогика (хызмет түрлери бойынша).\r\n\r\n\r\nБул тәртип республикадағы барлық мәмлекетлик ҳәм мәмлекетлик емес жоқары оқыў орынлары ушын тийисли.', '1746814722_photo_2025-05-09_23-18-24.jpg', '2025-05-09 23:18:42', 'Siyosat'),
(8, '❗️🎓 Ендигиден былай шыпакер болыў 10 есе қыйынласады', 'Президент медицина қәнигелерин таярлаўды пүткиллей өзгертиўди тапсырды. Буннан былай барлық медицина мектеплериниң питкериўшилери еркин имтихан тапсырыўы керек. Университет оқытыўшылары енди имтиханларға араласа алмайды!\r\n\r\nБул имтиханды тек ғана студентлер емес, ал әмелиятшы шыпакер ҳәм мийирбийкелер де тапсырады.', '1746814802_photo_2025-05-09_23-19-43.jpg', '2025-05-09 23:20:02', 'Siyosat');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `username`, `is_admin`) VALUES
(11, 'otkir@gmail.com', '$2y$10$gpo7OgtBLcyzJA1gaqHn7OT1sc3GkAeGvg/UhEB.Vj.wkA2.2qz7q', 'Admin', 1),
(12, 'batir@gmail.com', '$2y$10$ERpFacVW1/AuZ68JJAV0beTU2c1bhuxp2Krfo.m48qMoj.QfgD6j.', 'Batir', 0),
(13, 'diyar@gmail.com', '$2y$10$.zq.eJfDPUY8aaNqc..XmucgvWNzmsg8RjIPUwX5qciYGzY3YJ.OK', 'diyar', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
