<?php
  include_once($_SERVER['DOCUMENT_ROOT'].'/assets/functions.php');
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
 } elseif ($isdr === 1) {
   redirect("profile-doctor.php") ;die();
 }
		include("pages/header.php");head("norm");

    $mysqli = isset($mysqli) ? $mysqli : Connection();
    $info = pull_out_users_data();
  ?>

<div id="could_pass">
</div>
      <!-- section 3 -->
      <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
            <div class="panel-body tcbot-body">
            </div>
            </div>
          </div>
      </div>
      <!-- section 3 -->
      <!-- section 2  -->
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default">
          <div class="panel-body">
            <div id="show-dr"></div>
            <ul class="pagination" id="pagination">
    				<?php
    					if ($stmt = $mysqli->prepare("SELECT count(id) FROM users where isdr = 1")):
    					$stmt->execute();
    					$stmt->store_result();
    					$stmt->bind_result($cnt);
    					$stmt->fetch();
    					for ($cnti = 1; $cnti <= ceil($cnt / 8); $cnti++):
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
 <!-- style="display: none; position: fixed;top: 10%;width: 50%;right: 25%;left: 25%;border: 2px;border-style: solid;background-color: whitesmoke;z-index: 99999;z-index: 99999;" -->
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
           <form id="step2-form">
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
                 <input type="radio" class="s1gen" name="s1gen" id="s1gen_m" value="1" <?php echo ("{$info['gender']}" === 1 ? "checked" : ""); ?>>مرد
              </label>
               <label>
                 <input type="radio" class="s1gen" name="s1gen" id="s1gen_f" value="0" <?php echo ("{$info['gender']}" === 0 ? "checked" : ""); ?>>زن
              </label>
               <label>
                 <input type="radio" class="s1gen" name="s1gen" id="s1gen_o" value="2" <?php echo ("{$info['gender']}" === 2 ? "checked" : ""); ?>>دیگر
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
           <label class="col-md-4 control-label">شغل</label>
         </div>
         <div class="form-group">
          <div class="col-md-7">
             <select class="form-control" id="s2f2mal" name="s2f2mal" value="" type="text">
              <option value="0" <?php echo ($info['salary'] == 0 ? "selected=\"selected\"" : ""); ?>>کمتر از 1200000</option>
              <option value="1" <?php echo ($info['salary'] == 1 ? "selected=\"selected\"" : ""); ?>>متوسط</option>
              <option value="2" <?php echo ($info['salary'] == 2 ? "selected=\"selected\"" : ""); ?>>بیشتر از 3000000</option>
             </select>
          </div>
          <label class="col-md-4 control-label">میزان درآمد</label>
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
               <label for="comment">تحصیلات</label>
             <select class="form-control" id="s3f1u" name="s3f1u" value="" type="text">
               <option value="0" <?php echo ($info['edu'] == 0 ? "selected=\"selected\"" : ""); ?>>زیر‌دیپلم</option>
               <option value="1" <?php echo ($info['edu'] == 1 ? "selected=\"selected\"" : ""); ?>>دیپلم</option>
               <option value="2" <?php echo ($info['edu'] == 2 ? "selected=\"selected\"" : ""); ?>>کارشناسی</option>
               <option value="3" <?php echo ($info['edu'] == 3 ? "selected=\"selected\"" : ""); ?>>ارشد</option>
               <option value="4" <?php echo ($info['edu'] == 4 ? "selected=\"selected\"" : ""); ?>>دکترا</option>
             </select>
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

          <ul class="list-inline pull-left">
            <li><button type="button" class="btn btn-default">ثبت</button></li>
          </ul>
        </form>
       </div>
     </div>
     </div>
     </div>

			<div class="row" id="smoshaver-popup">
			</div>
      <!-- section 2  -->
      <?php include("pages/footer.php"); ?>
