<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/assets/functions.php');

$mysqli = isset($mysqli) ? $mysqli : Connection();

$log_check = login_check("wizard") ;
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
	$uid = $mysqli->real_escape_string($_SESSION['user_id']);
}
$isdr = $log_check[1];

if (isset($_SESSION['wizard']) && $_SESSION['wizard'] == 1) {
      if($log_check[0] === true && $log_check[1] === 1) {
      // dr dashbord !
      redirect(urlencode("profile-doctor.php")) ;
    } elseif($log_check[0] === true && $log_check[1] === 0) {
      // patient dashbord !
      redirect(urlencode("profile-user.php")) ;
    }
    else {
      // there was some errros !
      $alrt = 0 ;
    }
}


$sql = "SELECT username, fname, name, email, age, phone, gender, register_date, picture, drcode, register_ip, drphone, scode, ncode, bday, iban, salary, edu, bio, province, city, addr, pcode, drphone FROM users WHERE id = ?";
if ($stmt = $mysqli->prepare($sql)) {
	$stmt->bind_param('i', $uid);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($username, $fname, $name, $email, $age, $phone, $gender, $register_date, $picture, $drcode, $register_ip, $drphone, $scode, $ncode, $bday, $s2f1mal, $s2f2mal, $s3f1u, $s3f2, $province, $city, $addr, $pcode, $drphone);
	$stmt->fetch();
}

