<?php

//  setup
  header('Content-Type: text/html; charset=utf-8');
  date_default_timezone_set('Asia/Dhaka');

  include 'jdf.php';
  include 'bulletproof-3.0.2/bulletproof.php';
  require 'utils.php';

//  database
  define('DB_HOST', 'localhost');
  define('DB_USER', 'skyf5_20947548');
  define('DB_PASSWORD', 'e833xsbf');
  define('DB_NAME', 'skyf5_20947548_telepathy_master');
  define('DB_PORT', '3306');
// Names
  define('MALE', 'مرد');
  define('FEMALE', 'زن');
  define('BLUE', 'دیگر');
  define('DR', 'دکتر');
//  upload path
define ('SITE_ROOT', realpath(dirname(__FILE__)));
  define('UPLOAD_POST', SITE_ROOT.'/images/posts/');
  define('UPLOAD_PROFILE_PIC', SITE_ROOT.'/images/users/');
//  site
  define('PAGE_NAME', basename($_SERVER['PHP_SELF']));
  define('DOMAIN', ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false);
//site specific configuration declartion
  define( 'BASE_PATH', 'http://cyberdream.ir/authorized.php');

//Google App Details
  define('GOOGLE_APP_NAME', 'Cyberdream');
  define('GOOGLE_OAUTH_CLIENT_ID', '620171197053-dqcqkcio6uj5mjuf3kh962rl6qal401g.apps.googleusercontent.com');
  define('GOOGLE_OAUTH_CLIENT_SECRET', 'jVJLfloa4q9eEybAtS81AIar');
  define('GOOGLE_OAUTH_REDIRECT_URI', 'http://cyberdream.ir/signin.php');
  define('GOOGLE_OAUTH_REDIRECT_URI_LOGIN', 'http://cyberdream.ir/login.php');
  define("GOOGLE_SITE_NAME", 'http://cyberdream.ir');

  function isdebug() {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
   }
  function islocal()
  {
      $whitelist = array(
      '127.0.0.1',
      '::1'
    );
      if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
          return false;
      } else {
          return true;
      }
  }

  function serverRoot()
  {
      if (islocal()) {
          return "";
      } else {
          return $_SERVER['DOCUMENT_ROOT'].'/main/html';
      }
  }
  function serverRoot2()
  {
      if (islocal()) {
          return "";
      } else {
          return '/main/html';
      }
  }
  function usersuploadpath()
  {
      return "images/users/";
  }
