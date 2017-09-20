<?php include("pages/header.php");head("doc"); ?>
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
          <div class="panel-body">
						<div class="row" style="margin-top: 25px;margin-bottom: 25px;">
								<div class="pull-left" style="display: flex;width: 100%;">
									<input class="form-control" placeholder="پست‌الکترونیکی / شماره تلفن" required="" style="width: 100%;margin-left: 10px;" type="text">
									<button type="button" class="btn btn-success" style="margin-left: 36px;">
											<i class="fa fa-heart" aria-hidden="true"></i>
											دعوت به سایت
									</button>
								</div>
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
								<tbody>
										<tr>
												<td class="col-md-1">
														<h4>1</h4>
												</td>
												<td class="col-md-2"><h5><strong>5/5/1371</strong></h5></td>
												<td class="col-md-1">
														<a href="profile-user.php">
														علی علی‌نژاد
														</a>
												</td> 
												<td class="col-md-3">
														<input type="text" class="form-control" placeholder="">
												</td> 
												<td class="col-sm-4 col-md-4" style="display: contents;">
													<div class="btn-group" style="margin-top: 5px;">
														<button type="button" class="btn btn-warning">
																<i class="fa fa-user-md" aria-hidden="true"></i>
																دعوت‌به‌مطب
														</button>
														<button type="button" class="btn btn-success">
																<i class="fa fa-times" aria-hidden="true"></i>
																ثبت
														</button>
														<button type="button" class="btn btn-danger">
																<i class="fa fa-times" aria-hidden="true"></i>
																حذف
														</button>
													</div>
												</td>
										</tr>
										<tr>
												<td class="col-md-1">
														<h4>2</h4>
												</td>
												<td class="col-md-2"><h5><strong>5/5/1371</strong></h5></td>
												<td class="col-md-1">
														<a href="profile-user.php">
														علی علی‌نژاد
														</a>
												</td> 
												<td class="col-md-3">
														<input type="text" class="form-control" placeholder="">
												</td> 
												<td class="col-sm-4 col-md-4" style="display: contents;">
													<div class="btn-group" style="margin-top: 5px;">
														<button type="button" class="btn btn-warning">
																<i class="fa fa-user-md" aria-hidden="true"></i>
																دعوت‌به‌مطب
														</button>
														<button type="button" class="btn btn-success">
																<i class="fa fa-times" aria-hidden="true"></i>
																ثبت
														</button>
														<button type="button" class="btn btn-danger">
																<i class="fa fa-times" aria-hidden="true"></i>
																حذف
														</button>
													</div>
												</td>
										</tr>
										<tr>
												<td class="col-md-1">
														<h4>1</h4>
												</td>
												<td class="col-md-2"><h5><strong>5/5/1371</strong></h5></td>
												<td class="col-md-1"> 
														<a href="profile-user.php">
														علی علی‌نژاد
														</a> 
												</td> 
												<td class="col-md-3">
														<input type="text" class="form-control" placeholder="">
												</td> 
												<td class="col-sm-4 col-md-4" style="display: contents;">
													<div class="btn-group" style="margin-top: 5px;">
														<button type="button" class="btn btn-warning">
																<i class="fa fa-user-md" aria-hidden="true"></i>
																دعوت‌به‌مطب
														</button>
														<button type="button" class="btn btn-success">
																<i class="fa fa-times" aria-hidden="true"></i>
																ثبت
														</button>
														<button type="button" class="btn btn-danger">
																<i class="fa fa-times" aria-hidden="true"></i>
																حذف
														</button>
													</div>
												</td>
										</tr>
										<tr>
												<td class="col-md-1">
														<h4>1</h4>
												</td>
												<td class="col-md-2"><h5><strong>5/5/1371</strong></h5></td>
												<td class="col-md-1">
														<a href="profile-user.php">
														علی علی‌نژاد
														</a>
												</td> 
												<td class="col-md-3">
														<input type="text" class="form-control" placeholder="">
												</td> 
												<td class="col-sm-4 col-md-4" style="display: contents;">
													<div class="btn-group" style="margin-top: 5px;">
														<button type="button" class="btn btn-warning">
																<i class="fa fa-user-md" aria-hidden="true"></i>
																دعوت‌به‌مطب
														</button>
														<button type="button" class="btn btn-success">
																<i class="fa fa-times" aria-hidden="true"></i>
																ثبت
														</button>
														<button type="button" class="btn btn-danger">
																<i class="fa fa-times" aria-hidden="true"></i>
																حذف
														</button>
													</div>
												</td>
										</tr>
										<tr>
												<td class="col-md-1">
														<h4>1</h4>
												</td>
												<td class="col-md-2"><h5><strong>5/5/1371</strong></h5></td>
												<td class="col-md-1">
														<a href="profile-user.php">
														علی علی‌نژاد
														</a>
												</td> 
												<td class="col-md-3">
														<input type="text" class="form-control" placeholder="">
												</td> 
												<td class="col-sm-4 col-md-4" style="display: contents;">
													<div class="btn-group" style="margin-top: 5px;">
														<button type="button" class="btn btn-warning">
																<i class="fa fa-user-md" aria-hidden="true"></i>
																دعوت‌به‌مطب
														</button>
														<button type="button" class="btn btn-success">
																<i class="fa fa-times" aria-hidden="true"></i>
																ثبت
														</button>
														<button type="button" class="btn btn-danger">
																<i class="fa fa-times" aria-hidden="true"></i>
																حذف
														</button>
													</div>
												</td>
										</tr> 
								</tbody>
						</table>
						<ul class="pagination">
							<li class="active"><a href="#">1</a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
						</ul>
						</div>
          </div>
          </div>
        </div>
      </div>
      <!-- section 3 -->
      <!-- section 2  -->
      
      <!-- section 2  -->
      <?php include("pages/footer.php"); ?>