include("pages/header.php");head(""); ?>
      <!-- section 3 -->
		<div id="could_pass">
		</div>
      <div class="row">
            <div class="wizard">
                <div class="wizard-inner  color-full">
                    <div class="connecting-line"></div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="">
                                <span class="round-tab">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="">
                                <span class="round-tab">
                                    <i class="fa fa-puzzle-piece" aria-hidden="true"></i>
                                </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="">
                                <span class="round-tab">
                                    <i class="fa fa-id-card" aria-hidden="true"></i>
                                </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab" title="">
                                <span class="round-tab">
                                    <i class="fa fa-tasks" aria-hidden="true"></i>
                                </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="">
                                <span class="round-tab">
                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
                    <div class="tab-content" style="padding: 0% 5% 5% 5%;">
                        <div class="tab-pane active" role="tabpanel" id="step1">
							<form id="step1-form">
                           <h3><span class="fa fa-pencil">
                                                  </span>اطلاعات ثبت‌نام</h3>
                           <p class="plain-text">اطلاعات شخصی شما به صورت محرمانه نگهداری خواهد شد.</p>
                           <hr>
						    <div class="row">
								<div class="form-group">
									<div class="col-md-7">
										<input class="form-control" name="s1name" id="s1name" value="<?php echo "$name"; ?>" type="text">
									</div>
									<label class="col-md-4 control-label">نام</label>
								</div>
								<div class="form-group">
								   <div class="col-md-7">
										<input class="form-control" name="s1fname" id="s1fname" value="<?php echo "$fname"; ?>" type="text">
									</div>
									<label class="col-md-4 control-label">نام خانوادگی</label>
								</div>
								<div class="form-group">
									<div class="col-md-7">
										<input class="form-control" name="s1email" id="s1email" value="<?php echo "$email"; ?>" dir="ltr" disabled="" type="text">
									</div>
									<label class="col-md-4 control-label">پست الکترونیک</label>
								</div>
								<div class="form-group">
									<div class="col-md-7">
										<input class="form-control" name="s1user" id="s1user" value="<?php echo "$username"; ?>" dir="ltr" disabled="" type="text">
									</div>
									<label class="col-md-4 control-label">نام کاربری</label>
								</div>
                            </div>
							<div class="row">
                           <div class="form-group">
                               <div class="col-md-7">
                                   <label>
                                       <input type="radio" class="s1gen" name="s1gen" id="s1gen_m" value="1" <?php echo ($gender === 1 ? "checked" : ""); ?>>مرد
								   </label>
                                   <label>
                                       <input type="radio" class="s1gen" name="s1gen" id="s1gen_f" value="0" <?php echo ($gender === 0 ? "checked" : ""); ?>>زن
								   </label>
                                   <label>
                                       <input type="radio" class="s1gen" name="s1gen" id="s1gen_o" value="2" <?php echo ($gender === 2 ? "checked" : ""); ?>>دیگر
								   </label>
                               </div>
                               <label class="control-label col-md-2 col-xs-12">جنسیت</label>
                           </div>
							</div>
							<div class="row">
                           <div class="form-group">
                               <div class="col-md-7">
                                   <input name="s1nid" id="s1nid" value="<?php echo "$ncode"; ?>" maxlength="10" class="form-control number" type="text">
                               </div>
                               <label class="control-label col-md-2 col-xs-12">شماره ملی</label>
                           </div>
                           <div class="form-group">
                               <div class="col-md-7">
                                   <input name="s1cid" id="s1cid" value="<?php echo "$scode"; ?>" class="form-control" type="text">
                               </div>
                               <label class="control-label col-md-2 col-xs-12">شماره شناسنامه</label>
                           </div>
                           <div class="form-group">
                               <div class="col-md-7">
								   <div id="fullcalendar"></div>
                                   <input name="s1bday" id="s1bday" value="<?php echo "$bday"; ?>" class="form-control datepicker" type="text">
                               </div>
                               <label class="control-label col-md-2 col-xs-12">تاریخ تولد</label>
                           </div>
                       </div>
                           <!--</div>  -->
                           <ul class="list-inline pull-left">
                               <li>
                                   <button type="button" id="s1btn" class="btn btn-primary next-step">ذخیره و ادامه</button>
                               </li>
                           </ul>
						   </form>
                       </div>
                        <div class="tab-pane" role="tabpanel" id="step2">
							<form id="step2-form">
								<h3><span class="fa fa-pencil">
													  </span>اطلاعات مالی</h3>
							   <p class="plain-text">اطلاعات شخصی شما به صورت محرمانه نگهداری خواهد شد.</p>
							   <hr>
							   <div class="form-group">
								   <?php if ($isdr): ?>
								   <div class="col-md-7">
									   <input class="form-control" id="s2f1mal" name="s2f1mal" value="<?php echo "$s2f1mal"; ?>" type="text">
								   </div>
								   <label class="col-md-4 control-label">شماره شبا</label>
								   <?php else: ?>
								   <div class="col-md-7">
									   <input class="form-control" id="s2f1mal" name="s2f1mal" value="<?php echo "$s2f1mal"; ?>" type="text">
								   </div>
								   <label class="col-md-4 control-label">شغل</label>
								   <?php endif; ?>
							   </div>
							   <div class="form-group">
								  <?php if ($isdr): ?>
								  <div class="col-md-7">
									   <input class="form-control" id="s2f2mal" name="s2f2mal"  value="<?php echo "$s2f2mal"; ?>" type="text">
								  </div>
								  <label class="col-md-4 control-label">هزینه‌یکساعت‌مشاوره</label>
								  <?php else: ?>
								  <div class="col-md-7">
									   <select class="form-control" id="s2f2mal" name="s2f2mal" value="" type="text">
											<option value="0" <?php echo ($s2f2mal == 0 ? "selected=\"selected\"" : ""); ?>>کمتر از 1200000</option>
											<option value="1" <?php echo ($s2f2mal == 1 ? "selected=\"selected\"" : ""); ?>>متوسط</option>
											<option value="2" <?php echo ($s2f2mal == 2 ? "selected=\"selected\"" : ""); ?>>بیشتر از 3000000</option>
									   </select>
								  </div>
								  <label class="col-md-4 control-label">میزان درآمد</label>
								  <?php endif; ?>
							   </div>
								<ul class="list-inline pull-left">
									<li><button type="button" class="btn btn-default prev-step">صفحه قبل</button></li>
									<li><button type="button" id="s2btn" class="btn btn-primary next-step">ذخیره و ادامه</button></li>
								</ul>
							</form>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="step3">
                            <form class="form-horizontal" id="step3-form">
                              <h3></h3>
                              <p>اطلاعات‌تماس</p>
                              <?php if($isdr): ?>
                              <div class="form-group">
                                <label for="comment">شماره‌نظام‌روانشناسی</label>
                                <input type="text" class="form-control" rows="5" id="drcode" name="drcode" value="<?php echo "$drcode" ?>"></input>
                              </div>
                              <div class="form-group">
                                <label for="comment">تخصص‌ها</label>
                              <div class="row" id="p-">
                                    <label for="p-1" class="btn btn-default child">استرس <input type="checkbox" id="p-1" class="badgebox takhasos" name="takhasos" value="استرس"><span class="badge">&check;</span></label>
                                    <label for="p-2" class="btn btn-default child">وسواس <input type="checkbox" id="p-2" class="badgebox takhasos" name="takhasos" value="وسواس"><span class="badge">&check;</span></label>
                                    <label for="p-3" class="btn btn-default child">روابط بین فردی <input type="checkbox" id="p-3" class="badgebox takhasos" name="takhasos" value="روابط بین فرد"><span class="badge">&check;</span></label>
                                    <label for="p-4" class="btn btn-default child">رابطه <input type="checkbox" id="p-4" class="badgebox takhasos" name="takhasos" value="رابطه"><span class="badge">&check;</span></label>
                                    <label for="p-5" class="btn btn-default child">اختلالات اضطرابی <input type="checkbox" id="p-5" class="badgebox takhasos" name="takhasos" value="اختلالات اضطراب"><span class="badge">&check;</span></label>
                                    <label for="p-6" class="btn btn-default child">اختلالات شخصیت <input type="checkbox" id="p-6" class="badgebox takhasos" name="takhasos" value="اختلالات شخصی"><span class="badge">&check;</span></label>
                                    <label for="p-7" class="btn btn-default child">افسردگی <input type="checkbox" id="p-7" class="badgebox takhasos" name="takhasos" value="افسردگی"><span class="badge">&check;</span></label>
                                    <label for="p-8" class="btn btn-default child">خانواده <input type="checkbox" id="p-8" class="badgebox takhasos" name="takhasos" value="خانواده"><span class="badge">&check;</span></label>
                                    <label for="p-9" class="btn btn-default child">کنکور / مشاوره‌درسی <input type="checkbox" id="p-9" class="badgebox takhasos" name="takhasos" value="کنکور / مشاوره‌درس"><span class="badge">&check;</span></label>
                                    <label for="p-10" class="btn btn-default child">مسائل جنسی <input type="checkbox" id="p-10" class="badgebox takhasos" name="takhasos" value="مسائل جنسی"><span class="badge">&check;</span></label>
                                    <label for="p-11" class="btn btn-default child">کنترل خشم <input type="checkbox" id="p-11" class="badgebox takhasos" name="takhasos" value="کنترل خشم"><span class="badge">&check;</span></label>
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
                                          <label for="m-1" class="btn btn-default child">درمان شناختی رفتاری <input type="checkbox" id="m-1" class="badgebox roykard" name="roykard" value="درمان شناختی رفتاری"><span class="badge">&check;</span></label>
                                          <label for="m-2" class="btn btn-default child">درمان روان کاوی <input type="checkbox" id="m-2" class="badgebox roykard" name="roykard" value="درمان روان کاوی"><span class="badge">&check;</span></label>
                                          <label for="m-3" class="btn btn-default child">درمان روان پوشی <input type="checkbox" id="m-3" class="badgebox roykard" name="roykard" value="درمان روان پوشی"><span class="badge">&check;</span></label>
                                          <label for="m-4" class="btn btn-default child">درمان ترنس پرسنال <input type="checkbox" id="m-4" class="badgebox roykard" name="roykard" value="درمان ترنس پرسنال"><span class="badge">&check;</span></label>
                                          <label for="m-5" class="btn btn-default child">درمان اگزیستانسیالیست <input type="checkbox" id="m-5" class="badgebox roykard" name="roykard" value="درمان اگزیستانسیالیست"><span class="badge">&check;</span></label>
                                          <label for="m-6" class="btn btn-default child">درمان زوج <input type="checkbox" id="m-6" class="badgebox roykard" name="roykard" value="درمان زوج"><span class="badge">&check;</span></label>
                                          <label for="m-7" class="btn btn-default child">درمان گروهی <input type="checkbox" id="m-7" class="badgebox roykard" name="roykard" value="درمان گروهی"><span class="badge">&check;</span></label>
                                          <label for="m-8" class="btn btn-default child">درمان معنایی <input type="checkbox" id="m-8" class="badgebox roykard" name="roykard" value="درمان معنایی"><span class="badge">&check;</span></label>
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
                              <?php else: ?>
                              <div class="form-group">
                                    <label for="comment">تحصیلات</label>
																	<select class="form-control" id="s3f1u" name="s3f1u" value="" type="text">
																		<option value="0" <?php echo ($s3f1u == 0 ? "selected=\"selected\"" : ""); ?>>زیر‌دیپلم</option>
																		<option value="1" <?php echo ($s3f1u == 1 ? "selected=\"selected\"" : ""); ?>>دیپلم</option>
																		<option value="2" <?php echo ($s3f1u == 2 ? "selected=\"selected\"" : ""); ?>>کارشناسی</option>
																		<option value="3" <?php echo ($s3f1u == 3 ? "selected=\"selected\"" : ""); ?>>ارشد</option>
																		<option value="4" <?php echo ($s3f1u == 4 ? "selected=\"selected\"" : ""); ?>>دکترا</option>
																	</select>
                              </div>
                              <?php endif; ?>
															<div class="form-group">
                                 <label for="comment">بیوگرافی</label>
                                 <textarea class="form-control" rows="5" id="s3f2" name="s3f2" value="<?php echo "$s3f2"; ?>"><?php echo "$s3f2"; ?></textarea>
                              </div>
                            </form>
                            <ul class="list-inline pull-left">
                                <li><button type="button" class="btn btn-default prev-step">صفحه قبل</button></li>
                                <li><button type="button" class="btn btn-primary next-step" id="s3btn" >ذخیره و ادامه</button></li>
                            </ul>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="step4">
													<form id="step4-form">
                            <h3>اطلاعات تماس</h3>
                            <div class="form-group">
                               <label for="">عکس:</label>
                               <span class="btn btn-success fileinput-button">
															<i class="glyphicon glyphicon-plus"></i>
															<span>Select files...</span>
															<!-- The file input field used as target for the file upload widget -->
															<input id="fileupload" name="fileupload[]" accept="image/jpeg, image/jpg" multiple="" type="file">
														<img id="outputimg" src="<?php echo "$picture"; ?>" />
													  </span>
                            </div>
                            <div class="form-group">
                               <label for="">شماره همراه:</label>
                               <input class="form-control" placeholder="09350000000" value="<?php echo "$phone"; ?>" id="s4phone" name="s4phone" required="" type="text">
                            </div>

                            <div class="form-group">
                               <label for="">استان:</label>
                               <select class="form-control province"  id="s4province" name="s4province">
																<option>استان</option>
																 <?php echo "<option selected=\"selected\">$province</option>"; ?>
															 </select>
                            </div>

                            <div class="form-group">
                               <label for="">شهر:</label>
                               <select class="form-control city"  id="s4city" name="s4city">
																<option>شهر</option>
																 <?php echo "<option selected=\"selected\">$city</option>"; ?>
															 </select>
                            </div>

                            <div class="form-group">
                               <label for="">آدرس:</label>
                               <textarea class="form-control" placeholder="آدرس" value="<?php echo "$addr"; ?>" required="" type="text" id="s4addr" name="s4addr"><?php echo "$addr"; ?></textarea>
                            </div>

                            <div class="form-group">
                               <label for="">کد پستی:</label>
                               <input class="form-control" placeholder="00000000000" value="<?php echo "$pcode"; ?>" required="" type="text" id="s4post" name="s4post">
                            </div>
                              <?php if ($isdr): ?>
                            <div class="form-group">
                               <label for="">شماره مطب:</label>
                               <input class="form-control" placeholder="05130000000" required="" type="text" id="s4drphone" name="s4drphone" value="<?php echo "$drphone"; ?>">
                            </div>
				    <?php endif; ?>
