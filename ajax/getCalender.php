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
$isdr = $log_check[1];
if (empty($_SESSION['user_id'])) {
	echo $error500;die();
} else {
	$uid = TextToDB($_SESSION['user_id']);
}
if (!is_ajax()) {
  echo $error500;die();
}
if (!$isdr && (!empty($_POST['uid']) && !empty($_POST['uname']))) {
	echo "";die();
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
if (!empty($_POST['uid'])) {
	$uid = TextToDB($_POST['uid']);
}
if (!empty($_POST['uname'])) {
	$sql = "SELECT id FROM `users` WHERE `username` = ?";
	$uname = TextToDB($_POST['uname']);
	if ($stmt = $mysqli->prepare($sql)) {
		$stmt->bind_param('s', $uname);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($uid);
		$stmt->fetch();
	}
}

$eve2 = array();
try {
		$eve = null;
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

		if (!empty($_POST['uid']) || !empty($_POST['uname'])) {
			$tid = 1;
			$strnil = "ساعت حضور";
			for ($i=0; $i < count($eve); $i++) {
				if (strpos($eve[$i]['title'], $strnil) === false) {
					continue;
				}
				$eve[$i]['title'] = preg_replace('/\d+/u', '', $eve[$i]['title']);
				$eve[$i]['title']	= "$strnil $tid";
				$eve[$i]['id'] = $tid;
				$eve[$i]['_id'] = $tid;
				$tid++;
				$sdate = parseDateTime($eve[$i]['start']);
				$edate = parseDateTime($eve[$i]['end']);
				$tsdate = $sdate;
				date_modify($tsdate, "+1 hour");
				if ($tsdate == $edate) {
					continue;
				} elseif ($tsdate > $edate) {
					unset($eve[$i]);
					continue;
				}
				do {
					$e = $eve[$i];
					$e['end'] = $tsdate->format('Y-m-d H:i:s');
					$e['title']	= "$strnil $tid";
					$e['id'] = $tid;
					$e['_id'] = $tid;
					$tid++;
					$eve[] = $e;
					$eve[$i]['start'] = $tsdate->format('Y-m-d H:i:s');
					date_modify($tsdate, "+1 hour");
				} while ($tsdate < $edate);
				unset($eve[$i]);
			}
		}
		if (!empty($eve)) {
			$eve2 = array();
			foreach ($eve as $key => $value) {
				if ($value == NULL) continue;
			  $eve2[] = $value;
			}
    	echo json_encode($eve2, JSON_UNESCAPED_UNICODE);
    	exit();
		} else {
			$myObj->a = "warning";
			$myObj->b = "ساعتی ثبت نشده است";
			$error500 = json_encode($myObj, JSON_UNESCAPED_UNICODE);
			echo $error500;
		}
} catch (Exception $e){
    echo $e->getMessage();
}
