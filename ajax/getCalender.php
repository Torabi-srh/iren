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
    echo $error500;die;
  }
}
if (empty($_SESSION['user_id'])) {
	echo $error500;die();
} else {
	$uid = TextToDB($_SESSION['user_id']);
}

if (!is_ajax()) {
  echo $error500;die();
}
if (empty($_POST['start']) || empty($_POST['end'])) {
  echo $error500;die();
} else {
  $start_bound = parseDateTime(TextToDB($_POST['start']))->format('Y-m-d H:i:s');
  $end_bound = parseDateTime(TextToDB($_POST['end']))->format('Y-m-d H:i:s');
}
try {
    $sql = "SELECT DISTINCT `uid` ,`title` ,`allDay` ,`start` ,`end` ,`properties` FROM `calender` WHERE `uid` = ? AND `start` >= ? AND `end` <= ?";
    if ($stmt = $mysqli->prepare($sql)) {
      $stmt->bind_param('iss', $uid, $start_bound, $end_bound);
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($uid, $title, $allDay, $start, $end, $prop);
      while($stmt->fetch()) {
        $p = json_decode($prop, true);
        $eve2['title'] = $title;
        $eve2['allDay'] = $allDay;
        $eve2['start'] = $start;
        $eve2['end'] = $end;
        foreach ($p as $kval_ => $vkal_) {
           $eve2[$kval_] = $vkal_;
        }
				 $eve[] = $eve2;
      }
    } else {echo $error500;die();}
    echo json_encode($eve, JSON_UNESCAPED_UNICODE);
    exit();
} catch (Exception $e){
    echo $e->getMessage();
}