</form>
                            <ul class="list-inline pull-left">
                                <li><button type="button" class="btn btn-default prev-step">صفحه قبل</button></li>
                                <li><button type="button" class="btn btn-primary next-step"  id="s4btn" name="s4btn">ذخیره و ادامه</button></li>
                            </ul>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="complete">
                            <h3>قوانین استفاده</h3>
                            <p>افزودن ملاحظات کلی</p>
                            <div class="form-group" style="max-height: 300px;overflow: auto;">
                               <label for="comment">آیا خطری برای خود یا دیگران دارد:<br/><small>اگر بله توضیح دهید</small></label>
                               <p>dsasdasdadsadasasdasdasdasdasdasdasdasdsdadsa asdasdsadasasas</p>
                               <p>dsasdasdadsadasasdasdasdasdasdasdasdasdsdadsa asdasdsadasasas</p>
                               <p>dsasdasdadsadasasdasdasdasdasdasdasdasdsdadsa asdasdsadasasas</p>
                               <p>dsasdasdadsadasasdasdasdasdasdasdasdasdsdadsa asdasdsadasasas</p>
                               <p>dsasdasdadsadasasdasdasdasdasdasdasdasdsdadsa asdasdsadasasas</p>
                               <p>dsasdasdadsadasasdasdasdasdasdasdasdasdsdadsa asdasdsadasasas</p>
                               <p>dsasdasdadsadasasdasdasdasdasdasdasdasdsdadsa asdasdsadasasas</p>
                               <p>dsasdasdadsadasasdasdasdasdasdasdasdasdsdadsa asdasdsadasasas</p>
                               <p>dsasdasdadsadasasdasdasdasdasdasdasdasdsdadsa asdasdsadasasas</p>
                               <p>dsasdasdadsadasasdasdasdasdasdasdasdasdsdadsa asdasdsadasasas</p>
                            </div>
				    <div id="dialog" title="قوانین تلپاتی" hidden="hidden">
					<p>با قبول کردن قوانین شما بلا بلا بلا.....</p>
				    </div>
                            <ul class="list-inline pull-left">
					<li><button type="button" class="btn btn-default prev-step">صفحه قبل</button></li>
                                <li><button type="button" id="agreed" class="btn btn-primary end-step">پذیرفتن قوانین و ذخیره اطلاعات</button></li>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    </div>
            </div>


      </div>
      <!-- section 3 -->
      <!-- section 2  -->
      <!-- section 2  -->
      <?php include("pages/footer.php"); ?>
