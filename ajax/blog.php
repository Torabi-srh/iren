<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/functions.php");
$log_check = login_check() ;
$myObj = new StdClass;
$myObj->a = "danger";
$myObj->b = "<a href=\".\">صفحه خود را دوباره بارگذاری کنید.</a>";
$error500 = json_encode($myObj, JSON_UNESCAPED_UNICODE);
if (!is_ajax()) {
  echo $error500;die();
}
if ($log_check === false) {
  echo $error500;die();
}
if (empty($_SESSION['user_id'])) {
  echo $error500;die();
} else {
  $uid = TextToDB($_SESSION['user_id']);
}
$isdr = $log_check[1];

$mysqli = isset($mysqli) ? $mysqli : Connection();

if (empty($_POST['id'])) {
	echo $error500;die();
} else {
	$pid = TextToDB($_POST['id']);
	if (!filter_var($pid, FILTER_VALIDATE_INT) || !is_numeric($pid)) { echo $error500;die(); }
}

if (isset($_POST['token'])) {
	if (!empty($_POST['comment'])) {
		$ctxt = TextToDB($_POST['comment']);
		if ($stmt = $mysqli->prepare("INSERT INTO post_comments(uid, pid, comment) VALUES(?, ?, ?)")) {
			$stmt->bind_param('iis', $uid, $pid, $ctxt);
			$stmt->execute();
      $idi = $stmt->insert_id;
      $sql = "SELECT pc.comment, pc.c_date, u.username, u.picture FROM post_comments AS pc INNER JOIN users AS u ON u.id = pc.uid WHERE pc.id = ?";
      if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param('i', $idi);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($pccomment, $pcc_date, $uusername, $upicture);
        $stmt->fetch();
      }

      $myObj->a = "success";
      $myObj->b = "باتشکر";
      $myObj->c = "<article class=\"row\">
                    <div class=\"col-md-2 col-sm-2 hidden-xs\">
                      <figure class=\"thumbnail\">
                        <img class=\"img-responsive\" src=\"$upicture\" />
                        <figcaption class=\"text-center\">$uusername</figcaption>
                      </figure>
                    </div>
                    <div class=\"col-md-10 col-sm-10\">
                      <div class=\"panel panel-default arrow left\">
                        <div class=\"panel-body\">
                          <header class=\"text-left\">
                            <div class=\"comment-user\"><i class=\"fa fa-user\"></i>$uusername</div>
                            <time class=\"comment-date\" datetime=\"$pcc_date\"><i class=\"fa fa-clock-o\"></i>$pcc_date</time>
                          </header>
                          <div class=\"comment-post\">
                            <p>
                              $pccomment
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </article>";
      $error500 = json_encode($myObj, JSON_UNESCAPED_UNICODE);
      echo $error500;die();
		}
	}
}

?>
