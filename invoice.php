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
  include("pages/header.php");head("");
?>
<div id="could_pass">
</div>
      <div class="row">
        <div class="col-*-*">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="row margin-bot-2">
<?php if($isdr): ?>
                <!-- <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">شماره شبا</span>
                    <input id="shaba" type="text" class="form-control number-text" name="msg" placeholder="IR890170000000108847184007">
                  </div>
                </div> -->
                <div class="col-md-6">

                  <button type="button" class="btn btn-success bottom-mali float-left">ثبت</button>
                  <div class="input-group">
                     <span class="input-group-btn">
                          <span class="input-group-addon">هزینه یک ساعت مشاوره</span>
                     </span>
                     <input type="text" class="form-control input-mali number-text" placeholder="100000 ريال">
                  </div>
                </div>
<?php endif; ?>
                <div class="col-md-6 pull-right">
                  <button type="button" class="btn btn-success bottom-mali float-left">افزودن</button>
                  <div class="input-group">
                     <span class="input-group-btn">
                          <span class="input-group-addon">اعتبار</span>
                     </span>
                     <input type="text" class="form-control input-mali number-text" placeholder="100000 ريال">
                  </div>
                </div>
              </div>
              <div class="row margin-bot-2 pull-right">
                <div class="col-md-*">
                  <div class="input-group">
                     <span class="input-group-btn">
                          <span class="input-group-addon">موجودی</span>
                     </span>
                     <input type="text" class="form-control input-mali number-text" readonly value="100000 ريال">
                  </div>
                </div>
              </div>
              <div class="row">
                <table class="table table-striped table-condensed">
                  <thead>
                  <tr>
                      <th>رسید</th>
                      <th>تاریخ</th>
                      <th>مبلغ</th>
                  </tr>
              </thead>
              <tbody id="inv">

              </tbody>

            </table>

            <ul class="pagination" id="pagination">
              <?php
                if ($stmt = $mysqli->prepare("SELECT count(id) FROM invoice AS r WHERE r.uid = ?")):
                    $stmt->bind_param('i', $uid);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($cnt);
                    $stmt->fetch();
                    for ($cnti = 1; $cnti <= ceil($cnt / 9); $cnti++):
              ?>
                <li class="<?php echo (1 == $cnti ? "active" : ""); ?>"><a href="#" id="<?php echo "$cnti"; ?>"><?php echo "$cnti"; ?></a></li>
              <?php
                endfor;
                endif;
              ?>
            </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php include("pages/footer.php"); ?>
