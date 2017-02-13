<?php
require_once("config/database.php");

$link = db_connect();

mysqli_query( $link, "SET NAMES 'utf8'" );
mysqli_select_db ( $link, MYSQL_DB ) or die( 'В настоящий момент база данных недоступна' );

// Создаем таблицу `users`
$query = "CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `u_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `u_psw` varchar(50) NOT NULL,
  `family` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `sec_name` varchar(50) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET = utf8;";
mysqli_query( $link, $query );
$query = "TRUNCATE TABLE `users`;";
mysqli_query( $link, $query );
// Добавляем пользователя
$query = "INSERT INTO `users` (uid, u_name, email, u_psw, role, family, name, sec_name) 
        VALUES (1, 'admin', 'admin@mail.ru', '".md5('admin')."', 2, 'Ivan', 'Sidorov', 'Petrovici');";
mysqli_query( $link, $query );

// Создаем таблицу `messages`
$query = "CREATE TABLE IF NOT EXISTS `messages` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_tid` int(11) NOT NULL,
  `msg_uid` int(11) NOT NULL,
  `msg_date` date NOT NULL,
  `msg_content` text NOT NULL,
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB  DEFAULT CHARSET = utf8;";
mysqli_query( $link, $query );
$query = "TRUNCATE TABLE `messages`;";
mysqli_query( $link, $query );

// Создаем таблицу `themes`
$query = "CREATE TABLE IF NOT EXISTS `themes` (
  `them_id` int(11) NOT NULL AUTO_INCREMENT,
  `them_uid` int(11) NOT NULL,
  `them_date` date NOT NULL,
  `them_content` text NOT NULL,
  PRIMARY KEY (`them_id`)
) ENGINE=InnoDB  DEFAULT CHARSET = utf8;";
mysqli_query( $link, $query );
$query = "TRUNCATE TABLE `themes`;";
mysqli_query( $link, $query );

// Создаем таблицу `settings`
$query = "CREATE TABLE IF NOT EXISTS `settings` (
  `per_page_themes` int(11) NOT NULL,
  `per_page_msg` int(11) NOT NULL,
  `per_chunk_links` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
mysqli_query( $link, $query );
$query = "TRUNCATE TABLE `settings`;";
mysqli_query( $link, $query );
// Добавляем данные
$query = "INSERT INTO `settings` (`per_page_themes`, `per_page_msg`, `per_chunk_links`) 
                                                                        VALUES (7, 5, 5);";
mysqli_query( $link, $query );

echo 'ОК';
?>