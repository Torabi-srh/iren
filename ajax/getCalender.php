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
  //echo $error500;die();
}
try {
    $sql = "SELECT DISTINCT `uid` ,`title` ,`allDay` ,`start` ,`end` ,`properties` FROM `calender` WHERE uid = ?";
    if ($stmt = $mysqli->prepare($sql)) {
      $stmt->bind_param('i', $uid);
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
			  //$eve[] = new Event($eve2);
        $eve[] = $eve2;//array('title' => $title, 'allDay' => $allDay, 'start' => $start,'end' => $end, $p);
      }
    } else {echo $error500;die();}
    //$eve = array('title' => $mtitle, 'allDay' => $mallDay, 'start' => $mstart, 'end' => $mend, 'backgroundColor' => $mbackgroundColor, 'source' => array('events' => $eve));

    // Returning array

    echo json_encode($eve, JSON_UNESCAPED_UNICODE);
    exit();
} catch (Exception $e){
    echo $e->getMessage();
}
