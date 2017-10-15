<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/functions.php");

$log_check = login_check();
if ($log_check === false) {
  redirect("login.php") ;
} else {
  if($log_check[0] === false) {

    redirect("login.php") ;
  } elseif ($log_check[1] === 0) {
    redirect("profile-user.php") ;
  }
}

include("pages/header.php"); head(""); ?>
<div id="could_pass">
</div>
<div class="row">
  <div class="col-*-*">
    <div class="panel panel-default">
      <div class="panel-body">
        <div id='wrap'>
          <div class="col-md-6">
            <div class="row">
              <div id='external-events'>
                <h4>رویدادها</h4>
                <div class='fc-event fc-event-skin green' id="green-dot">ساعت حضور</div>
                <div class='fc-event fc-event-skin orange' id="red-dot">ساعت ثبت شده</div>
              </div>
            </div>
            <div class="row" style="margin-top: 1%;">
              <div id='external-events'>
                <h4>حذف</h4>
                <div id="calendarTrash" class="calendar-trash" style="border-style: solid;border-width: thin;text-align: center;margin-bottom: 10px;"><span><i class="fa fa-trash-o fa-5x" aria-hidden="true"></i></span></div>
              </div>
            </div>
            <div class="row" style="margin-top: 1%;">
              <div id='external-events'>
                <div class='fc-event2' id="reg-events">ثبت</div>
                <div class='fc-event2' id="clear-events">پاک کردن همه</div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
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
