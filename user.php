<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/functions.php");
$log_check = login_check() ;
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
$isdr = $log_check[1];

$mysqli = isset($mysqli) ? $mysqli : Connection();

include("pages/header.php");head("p2"); ?>
      <!-- section 3 -->
      <div class="panel panel-default">
      <div class="panel-body tcbot-body">
        <div class="row" style="margin-top: 30px;min-width: 500px;">
          <div class="col-md-3 pull-right">
            <ul class="nav nav-pills nav-stacked" dir="rtl">
              <li class="active"><a data-toggle="tab" href="#t1">اطلاعات شخصی</a></li>
              <li><a data-toggle="tab" href="#t2">تست ها</a></li>
              <li><a data-toggle="tab" href="#t3">پرونده</a></li>
            </ul>
         </div>
        <div class="col-md-9 tab-content">
          <div id="t1" class="tab-pane fade in active">
            <div class="disabledbutton">
      				<?php include("pages/resume-wizard.php"); ?>
            </div>
          </div>
          <div id="t2" class="tab-pane fade in">
          </div>
          <div id="t3" class="tab-pane fade in">
            <?php include("resume.php"); ?>
          </div>
        </div>
      </div>
      </div>
      </div>
			<!-- section 3 -->
<?php include("pages/footer.php"); ?>
