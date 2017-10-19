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
		echo $error500;die();
	}
}
if (empty($_SESSION['user_id'])) {
	echo $error500;die();
} else {
	$uid = TextToDB($_SESSION['user_id']);
}
if ($log_check === false) {
  echo $error500;die;
} else {
  if($log_check[0] === false) {
    echo $error500;die;
  } elseif ($log_check[1] === 0) {
    echo $error500;die;
  }
}
if (!is_ajax()) {
  echo $error500;die();
}

$events_ = array();
$_events = array();

if (isset($_POST['eventsJson'])) {$_events = json_decode($_POST['eventsJson'], true);} else {echo $error500;die();}
foreach ($_events as $val) {
  if (empty($val) || !isset($val)) continue;
  if (isset($val['source']['events'])) {
    foreach ($val['source']['events'] as $sv => $v) {
      if (empty($v) || !isset($v)) continue;
      $events_[] = new Event($val['source']['events'][$sv]);
      unset($val['source']['events'][$sv]);
    }
  }
  $events_[] = new Event($val);
}
$title = "";
$allDay = ""; // a boolean
$start = ""; // a DateTime
$end = ""; // a DateTime, or null
$properties = array(); // an array of other misc properties
// sabtshode => {}
// reserve => ||
// cleaning events
//
$events_ = CleanFullCalendarEvents($events_);
foreach ($events_ as $eve) {
  if (empty($eve) || !isset($eve)) continue;
  $sql = "INSERT INTO `calender` (`uid` ,`title` ,`allDay` ,`start` ,`end` ,`properties`) VALUES (?, ?, ?, ?, ?, ?);";
  $eve->start = $eve->start->format('Y-m-d H:i:s');
  $eve->end = $eve->end->format('Y-m-d H:i:s');
  $eve->allDay = ($eve->allDay ? 1: 0);
  $eve->properties = json_encode($eve->properties, JSON_UNESCAPED_UNICODE);
	if ($stmt = $mysqli->prepare($sql)) {
		$stmt->bind_param('issisisss', $uid, $eve->start, $eve->end, $uid, $eve->title, $eve->allDay, $eve->start, $eve->end, $eve->properties);
		$stmt->execute();
	} else {echo $error500;die();}
  $sql = "delete e1 from `calender` e1, `calender` e2 where e1.id > e2.id and e1.`start` = e2.`start` and e1.`end` = e2.`end`;";
  if ($stmt = $mysqli->prepare($sql)) {
		$stmt->execute();
	} else {echo $error500;die();}
}
$myObj->a = "success";
$myObj->b = "با موفقیت ثبت شد.";
$sc = json_encode($myObj, JSON_UNESCAPED_UNICODE);
echo $sc;
?>
