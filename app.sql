CREATE DATABASE IF NOT EXISTS `smsoft_ledit`;
USE `smsoft_ledit`;
DROP TABLE IF EXISTS `user`, `settings`;

CREATE TABLE `settings`
(
  `id`    int primary key auto_increment,
  `name`  varchar(255) not null,
  `value` varchar(500) not null
);

CREATE TABLE `user`
(
  `id`       int primary key auto_increment,
  `method`   varchar(255)          DEFAULT 'ledit' COMMENT 'google for google sign in, its for default',
  `email`    varchar(255) not null unique,
  `name`     varchar(255) not null,
  `password` varchar(500) not null,
  `rank`     int          not null DEFAULT 0 COMMENT 'left for implementation.'
);
