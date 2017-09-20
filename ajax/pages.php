<?php
  include_once("../assets/functions.php"); 
  user_activitys();
  $page_to_load = "login.php";
  $p = $_GET['p'];
  if (empty($p)) {
    $page_to_load = "login.php";
  } else {
    $page_to_load = $p;
  }
  // if (login_check() == false) {
  //   // safeRedirect("login.php");
  //   //die();
  //   if ($page_to_load != "register.php") $page_to_load = "login.php";
  // }
  if ($page_to_load == "index.php" || $page_to_load == "index") $page_to_load = "login.php";
  include("../pages/".$page_to_load);
?>
