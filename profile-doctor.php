<?php
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/functions.php");
  if(isset($_POST['exit_btn'])) {
    lagout() ;
    saferedirect("login.php") ;
  }
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
if($isdr === false) {
  redirect("login.php");
} elseif ($isdr === 0) {
  redirect("profile-doctor.php") ;
}

  $mysqli = isset($mysqli) ? $mysqli : Connection();

  $info = pull_out_users_data();


?>

<?php
  // in script baraye check kardan email hast ke dar qesmat form
  // davat be site to page profile-doctor hast
  // age taraf email vared kone vasash mail davat be site mifreste !

  // SECURITY BUG
  if(isset($_POST['send_mail'])) {
    $email = $_POST['send_mail'] ;
    $subject = "دعوت به سایت" ;
    $message = "welcome to telepathy webiste !" ;
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
      sendemail($email, $subject, $message) ;
    }
  }
?>
<?php include("pages/header.php");head("doc"); ?>
      <!-- section 3 -->
      <div id="could_pass">
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default">
          <div class="panel-body">
						<div class="row" style="margin-top: 25px;margin-bottom: 25px;">
              <form action="profile-doctor.php" method="post">
                <div class="pull-left" style="display: flex;width: 100%;">
									<input class="form-control" name="send_mail" placeholder="پست‌الکترونیکی / شماره تلفن" style="width: 100%;margin-left: 10px;" type="text">
									<button type="submit" class="btn btn-success" style="margin-left: 36px;">
											<i class="fa fa-heart" aria-hidden="true"></i>
											دعوت به سایت
									</button>
								</div>
              </form>

							<table class="table table-striped">
								<thead>
										<tr>
												<th>شماره</th>
												<th>تاریخ</th>
												<th>نام و نام‌خانوادگی</th>
												<th>ملاحظات</th>
												<th></th>
										</tr>
								</thead>
								<tbody id="p-show">
								</tbody>
						</table>

              <ul class="pagination" id="pagination">
        				<?php
        					if ($stmt = $mysqli->prepare("SELECT count(id) FROM reservation AS r WHERE r.did = ?")):
                      $stmt->bind_param('i', $uid);
            					$stmt->execute();
            					$stmt->store_result();
            					$stmt->bind_result($cnt);
            					$stmt->fetch();
        					    for ($cnti = 1; $cnti <= ceil($cnt / 5); $cnti++):
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
      <!-- section 3 -->
      <!-- section 2  -->
      <div class="row" id="settings-popup">
        <div class="row" style="margin-top: 30px;min-width: 500px;">
          <div class="col-md-3 pull-right">
            <ul class="nav nav-pills nav-stacked" dir="rtl">
              <li class="active"><a data-toggle="tab" href="#t1">اطلاعات شخصی</a></li>
              <li><a data-toggle="tab" href="#t2">اطلاعات مالی</a></li>
              <li><a data-toggle="tab" href="#t3">اطلاعات‌تماس</a></li>
              <li><a data-toggle="tab" href="#t4">اطلاعات تماس</a></li>
            </ul>
         </div>
        <div class="col-md-9 tab-content">
          <div id="t1" class="tab-pane fade in active">
            <h3>اطلاعات شخصی</h3>
            <form id="step1-form">
            <div class="row">
              <div class="form-group">
                <div class="col-md-7">
                  <input class="form-control" name="s1name" id="s1name" value="<?php echo "{$info['name']}"; ?>" type="text">
                </div>
                <label class="col-md-4 control-label">نام</label>
              </div>
              <div class="form-group">
                <div class="col-md-7">
                  <input class="form-control" name="s1fname" id="s1fname" value="<?php echo "{$info['fname']}"; ?>" type="text">
                </div>
                <label class="col-md-4 control-label">نام خانوادگی</label>
              </div>
              <div class="form-group">
                <div class="col-md-7">
                  <input class="form-control" name="s1email" id="s1email" value="<?php echo "{$info['email']}"; ?>" dir="ltr" disabled="" type="text">
                </div>
                <label class="col-md-4 control-label">پست الکترونیک</label>
              </div>
              <div class="form-group">
                <div class="col-md-7">
                  <input class="form-control" name="s1user" id="s1user" value="<?php echo "{$info['username']}"; ?>" dir="ltr" disabled="" type="text">
                </div>
                <label class="col-md-4 control-label">نام کاربری</label>
              </div>
            </div>
          <div class="row">
            <div class="form-group">
              <div class="col-md-7">
                <label>
                  <input type="radio" class="s1gen" name="s1gen" id="s1gen_m" value="1" <?php echo ($info['gender'] === 1 ? "checked=\"checked\"" : ""); ?>>مرد
               </label>
                <label>
                  <input type="radio" class="s1gen" name="s1gen" id="s1gen_f" value="0" <?php echo ($info['gender'] === 0 ? "checked=\"checked\"" : ""); ?>>زن
               </label>
                <label>
                  <input type="radio" class="s1gen" name="s1gen" id="s1gen_o" value="2" <?php echo ($info['gender'] === 2 ? "checked=\"checked\"" : ""); ?>>دیگر
               </label>
              </div>
              <label class="control-label col-md-2 col-xs-12">جنسیت</label>
            </div>
          </div>
          <div class="row">
            <div class="form-group">
              <div class="col-md-7">
                <input name="s1nid" id="s1nid" value="<?php echo "{$info['ncode']}"; ?>" maxlength="10" class="form-control number" type="text">
              </div>
              <label class="control-label col-md-2 col-xs-12">شماره ملی</label>
            </div>
            <div class="form-group">
              <div class="col-md-7">
                <input name="s1cid" id="s1cid" value="<?php echo "{$info['scode']}"; ?>" class="form-control" type="text">
              </div>
              <label class="control-label col-md-2 col-xs-12">شماره شناسنامه</label>
            </div>
            <div class="form-group">
              <div class="col-md-7">
                <div id="fullcalendar"></div>
                <input name="s1bday" id="s1bday" value="<?php echo "{$info['bday']}"; ?>" class="form-control datepicker" type="text">
              </div>
              <label class="control-label col-md-2 col-xs-12">تاریخ تولد</label>
            </div>
          </div>
           <ul class="list-inline pull-left">
             <li><button type="button" class="btn btn-default">ثبت</button></li>
           </ul>
           </form>
        </div>
        <div id="t2" class="tab-pane fade">
          <h3>اطلاعات مالی</h3>
          <form id="step2-form">
            <div class="row">
          <div class="form-group">
            <div class="col-md-7">
              <input class="form-control" id="s2f1mal" name="s2f1mal" value="<?php echo "{$info['iban']}"; ?>" type="text">
            </div>
            <label class="col-md-4 control-label">شماره شبا</label>
          </div>
          <div class="form-group">
            <div class="col-md-7">
               <input class="form-control" id="s2f2mal" name="s2f2mal"  value="<?php echo "{$info['salary']}"; ?>" type="text">
            </div>
            <label class="col-md-4 control-label">هزینه‌یکساعت‌مشاوره</label>
          </div></div>
           <ul class="list-inline pull-left">
             <li><button type="button" class="btn btn-default">ثبت</button></li>
           </ul>
          </form>
        </div>
        <div id="t3" class="tab-pane fade">
          <h3>اطلاعات‌تماس</h3>
          <form class="form-horizontal" id="step3-form">
            <div class="form-group">
              <label for="comment">شماره‌نظام‌روانشناسی</label>
              <input type="text" class="form-control" rows="5" id="drcode" name="drcode" value="<?php echo "{$info['drcode']}"; ?>"></input>
            </div>
            <div class="form-group">
              <label for="comment">تخصص‌ها</label>
            <div class="row" id="p-">
                  <?php
                  $takh1 = $takh2 = $takh3 = $takh4 = $takh5 = $takh6 = $takh7 = $takh8 = $takh9 = $takh10 = $takh11 = false;
                  $p12 = 12;
                    if ($stmt = $mysqli->prepare("SELECT * FROM takhasos WHERE uid = ?")):
                        $stmt->bind_param('i', $uid);
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($tid, $tuid, $tname);
                        $stmt->fetch();
                        while ($stmt->fetch()):
                          if (strpos($tname, 'استرس') !== false):
                            $takh1 = true;
                          elseif (strpos($tname, 'وسواس') !== false):
                            $takh2 = true;
                          elseif (strpos($tname, 'روابط بین فردی') !== false):
                            $takh3 = true;
                          elseif (strpos($tname, 'رابطه') !== false):
                            $takh4 = true;
                          elseif (strpos($tname, 'اختلالات اضطرابی') !== false):
                            $takh5 = true;
                          elseif (strpos($tname, 'اختلالات شخصیت') !== false):
                            $takh6 = true;
                          elseif (strpos($tname, 'افسردگی') !== false):
                            $takh7 = true;
                          elseif (strpos($tname, 'خانواده') !== false):
                            $takh8 = true;
                          elseif (strpos($tname, 'کنکور / مشاوره‌درسی') !== false):
                            $takh9 = true;
                          elseif (strpos($tname, 'مسائل جنسی') !== false):
                            $takh10 = true;
                          elseif (strpos($tname, 'کنترل خشم') !== false):
                            $takh11 = true;
                          else:
                  ?>
                      <label for="p-<?php echo $p12; ?>" class="btn btn-default child"><?php echo "{$tname}"; ?><input type="checkbox" id="p-<?php echo $p12;$p12++; ?>" <?php echo "checked=\"checked\""; ?> class="badgebox takhasos" name="takhasos" value="<?php echo "{$tname}"; ?>"><span class="badge">&check;</span></label>
                  <?php
                          endif;
                  ?>
                  <?php
                    endwhile;
                    endif;
                  ?>
                  <label for="p-1" class="btn btn-default child">استرس <input type="checkbox" id="p-1" <?php echo ($takh1 ? "checked=\"checked\"" : ""); ?> class="badgebox takhasos" name="takhasos" value="استرس"><span class="badge">&check;</span></label>
                  <label for="p-2" class="btn btn-default child">وسواس <input type="checkbox" id="p-2" <?php echo ($takh2 ? "checked=\"checked\"" : ""); ?> class="badgebox takhasos" name="takhasos" value="وسواس"><span class="badge">&check;</span></label>
                  <label for="p-3" class="btn btn-default child">روابط بین فردی <input type="checkbox" id="p-3" <?php echo ($takh3 ? "checked=\"checked\"" : ""); ?> class="badgebox takhasos" name="takhasos" value="روابط بین فرد"><span class="badge">&check;</span></label>
                  <label for="p-4" class="btn btn-default child">رابطه <input type="checkbox" id="p-4" <?php echo ($takh4 ? "checked=\"checked\"" : ""); ?> class="badgebox takhasos" name="takhasos" value="رابطه"><span class="badge">&check;</span></label>
                  <label for="p-5" class="btn btn-default child">اختلالات اضطرابی <input type="checkbox" id="p-5" <?php echo ($takh5 ? "checked=\"checked\"" : ""); ?> class="badgebox takhasos" name="takhasos" value="اختلالات اضطراب"><span class="badge">&check;</span></label>
                  <label for="p-6" class="btn btn-default child">اختلالات شخصیت <input type="checkbox" id="p-6" <?php echo ($takh6 ? "checked=\"checked\"" : ""); ?> class="badgebox takhasos" name="takhasos" value="اختلالات شخصی"><span class="badge">&check;</span></label>
                  <label for="p-7" class="btn btn-default child">افسردگی <input type="checkbox" id="p-7" <?php echo ($takh7 ? "checked=\"checked\"" : ""); ?> class="badgebox takhasos" name="takhasos" value="افسردگی"><span class="badge">&check;</span></label>
                  <label for="p-8" class="btn btn-default child">خانواده <input type="checkbox" id="p-8" <?php echo ($takh8 ? "checked=\"checked\"" : ""); ?> class="badgebox takhasos" name="takhasos" value="خانواده"><span class="badge">&check;</span></label>
                  <label for="p-9" class="btn btn-default child">کنکور / مشاوره‌درسی <input type="checkbox" id="p-9" <?php echo ($takh9 ? "checked=\"checked\"" : ""); ?> class="badgebox takhasos" name="takhasos" value="کنکور / مشاوره‌درس"><span class="badge">&check;</span></label>
                  <label for="p-10" class="btn btn-default child">مسائل جنسی <input type="checkbox" id="p-10" <?php echo ($takh10 ? "checked=\"checked\"" : ""); ?> class="badgebox takhasos" name="takhasos" value="مسائل جنسی"><span class="badge">&check;</span></label>
                  <label for="p-11" class="btn btn-default child">کنترل خشم <input type="checkbox" id="p-11" <?php echo ($takh11 ? "checked=\"checked\"" : ""); ?> class="badgebox takhasos" name="takhasos" value="کنترل خشم"><span class="badge">&check;</span></label>

            </div>
            <div class="row">
                  <div class="col-md-5" style="display: inline-flex;float: right;margin-top: 10px;">
                         <input class="form-control" id="p-n" placeholder="تخصص" type="text">
  <button type="button" class="btn btn-success" style="margin-right: 10px;" id="p-b">
  <i class="fa fa-plus" aria-hidden="true"></i>
                         </button>
                  </div>
            </div>
            </div>
            <div class="form-group">
              <label for="comment">رویکردها</label>
                  <div class="row" id="m-">
                    <?php
                    $takh1 = $takh2 = $takh3 = $takh4 = $takh5 = $takh6 = $takh7 = $takh8 = false;
                    $p12 = 12;
                      if ($stmt = $mysqli->prepare("SELECT * FROM takhasos WHERE uid = ?")):
                          $stmt->bind_param('i', $uid);
                          $stmt->execute();
                          $stmt->store_result();
                          $stmt->bind_result($tid, $tuid, $tname);
                          $stmt->fetch();
                          while ($stmt->fetch()):
                            if (strpos($tname, 'درمان شناختی رفتاری') !== false):
                              $takh1 = true;
                            elseif (strpos($tname, 'درمان روان کاوی') !== false):
                              $takh2 = true;
                            elseif (strpos($tname, 'درمان روان پوشی') !== false):
                              $takh3 = true;
                            elseif (strpos($tname, 'درمان ترنس پرسنال') !== false):
                              $takh4 = true;
                            elseif (strpos($tname, 'درمان اگزیستانسیالیست') !== false):
                              $takh5 = true;
                            elseif (strpos($tname, 'درمان زوج') !== false):
                              $takh6 = true;
                            elseif (strpos($tname, 'درمان گروهی') !== false):
                              $takh7 = true;
                            elseif (strpos($tname, 'درمان معنایی') !== false):
                              $takh8 = true;
                            else:
                    ?>
                        <label for="m-<?php echo $p12; ?>" class="btn btn-default child"><?php echo "{$tname}"; ?><input type="checkbox" id="m-<?php echo $p12;$p12++; ?>" <?php echo "checked=\"checked\""; ?> class="badgebox roykard" name="roykard" value="<?php echo "{$tname}"; ?>"><span class="badge">&check;</span></label>
                    <?php
                            endif;
                    ?>
                    <?php
                      endwhile;
                      endif;
                    ?>
                        <label for="m-1" class="btn btn-default child">درمان شناختی رفتاری <input type="checkbox" id="m-1"  <?php echo ($takh1 ? "checked=\"checked\"" : ""); ?>  class="badgebox roykard" name="roykard" value="درمان شناختی رفتاری"><span class="badge">&check;</span></label>
                        <label for="m-2" class="btn btn-default child">درمان روان کاوی <input type="checkbox" id="m-2"  <?php echo ($takh2 ? "checked=\"checked\"" : ""); ?>  class="badgebox roykard" name="roykard" value="درمان روان کاوی"><span class="badge">&check;</span></label>
                        <label for="m-3" class="btn btn-default child">درمان روان پوشی <input type="checkbox" id="m-3"  <?php echo ($takh3 ? "checked=\"checked\"" : ""); ?>  class="badgebox roykard" name="roykard" value="درمان روان پوشی"><span class="badge">&check;</span></label>
                        <label for="m-4" class="btn btn-default child">درمان ترنس پرسنال <input type="checkbox" id="m-4"  <?php echo ($takh4 ? "checked=\"checked\"" : ""); ?>  class="badgebox roykard" name="roykard" value="درمان ترنس پرسنال"><span class="badge">&check;</span></label>
                        <label for="m-5" class="btn btn-default child">درمان اگزیستانسیالیست <input type="checkbox" id="m-5"  <?php echo ($takh5 ? "checked=\"checked\"" : ""); ?>  class="badgebox roykard" name="roykard" value="درمان اگزیستانسیالیست"><span class="badge">&check;</span></label>
                        <label for="m-6" class="btn btn-default child">درمان زوج <input type="checkbox" id="m-6"  <?php echo ($takh6 ? "checked=\"checked\"" : ""); ?>  class="badgebox roykard" name="roykard" value="درمان زوج"><span class="badge">&check;</span></label>
                        <label for="m-7" class="btn btn-default child">درمان گروهی <input type="checkbox" id="m-7"  <?php echo ($takh7 ? "checked=\"checked\"" : ""); ?>  class="badgebox roykard" name="roykard" value="درمان گروهی"><span class="badge">&check;</span></label>
                        <label for="m-8" class="btn btn-default child">درمان معنایی <input type="checkbox" id="m-8"  <?php echo ($takh8 ? "checked=\"checked\"" : ""); ?>  class="badgebox roykard" name="roykard" value="درمان معنایی"><span class="badge">&check;</span></label>
                  </div>
                  <div class="row">
                        <div class="col-md-5" style="display: inline-flex;float: right;margin-top: 10px;">
                              <input class="form-control" id="m-n" placeholder="رویکرد" type="text">
  <button type="button" class="btn btn-success" style="margin-right: 10px;" id="m-b" >
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        </button>
                        </div>
                          </Div>
            </div>
          <div class="form-group">
             <label for="comment">بیوگرافی</label>
             <textarea class="form-control" rows="5" id="s3f2" name="s3f2" value="<?php echo "{$info['bio']}"; ?>"><?php echo "{$info['bio']}"; ?></textarea>
          </div>

           <ul class="list-inline pull-left">
             <li><button type="button" class="btn btn-default">ثبت</button></li>
           </ul>
        </form>
        </div>
        <div id="t4" class="tab-pane fade">
          <h3>اطلاعات‌تماس</h3>
            <form id="step4-form">
              <input id="w" name="w" value="4" type="hidden">
              <input id="token" name="token" value="" type="hidden">
          <div class="form-group">
             <label for="">عکس:</label>
             <span class="btn btn-success fileinput-button">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Select files...</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload" name="fileupload[]" accept="image/jpeg, image/jpg" multiple="" type="file">
          <img id="outputimg" src="<?php echo "{$info['picture']}"; ?>" />
          </span>
          </div>
          <div class="form-group">
             <label for="">شماره همراه:</label>
             <input class="form-control" placeholder="09350000000" value="<?php echo "{$info['phone']}"; ?>" id="s4phone" name="s4phone" required="" type="text">
          </div>

          <div class="form-group">
             <label for="">استان:</label>
             <select class="form-control province"  id="s4province" name="s4province">
              <option>استان</option>
              <?php echo "<option selected=\"selected\">{$info['province']}</option>"; ?>
             </select>
          </div>

          <div class="form-group">
             <label for="">شهر:</label>
             <select class="form-control city"  id="s4city" name="s4city">
              <option>شهر</option>
              <?php echo "<option selected=\"selected\">{$info['city']}</option>"; ?>
             </select>
          </div>

          <div class="form-group">
             <label for="">آدرس:</label>
             <textarea class="form-control" placeholder="آدرس" value="<?php echo "{$info['addr']}"; ?>" required="" type="text" id="s4addr" name="s4addr"><?php echo "{$info['addr']}"; ?></textarea>
          </div>

          <div class="form-group">
             <label for="">کد پستی:</label>
             <input class="form-control" placeholder="00000000000" value="<?php echo "{$info['pcode']}"; ?>" required="" type="text" id="s4post" name="s4post">
          </div>

          <div class="form-group">
             <label for="">شماره مطب:</label>
             <input class="form-control" placeholder="05130000000" required="" type="text" id="s4drphone" name="s4drphone" value="<?php echo "{$info['drphone']}"; ?>">
          </div>

           <ul class="list-inline pull-left">
             <li><button type="button" class="btn btn-default">ثبت</button></li>
           </ul>
         </form>
        </div>
      </div>
      </div>
      </div>
      <!-- section 2  -->
      <?php include("pages/footer.php"); ?>
