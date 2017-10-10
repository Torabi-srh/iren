<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/functions.php");
   if(isset($_POST['exit_btn'])) {
     lagout() ;
     saferedirect("login.php") ;
   }
 $log_check = login_check() ;
  if ($log_check === false) {
    saferedirect("login.php") ;
  } else { 
    if($log_check[0] === false) {
      redirect("login.php") ;
    } elseif ($log_check[1] === 1) {
      redirect("profile-doctor.php") ;
    }
		
		include("pages/header.php");head("norm"); 
	
  }?>
      <!-- section 3 -->
      <div class="row">
        <div class="col-md-3">

            <div class="panel panel-default">
          <div class="panel-body">  <div class="  well pull-right-lg" style="border:0px solid">
    <div class="" style="padding:0px;">

        <table class="table table-bordered table-style table-responsive">
          <tr>
            <th colspan="2"><a href="?ym=<?php echo $prev; ?>"><span class="glyphicon glyphicon-chevron-left"></span></a></th>
            <th colspan="3"> Jan - 2017<!--?php echo $html_title; ?--></th>
            <th colspan="2"><a href="?ym=<?php echo $next; ?>"><span class="glyphicon glyphicon-chevron-right"></span></a></th>
          </tr>

           <?php
          // Set your timezone!!
          date_default_timezone_set('Asia/Dhaka');

          // Get prev & next month
          if (isset($_GET['ym'])) {
          	$ym = $_GET['ym'];
          } else {
          	// This month
          	$ym = date('Y-m');
          }

          // Check format
          $timestamp = strtotime($ym,"-01");
          if ($timestamp === false) {
          	$timestamp = time();
          }

          // Today
          $today = date('Y-m-j', time());

          // For H3 title
          $html_title = date('M - Y', $timestamp);

          // Create prev & next month link     mktime(hour,minute,second,month,day,year)
          $prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
          $next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));

          // Number of days in the month
          $day_count = date('t', $timestamp);

          // 0:Sun 1:Mon 2:Tue ...
          $str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));


          // Create Calendar!!
          $weeks = array();
          $week = '';

          // Add empty cell
          $week .= str_repeat('<td></td>', $str);

          for ( $day = 1; $day <= $day_count; $day++, $str++) {

          	$date = $ym.'-'.$day;

          	if ($today == $date) {
          		$week .= '<td class="today">'.$day;
          	} else {
          		$week .= '<td>'.$day;
          	}
          	$week .= '</td>';

          	// End of the week OR End of the month
          	if ($str % 7 == 6 || $day == $day_count) {

          		if($day == $day_count) {
          			// Add empty cell
          			$week .= str_repeat('<td></td>', 6 - ($str % 7));
          		}

          		$weeks[] = '<tr>'.$week.'</tr>';

          		// Prepare for new week
          		$week = '';

          	}

          }

          ?>
          <?php
            foreach ($weeks as $week) {
              echo $week;
            };
          ?>
        </table>

    </div>
  </div>


          </div>
          </div>
        </div>
        <div class="col-md-9">
          <div class="panel panel-default">
          <div class="panel-body" style="padding-bottom: 282px; background-image: url(http://placehold.it/250x250/f773dfdf/00000000/?text=clever%20bot); ">

          </div>
          </div>
        </div>
      </div>
      <!-- section 3 -->
      <!-- section 2  -->
      <div class="row">
        <?php
          $conn = Connection() ;
          $sql = "SELECT picture, fname, name FROM users where isdr = 1 LIMIT 8" ;
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              $profile_pic_name = $row['picture'] ;
              $full_name = $row['fname'] . " " . $row['name'] ;
              // echo $profile_pic_name ; die() ;
              $html_to_show = "<div class=\"col-sm-3\">
                <div class=\"panel-body\">
                  <div class=\"thumbnail\"><a id=\"xmoshaver-popup\" href=\"#\">
                    <img src=\"{$profile_pic_name}\" class=\"img-circle\" alt=\"Cinque Terre\" width=\"150\" height=\"150\">
                    <a style=\"margin:70px\">{$full_name}</a>
                    </a>
                  </div>
                </div>
              </div>" ;
              echo $html_to_show ;
            }
          }
          else {
            echo "Nothing to show !" ;
          }

          $conn->close();
        ?>
      </div>

			<div class="row " id="settings-popup" style="display: none; position: fixed;top: 10%;width: 50%;right: 25%;left: 25%;border: 2px;border-style: solid;background-color: whitesmoke;z-index: 99999;z-index: 99999;">
        <div class="col-*-*">
          <div class="panel-body">
							<a class="btn btn-default" id ="close-editClass" style="float: left;">X</a>
							<div class="form-group" style="width: 200px;float: right;">
								<img src="assets/images/users/no-image.jpg">
								<input class="btn btn-primary" id="pwd" style="margin-top: 10%;margin-right: 20%;" type="submit" value="انتخواب عکس">
							</div>
						 <div class="form-group" style="width: 200px;float: left;margin-left: 100px;margin-top: 5%;">
								<label for="usr">نام:</label>
								<input class="form-control" id="usr" type="text">

								<label for="pwd">فامیل:</label>
								<input class="form-control" id="pwd" type="text">
								<label for="pwd">تاریخ تولد:</label>
								<input class="form-control" id="pwd" type="date">
								<label for="pwd">پست الکترونیک:</label>
								<input class="form-control" id="pwd" type="text">

								<hr />

								<label for="usr">رمزعبور:</label>
								<input class="form-control" id="usr" type="password">
								<label for="pwd">تکراررمزعبور:</label>
								<input class="form-control" id="pwd" type="password">

								<input class="btn btn-default" id="pwd" type="submit" style="margin-top: 10px;" value="تغییر رمز عبور"></input>
				   		</div>

							<div class="form-group" style="width: 200px;float: right;margin-left: 100px;margin-top: 5%;">

				   		</div>
					</div>
				</div>
			</div>


			<div class="row" id="smoshaver-popup" style="display: none; position: fixed;top: 10%;width: 50%;right: 25%;left: 25%;border: 2px;border-style: solid;background-color: whitesmoke;z-index: 99999;">
        <div class="col-*-*">
          <div class="panel-body">
							<a class="btn btn-default" id ="close-smoshaverClass" style="float: left;">X</a>
							<div class="form-group" style="width: 200px;float: right;">
								<img src="assets/images/users/no-image.jpg">
								<span style="align-content: center;text-align: center;display: block;margin-top: 10px;"><i class="fa fa-star fa-3x" aria-hidden="true"></i><i class="fa fa-star  fa-3x" aria-hidden="true"></i><i class="fa fa-star fa-3x" aria-hidden="true" style="color: gold;"></i></span>
							</div>
						 <div class="form-group" style="padding-right: 195px;margin-top: 10%;">
									<blockquote class="blockquote-reverse">
										<p>من روانشناس 15 سال دارم.من روانشناس 15 سال دارم.من روانشناس 15 سال دارم.من روانشناس 15 سال دارم.من روانشناس 15 سال دارم.من روانشناس 15 سال دارم.من روانشناس 15 سال دارم.من روانشناس 15 سال دارم.</p>
										<footer>دکتر روان</footer>
									</blockquote>
				   		</div>

							<div class="btn-group" style="margin-right: 20px;">
                <button type="button" id="editClass" class="btn btn-primary">چت</button>
                <button type="button" class="btn btn-primary">بلاگ</button>
								<button type="button" class="btn btn-primary">درخواست نوبت</button>
								<button type="button" class="btn btn-primary">انتخاب به عنوان مشاور</button>
								<button type="button" class="btn btn-primary">نظر شما</button>
              </div>
					</div>
				</div>
			</div>
      <!-- section 2  -->
      <?php include("pages/footer.php"); ?>
