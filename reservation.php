<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/functions.php");
$mysqli = isset($mysqli) ? $mysqli : Connection();
$log_check = login_check();
if ($log_check === false) {
  redirect("login.php");die();
} else {
  if($log_check[0] === false) {
    redirect("login.php");die();
  }
}
if (empty($_SESSION['user_id'])) {
 redirect("login.php");die();
} else {
 $uid = TextToDB($_SESSION['user_id']);
}
if (empty($_GET['uname'])) {
  redirect("login.php");die();
} else {
  $uname = TextToDB($_GET['uname']);
  $_id = null;
  $sql = "SELECT isdr FROM `users` WHERE `username` = ?";
  if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param('s', $uname);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($_id);
    $stmt->fetch();
  }
  if (empty($_id) || !$_id) {
    redirect("login.php");die();
  }
}
$isdr = $log_check[1];
if ($isdr) {
  redirect("login.php");die();
}
include("pages/header.php"); head(""); ?>
<div id="could_pass">
</div>
<div class="row">
  <div class="col-*-*">
    <div class="panel panel-default">
      <div class="panel-body">
        <div id='wrap'>
          <input id="uname" value="<?php echo $uname; ?>" type="hidden" />
          <div class="col-md-12">
            <div id='calendar'>
            </div>
            <div style='clear:both'></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include("pages/footer.php"); ?>
