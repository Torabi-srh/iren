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
	$uid = TextToDB($_SESSION['user_id']);
}

if (!is_ajax()) {
  //echo $error500;die();
}
if (empty($_GET['start']) || empty($_GET['end'])) {
  echo $error500;die();
} else {


	//۲۰۱۷-۱۱-۰۷T۰۳:۳۰:۰۰+۰۳:۳۰

	$date = TextToDB($_GET['start']);
	$date = str_replace(' ', '+', $date);
	$start_bound = parseDateTime(TextToDB($date))->format('Y-m-d H:i:s');
	$date = TextToDB($_GET['end']);
	$date = str_replace(' ', '+', $date);
  $end_bound = parseDateTime(TextToDB($date))->format('Y-m-d H:i:s');
}
if (!empty($_GET['uid'])) {
	$uid = TextToDB($_GET['uid']);
}
try {
		$eve = null;
		$sql = "SELECT DISTINCT `uid` ,`title` ,`allDay` ,`start` ,`end` ,`properties` FROM `calender` WHERE `uid` = ?; # AND `start` >= ? AND `end` <= ?";
    if ($stmt = $mysqli->prepare($sql)) {
      $stmt->bind_param('i', $uid);//, $start_bound, $end_bound);
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
		if (!empty($_GET['uid'])) {
			for ($i=0; $i < count($eve)-1; $i++) {
				$sdate = parseDateTime($eve[$i]['start']);
				$edate = parseDateTime($eve[$i]['end']);
				// var_dump($sdate);
				// date_modify($sdate, "+1 hour");
				// var_dump($sdate);die();
				$tsdate = $sdate;
				date_modify($tsdate, "+1 hour");
				if ($tsdate == $edate) continue;
				do {
					$e = $eve[$i];
					$e['end'] = $tsdate->format('Y-m-d H:i:s');
					$eve[] = $e;
					$sdate = $tsdate->format('Y-m-d H:i:s');
					date_modify($tsdate, "+1 hour");
				} while ($tsdate !== $edate);
				unset($eve[$i]);
			}
		}
    echo json_encode($eve, JSON_UNESCAPED_UNICODE);
    exit();
} catch (Exception $e){
    echo $e->getMessage();
}
