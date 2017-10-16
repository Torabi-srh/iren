-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2016 at 02:25 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET foreign_key_checks=0;
/*SET SESSION SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET GLOBAL SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";*/

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `telepathymaster`
--

-- --------------------------------------------------------

--
-- Database: `telepathymaster`
--
CREATE DATABASE IF NOT EXISTS `telepathymaster` DEFAULT CHARACTER SET utf8 ;
USE `telepathymaster`;

-- ----------------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS users (
  id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(20) NOT NULL ,
  fname varchar(20) ,
  name varchar(20) ,
  password varchar(20) NOT NULL ,
  email varchar(100) NOT NULL,
  age int(3) ,
  phone char(11),
  drphone char(11),
  gender tinyint(2),
  bday DATE,
  login_session varchar(255) ,
  register_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  picture varchar(255) NOT NULL DEFAULT "assets/images/users/no-image.jpg",
  verify tinyint(1) NOT NULL DEFAULT 0,
  verify_send datetime NOT NULL,
  verify_send_hash varchar(255) NOT NULL,
  forgot tinyint(1) NOT NULL DEFAULT 0,
  forgot_send datetime,
  forgot_send_hash varchar(255),
  isban tinyint(1) NOT NULL DEFAULT 0,
  isdr tinyint(1) NOT NULL DEFAULT 0,
  wizard tinyint(1) NOT NULL DEFAULT 0,
  drcode varchar(10) NOT NULL,
  scode varchar(20),
  ncode varchar(10),
  iban varchar(30),
  salary int(11),
  edu int(4),
  bio varchar(255),
  pcode varchar(11),
  addr varchar(255),
  city varchar(50),
  province varchar(50),
  register_ip varchar(20) DEFAULT "127.0.0.1",
  PRIMARY KEY (`id`,`username`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `takhasos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`uid`) REFERENCES users(`id`)
      ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `roykard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`uid`) REFERENCES users(`id`)
      ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
--
--  INSERT INTO `telepathymaster`.`users` (`id`, `username`, `fname`, `name`, `password`, `email`, `age`, `phone`, `drphone`, `gender`, `bday`, `login_session`, `register_date`, `picture`, `verify`, `verify_send`, `verify_send_hash`, `forgot`, `forgot_send`, `forgot_send_hash`, `isban`, `isdr`, `wizard`, `drcode`, `scode`, `ncode`, `register_ip`, `iban`, `salary`) VALUES ('1', 'bionix', 'ترابی', 'سروش', 'd28Ewmo/nBPJo', 'tspersian@gmail.com', NULL, NULL, NULL, '1', '1111-11-11', 'ccXp3CpnuS/0.', '2017-10-01 11:40:40', 'assets/images/users/no-image.jpg', '1', '2017-10-01 08:10:40', 'dalHISFkVmD5o', '0', NULL, NULL, '0', '0', '0', '12343', '1', '1111111111', '', NULL, NULL);
--

--
-- Dumping data for table `ip_table`
--

CREATE TABLE IF NOT EXISTS `ip_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `ip` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`uid`) REFERENCES users(`id`)
      ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_activitys`
--

CREATE TABLE IF NOT EXISTS `user_activitys` (
  `ua_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `actual_link` varchar(100) NOT NULL,
  `user_agent` varchar(150) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `now` varchar(20) NOT NULL,
  PRIMARY KEY (`ua_id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`)
      ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `la_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `now` varchar(30) NOT NULL,
  `user_agent` varchar(150) NOT NULL,
  `ip` varchar(20) NOT NULL,
  PRIMARY KEY (`la_id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`)
      ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `user_file` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `uid` int(11) NOT NULL,
    `progress` int(6),
    `services` TEXT DEFAULT '',
    `apperances` int(6),
    `speach` int(6),
    `goal` TEXT DEFAULT '',
    `removal` TEXT DEFAULT '',
    `attitude` TEXT DEFAULT '',
    `assessment` TEXT DEFAULT '',
    `plan` TEXT DEFAULT '',
    `danger` TEXT DEFAULT '',
    `mood` char(30),
    `behavie` char(30),
    `knowing` char(30),
    `edit_date` datetime,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`uid`) REFERENCES users(`id`)
      ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `file_meds` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `fid` int(11) NOT NULL,
    `med_name` nvarchar(20) NOT NULL,
    `med_dose` int(10) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`fid`) REFERENCES user_file(`id`)
      ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `invoice` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `uid` int(11) NOT NULL,
    `depose` int,
    `depose_date` datetime,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`uid`) REFERENCES users(`id`)
      ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `chat` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `c_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `chat_users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `cid` int(11) NOT NULL,
    `uid` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`uid`) REFERENCES users(`id`)
      ON UPDATE CASCADE,
    FOREIGN KEY (`cid`) REFERENCES chat(`id`)
      ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `msg` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `cid` int(11) NOT NULL,
    `msg` TEXT,
    `msg_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`cid`) REFERENCES chat_users(`id`)
      ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ///////////////////

CREATE TABLE IF NOT EXISTS `posts` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `publisher` int(11) NOT NULL,
    `views` int(11) NOT NULL,
    `likes` int(11) NOT NULL,
    `dislikes` int(11) NOT NULL,
    `header` varchar(255) NOT NULL,
    `image` varchar(255) NOT NULL,
    `txt` TEXT NOT NULL,
    `p_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`publisher`) REFERENCES users(`id`)
      ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `posts_likes` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `uid` int(11) NOT NULL,
    `pid` int(11) NOT NULL,
    `lod` int(11) NOT NULL,
    `lod_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`uid`) REFERENCES users(`id`)
      ON UPDATE CASCADE,
    FOREIGN KEY (`pid`) REFERENCES posts(`id`)
      ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `post_comments` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `uid` int(11) NOT NULL,
    `pid` int(11) NOT NULL,
    `comment` TEXT NOT NULL,
    `c_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`uid`) REFERENCES users(`id`)
      ON UPDATE CASCADE,
    FOREIGN KEY (`pid`) REFERENCES posts(`id`)
      ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Dumping DATA FOR TABLE `type`
--

CREATE TABLE IF NOT EXISTS `product_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Tname` varchar(255) NOT NULL,
  PRIMARY KEY(`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

 CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` varchar(255) NOT NULL,
  `tid` int(3) DEFAULT 1 ,
  `picture` varchar(255)  DEFAULT "assets/images/product/no-image.jpg",
  `description` text,
  `price` float(8) NOT NULL,
  `starts` float(2) DEFAULT 0.0,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`tid`) REFERENCES product_type(`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping DATA FOR TABLE `reservation`
--

CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL ,
  `did` int(11) NOT NULL,
  `date_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`uid`) REFERENCES users(`id`),
    ON UPDATE CASCADE
  FOREIGN KEY (`did`) REFERENCES users(`id`)
    ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- calender
CREATE TABLE IF NOT EXISTS `calender` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL ,
  `title` varchar(20) NOT NULL,
  `allDay` int(1) NOT NULL,
  `start` DateTime NOT NULL,
  `end` DateTime NOT NULL,
  `properties` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`uid`) REFERENCES users(`id`),
    ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;







SET foreign_key_checks=1;
