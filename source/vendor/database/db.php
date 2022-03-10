<?php

$mysql = mysqli_connect(
    '127.0.0.1',
    'host1380908_reen',
    'jon35015',
    'host1380908_reensq'
) or die(mysqli_error($mysql));

#===== ОНЛАЙН ПОЛЬЗОВАТЕЛИ ======#
$online_tab = "CREATE TABLE `online` (
      `id` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `ip` TEXT COLLATE utf8_general_ci NOT NULL,
      `times` TIMESTAMP NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";


#====== ПОЛЬЗОВАТЕЛИ ======
$users_tab = "CREATE TABLE `users` (
      `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `role` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT 'user',
      `username` VARCHAR(255) COLLATE utf8_general_ci NOT NULL, 
      `password` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `email` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `date` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `avatar` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `like` INT(11) NOT NULL DEFAULT '0',
      `ref` INT(11) NOT NULL DEFAULT '0',
      `website` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `skype` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `discord` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `telegram` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `about_user` TEXT COLLATE utf8_general_ci NOT NULL,
      `vk` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `twitter` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `ban_never` INT(11) NOT NULL DEFAULT '0',
      `warning` INT(11) NOT NULL DEFAULT '0',
      `comm_num` INT(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";


# ====== ГЛОБАЛЬНЫЕ ФОРУМЫ ======
$forum = 'CREATE TABLE `forum` (
      `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `title` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `section_num` INT(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci';

# ====== ПОДРАЗДЕЛЫ ГЛОБАЛЬНЫХ ФОРУМОВ ======
$forum_section = "CREATE TABLE `forum_section` (
      `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `title` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `threads_num` INT(11) NOT NULL DEFAULT '0',
      `comment_num` INT(11) NOT NULL DEFAULT '0',
      `forum_name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `forum_id` INT(11) NOT NULL,
      `link` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `class_icon` VARCHAR(255) COLLATE utf8_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";

# ====== ТЕМЫ ФОРУМОВ ======
$threads = "CREATE TABLE `threads` (
      `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `author` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `author_id` INT(11) NOT NULL, 
      `title` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `date` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `forums_id` INT(11) NOT NULL,
      `forums_name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `views` INT(11) NOT NULL DEFAULT '0',
      `comment_num` INT(11) NOT NULL DEFAULT '0',
      `like` INT(11) NOT NULL DEFAULT '0',
      `text` TEXT COLLATE utf8_general_ci NOT NULL,
      `close` INT(11) NOT NULL DEFAULT '0',
      `edit` INT(11) NOT NULL DEFAULT '0',
      `tags` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `share_theme_id` INT(11) NOT NULL,
      `share_theme_name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `comment_true` INT(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";

/*====== КОММЕНТАРИИ К ПУБЛИКАЦИЯМ ======*/
$answer = "CREATE TABLE `answer` (
      `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `author` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `author_id` INT(11) NOT NULL, 
      `date` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `threads_id` INT(11) NOT NULL,
      `active_threads` INT(11) NOT NULL,
      `threads_name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `threads_forums` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `threads_forums_id` INT(11) NOT NULL,
      `views` INT(11) NOT NULL DEFAULT '0',
      `like` INT(11) NOT NULL DEFAULT '0',
      `text` TEXT COLLATE utf8_general_ci NOT NULL,
      `edit` INT(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";

/*====== ЛИЧНЫЕ СООБЩЕНИЯ ======*/
$lmessage = "CREATE TABLE `lmessage` (
      `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `author` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `author_id` INT(11) NOT NULL, 
      `title` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `did` INT(11) NOT NULL,
      `who` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `who_id` INT(11) NOT NULL, 
      `date` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `text` TEXT COLLATE utf8_general_ci NOT NULL,   
      `edit` INT(11) NOT NULL DEFAULT '0',
      `complete` INT(11) NOT NULL DEFAULT '0',
      `status` INT(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";

/*====== ЛИЧНЫЕ СООБЩЕНИЯ (ответ) ======*/
$lmessage_answer = "CREATE TABLE `lmessage_answer` (
      `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `author` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `author_id` INT(11) NOT NULL, 
      `message_id` INT(11) NOT NULL,
      `date` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `text` TEXT COLLATE utf8_general_ci NOT NULL,
      `edit` INT(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";

/*====== УВЕДОМЛЕНИЯ ======*/
$notice = "CREATE TABLE `notice` (
      `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `who_id` INT(11) NOT NULL, 
      `date` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `text` TEXT COLLATE utf8_general_ci NOT NULL,
      `all` INT(11) NOT NULL DEFAULT '0',
      `status` INT(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";

/*====== ЧАТ ======*/
$chat = "CREATE TABLE `chat` (
      `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `author` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `author_id` INT(11) NOT NULL, 
      `date` VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
      `text` TEXT COLLATE utf8_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";