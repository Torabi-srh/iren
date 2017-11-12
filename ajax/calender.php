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
if (empty($_POST['start']) || empty($_POST['end'])) {
  echo $error500;die();
} else {
  $start_bound = parseDateTime(TextToDB($_POST['start']))->format('Y-m-d H:i:s');
  $end_bound = parseDateTime(TextToDB($_POST['end']))->format('Y-m-d H:i:s');
}
if (isset($_POST['rm'])) {
  if ($_POST['rm'] == 'la') {
    $sql = "delete e1 from `calender` e1 WHERE `uid` = ?";
  } else {
    $sql = "delete e1 from `calender` e1 WHERE `uid` = ? AND `title` = ?";
  }
  $eventid = TextToDB($_POST['eventid']);
  $eventtitle = TextToDB($_POST['eventtitle']);
  $eventstart = TextToDB($_POST['eventstart']);
  $eventend = TextToDB($_POST['eventend']);

  if ($stmt = $mysqli->prepare($sql)) {
    if ($_POST['rm'] == 'la') {
      $stmt->bind_param('i', $uid);
    } else {
      $stmt->bind_param('is', $uid, $eventtitle);
    }
    $stmt->execute();
  } else {echo $error500;die();}
  $myObj->a = "success";
  $myObj->b = "با موفقیت انجام شد.";
  $sc = json_encode($myObj, JSON_UNESCAPED_UNICODE);
  echo $sc;
  die();
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
$events_ = CleanFullCalendarEvents($events_);

$tid = 1;
$strnil = "ساعت حضور";
// $o = 0;
for ($i=0; $i <= count($events_); $i++) {
  // $o++;
  // 1 0 1
  // 2 0 2
  // 3 1 2
  // 4 2 2
  // if ($o > 3) console($events_[$i]);
  if (empty($events_[$i])) continue;
  if (strpos($events_[$i]->title, $strnil) === false) {
    unset($events_[$i]);
    continue;
  }
  $events_[$i]->title = preg_replace('/\d+/u', '', $events_[$i]->title);
  $events_[$i]->title	= "$strnil $tid";
  $events_[$i]->id = $tid;
  $events_[$i]->_id = $tid;
  $tid++;
  if (gettype($events_[$i]->start) === "string") {
    $events_[$i]->start = parseDateTime($events_[$i]->start);
  }
  if (gettype($events_[$i]->end) === "string") {
    $events_[$i]->end = parseDateTime($events_[$i]->end);
  }
  $edate = clone $events_[$i]->end;
  $sdate = clone $events_[$i]->start;

  date_modify($sdate, "+1 hour");
  if ($sdate == $edate) {
    continue;
  } elseif ($sdate > $edate) {
    unset($events_[$i]);
    continue;
  }
  // do {
    $e = clone $events_[$i];
    $e->end = clone $sdate;
    $e->title	= "$strnil $tid";
    $e->id = $tid;
    $e->_id = $tid;
    $tid++;
    $events_[] = $e;

    $e = clone $events_[$i];
    $e->start = clone $sdate;
    $e->end = clone $edate;

    $e->title	= "$strnil $tid";
    $e->id = $tid;
    $e->_id = $tid;
    $tid++;
    $events_[] = $e;
    // date_modify($sdate, "+1 hour");
  // } while ($tsdate < $edate);
    unset($events_[$i]);
    $i--;
}

foreach ($events_ as $eve) {
  // $evestart = clone unserialize(serialize($eve->start));
  // $eveend = clone unserialize(serialize($eve->end));
  if (gettype($eve->start) == "object" || gettype($eve->start) == "DateTime") {
    $evestart = $eve->start->format('Y-m-d H:i:s');
  }
  if (gettype($eve->end) == "object" || gettype($eve->end) == "DateTime") {
    $eveend = $eve->end->format('Y-m-d H:i:s');
  }
  $eveallDay = ($eve->allDay ? 1: 0);
  $eveproperties = json_encode($eve->properties, JSON_UNESCAPED_UNICODE);
  $evetitle = $eve->title;
  if (empty($eve) || !isset($eve)) continue;
  $sql = "SELECT `id` FROM `calender` WHERE `uid` = ? AND `start` = ? AND `end` = ?;";
  if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param('iss', $uid, $evestart, $eveend);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {continue;}
  } else {echo $error500;die();}

  $up = false;
  $sql = "SELECT `id` FROM `calender` WHERE `uid` = ? AND `title` = ? AND `start` >= ? AND `end` <= ?";
  if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param('isss', $uid, $evetitle, $start_bound, $end_bound);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) $up = true;
  } else {echo $error500;die();}
  if ($up) {
    $sql = "UPDATE `calender` SET `uid` = ?, `title` = ? ,`allDay` = ? ,`start` = ? ,`end` = ? ,`properties` = ? WHERE `uid` = ? AND `title` = ? AND `start` > ? AND `end` < ?;";
  } else {
    $sql = "INSERT INTO `calender` (`uid` ,`title` ,`allDay` ,`start` ,`end` ,`properties`) VALUES (?, ?, ?, ?, ?, ?);";
  }
	if ($stmt = $mysqli->prepare($sql)) {
    if ($up) {
  		$stmt->bind_param('isisssisss', $uid, $evetitle, $eveallDay, $evestart, $eveend, $eveproperties, $uid, $evetitle, $start, $end);
    } else {
  		$stmt->bind_param('isisss', $uid, $evetitle, $eveallDay, $evestart, $eveend, $eveproperties);
    }
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
