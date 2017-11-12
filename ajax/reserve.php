<?php
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/functions.php");
  $mysqli = isset($mysqli) ? $mysqli : Connection();
  $myObj = new StdClass;
  $myObj->a = "danger";
  $myObj->b = "<a href=\".\">صفحه خود را دوباره بارگذاری کنید.</a>";
  $error500 = json_encode($myObj, JSON_UNESCAPED_UNICODE);
  $log_check = login_check() ;
  if ($log_check === false) {
  	echo $error500;die();
  } else {
    if($log_check[0] === false) {
      echo $error500;die;
    } elseif ($log_check[1] === 0) {
      //echo $error500;die;
    }
  }
  if (empty($_SESSION['user_id'])) {
  	echo $error500;die();
  } else {
  	$uuid = TextToDB($_SESSION['user_id']);
  }
  if (!is_ajax()) {
    echo $error500;die();
  }
  if (empty($_POST['start']) || empty($_POST['end'])) {
    echo $error500;die();
  } else {
  	//۲۰۱۷-۱۱-۰۷T۰۳:۳۰:۰۰+۰۳:۳۰
  	$date = TextToDB($_POST['start']);
  	$date = str_replace(' ', '+', $date);
  	$start_bound = parseDateTime(TextToDB($date))->format('Y-m-d H:i:s');
  	$date = TextToDB($_POST['end']);
  	$date = str_replace(' ', '+', $date);
    $end_bound = parseDateTime(TextToDB($date))->format('Y-m-d H:i:s');
  }
  if (empty($_POST['stime']) || empty($_POST['etime'])) {
    echo $error500;die();
  } else {
  	//۲۰۱۷-۱۱-۰۷T۰۳:۳۰:۰۰+۰۳:۳۰
  	$date = TextToDB($_POST['stime']);
  	$date = str_replace(' ', '+', $date);
  	$stime_bound = parseDateTime(TextToDB($date))->format('Y-m-d H:i:s');
  	$date = TextToDB($_POST['etime']);
  	$date = str_replace(' ', '+', $date);
    $etime_bound = parseDateTime(TextToDB($date))->format('Y-m-d H:i:s');
  }
  if ((($stime_bound >= $start_bound && $stime_bound < $end_bound) && ($etime_bound <= $end_bound && $etime_bound > $start_bound))) {
    $ok = false;
    //2017-11-11 03:30:00, 2017-11-18 03:30:00
    $sql = "SELECT `title`, `start`, `end`, `properties` FROM `calender` WHERE `start` >= ? AND `end` <= ?";
    $uname = TextToDB($_POST['uname']);
    if ($stmt = $mysqli->prepare($sql)) {
      $stmt->bind_param('ss', $start_bound, $end_bound);
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($tbdate, $sbdate, $ebdate, $properties);
      $myObj->b = "";
      while ($stmt->fetch()) {
        //$myObj->b .= "$stime_bound, $sbdate, $etime_bound, $ebdate-";
        //2017-11-12 08:00:00  $stime_bound
        //2017-11-12 08:00:00  $sbdate
        //2017-11-18 03:30:00  $etime_bound
        //2017-11-12 10:30:00  $ebdate
        //-
        //2017-11-12 08:00:00
        //2017-11-13 08:30:00
        //2017-11-18 03:30:00
        //2017-11-13 11:00:00
        //-
        //2017-11-12 08:00:00
        //2017-11-15 08:00:00
        //2017-11-18 03:30:00
        //2017-11-15 10:30:00
        //-
        //2017-11-12 08:00:00
        //2017-11-14 07:30:00
        //2017-11-18 03:30:00
        //2017-11-14 08:00:00
        //-
        //2017-11-12 08:00:00
        //2017-11-12 17:00:00
        //2017-11-18 03:30:00
        //2017-11-12 20:30:00-
        if ((($stime_bound >= $sbdate && $stime_bound < $ebdate) && ($etime_bound <= $ebdate && $etime_bound > $sbdate))) {
          if (strpos($tbdate, 'ساعت ثبت شده') !== false) {
            $ok = false;
            break;
          } else {
            $ok = true;
          }
        }
      }
    }
    if (!$ok) {
      echo $error500;die();
    }
  } else {
    echo $error500;die();
  }
  if (!empty($_POST['uid'])) {
  	$uid = TextToDB($_POST['uid']);
  } elseif(!empty($_POST['uname'])) {
  	$uname = TextToDB($_POST['uname']);
    $sql = "SELECT id, (select MAX(id) FROM calender) FROM `users` WHERE `username` = ?";
    if ($stmt = $mysqli->prepare($sql)) {
      $stmt->bind_param('s', $uname);
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($uid, $mid);
      $mid++;
      $stmt->fetch();
    }
  } else {
    echo $error500;die();
  }
  $sql = "INSERT INTO `reservation` (`uid`, `did`, `date_time`) VALUES (?, ?, ?);";
  if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param('iis', $uuid, $uid, $stime_bound);
    $stmt->execute();
    $sql = "DELETE FROM `calender` WHERE `start` = ? AND `end` = ? AND `uid` = ?;";
    if ($stmt = $mysqli->prepare($sql)) {
      $stmt->bind_param('ssi', $stime_bound, $etime_bound, $uid);
      $stmt->execute();
      $myObj->a = "success";
      $myObj->b = "با موفقیت ثبت شد.";
      $sc = json_encode($myObj, JSON_UNESCAPED_UNICODE);
      echo $sc;
    }
  }
  // $sql = "INSERT INTO `calender` (`uid` ,`title` ,`allDay` ,`start` ,`end` ,`properties`) VALUES (?, CONCAT(?, ?), ?, ?, ?, ?);";
  // if ($stmt = $mysqli->prepare($sql)) {
  //   $str1_ = 'ساعت ثبت شده ';
  //   $allday = 0;
  //   $stmt->bind_param('isiisss', $uid, $str1_, $mid, $allday, $stime_bound, $etime_bound, $properties);
  //   $stmt->execute();
  //   $myObj->a = "success";
  //   $myObj->b = "با موفقیت ثبت شد.";
  //   $sc = json_encode($myObj, JSON_UNESCAPED_UNICODE);
  //   echo $sc;
  // }
?>
