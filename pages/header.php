<?php
 include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/functions.php");
  // just to make sure this page has not any errors !
  $GLOBALS['a'] = 1;
  function head($var) {
    $mysqli = isset($mysqli) ? $mysqli : Connection();
      if ($var == "doc") {
        $GLOBALS['a'] = 2;
      } elseif ($var == "norm") {
        $GLOBALS['a'] = 1;
      } elseif ($var == "cal") {
        $GLOBALS['a'] = 3;
      } elseif ($var == "p2") {
        $GLOBALS['a'] = 4;
      } elseif ($var == "d2") {
        $GLOBALS['a'] = 5;
      } else {
        $GLOBALS['a'] = 0;
      }

      $info = pull_out_users_data();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IDK - IDK</title>

    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.min.css">
    <link rel="stylesheet" href="css/wizard.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/uprofile.css">
    <link rel="stylesheet" href="css/tcbot.css">
    <link href='css/fullcalendar.css' rel='stylesheet' />
    <link href='css/fullcalendar.print.css' rel='stylesheet' media='print' />
    <link href='css/persian-datepicker.min.css' rel='stylesheet'/>

    <script src="js/fullcalendar/lib/moment.min.js"></script>
    <script src='js/fullcalendar/lib/moment-jalaali.js'></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/loadingoverlay.min.js"></script>
    <script src="js/loadingoverlay_progress.min.js"></script>
    <script src="js/init.js"></script>
  </head>
  <body dir="rtl" style="background: url('assets/images/bg/bg.png') no-repeat center center fixed;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
      <nav class="navbar navbar-inverse" role="navigation">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/" style="padding: 0px;"><img src="assets/images/logo/ICON.png" style="width: 100%;height: 100%;" /></a>
            </div>
            <div class="collapse navbar-collapse pull-right" id="bs-example-navbar-collapse-2">
                <ul class="nav navbar-nav">
                    <li>
                      <a href="invoice.php">مالی<b></b></a>
                    </li>
                    <li>
                      <a href="timeline.php">بلاگ مشارو<b></b></a>
                    </li>
                    <li>
                      <a href="calander.php">تقویم مشاور<b></b></a>
                    </li>
                    <li>
                      <a href="shop.php">فروشگاه<b></b></a>
                    </li>
                    <li>
                      <a href="profile-user.php">پروفایل<b></b></a>
                    </li>
                </ul>
            </div>
            <!--/.navbar-collapse-->
      </nav>

    <div class="container">
      <!-- section 1 -->
<?php if ($GLOBALS['a'] == 1): ?>
      <div class="row">
        <div class="col-md-8">
          <div class="panel panel-default">
            <div class="panel-body"  style="min-height: 285px;padding-top: 10%;">
              <div class="col-md-5" style="left: 130px;">
                <form class="form-horizontal">
                  <div class="form-group">
                    <div class="col-sm-6" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;"><?php echo $info['age']; ?></p></div>
                    <label class="control-label col-sm-6 input-group-addon" style="min-width: 85px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-birthday-cake" aria-hidden="true"></i> سن</label>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-6" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;"><?php echo ($info['gender'] == 0 ? FEMALE : ($info['gender'] == 1 ? MALE : BLUE)) ; ?></p></div>
                    <label class="control-label col-sm-6 input-group-addon" style="min-width: 85px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-mars" aria-hidden="true"></i> جنسیت</label>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-6" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;">
                      <?php
                        $id = $info['id'] ;
                        $depose = null;
                        $sum_depose = 0.0 ;
                        $sql = "SELECT depose FROM invoice WHERE uid = ?" ;
                        if ($stmt = $mysqli->prepare($sql)):
                          $stmt->bind_param('i', $id);
                					$stmt->execute();
                					$stmt->store_result();
                					$stmt->bind_result($depose);
                          while($stmt->fetch()) {
                            $sum_depose += $depose;
                          }
                        endif;
                        echo $sum_depose . " " . "ریال" ;
                      ?>
                    </p></div>
                    <label class="control-label col-sm-6 input-group-addon" style="min-width: 85px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-money" aria-hidden="true"></i> موجودی</label>
                  </div>
                </form>
              </div>
              <div class="col-md-7">
                <form class="form-horizontal pull-right" style="min-width:80%;">

                  <div class="form-group">
                    <div class="col-sm-7" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;"><?php echo $info['fname']; ?></p></div>
                    <label class="control-label col-sm-4 input-group-addon" style="min-width: 115px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-user-o" aria-hidden="true"></i> نام</label>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-7" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;"><?php echo $info['name']; ?></p></div>
                    <label class="control-label col-sm-4 input-group-addon" style="min-width: 115px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-user-o" aria-hidden="true"></i> نام‌خانوادگی</label>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-7" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;"><?php echo $info['email']; ?></p></div>
                    <label class="control-label col-sm-4 input-group-addon" style="min-width: 115px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-envelope-o" aria-hidden="true"></i> پست‌الکترونیک</label>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="thumbnail">
                <img src=<?php echo  $info['picture'] ; ?> class="img-circle" alt="Cinque Terre" width="150" height="150">
                <div class="caption" style="text-align: center;">
                  <p>
                    <?php
                      echo $_SESSION['username'] ;
                    ?>
                  </p>
                  <form action="profile-user.php" method="post">
                    <div class="btn-group">
                      <button type="button" id="editClass" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ویرایش</button>
                      <button type="submit" class="btn btn-danger" name="exit_btn"><i class="fa fa-sign-out" aria-hidden="true"></i> خروج</button>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- section 1  -->

<?php elseif ($GLOBALS['a'] == 4): ?>
  <?php
  if(!empty($_GET['uname'])) {
    $uname = $_GET['uname'];
  } else {
    redirect("profile-doctor.php") ;
  }
  $info = pull_out_users_data($uname);
  if ($info['isdr'] == 1) {
    redirect("doctor.php?uname=$uname") ;
  }
   ?>
      <div class="row">
        <div class="col-md-8">
          <div class="panel panel-default">
            <div class="panel-body"  style="min-height: 285px;padding-top: 10%;">
              <div class="col-md-5" style="left: 130px;">
                <form class="form-horizontal">
                  <div class="form-group">
                    <div class="col-sm-6" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;"><?php echo DateToAge($info['bday']); ?></p></div>
                    <label class="control-label col-sm-6 input-group-addon" style="min-width: 85px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-birthday-cake" aria-hidden="true"></i> سن</label>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-6" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;"><?php echo ($info['gender'] == 0 ? FEMALE : ($info['gender'] == 1 ? MALE : BLUE)) ; ?></p></div>
                    <label class="control-label col-sm-6 input-group-addon" style="min-width: 85px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-mars" aria-hidden="true"></i> جنسیت</label>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-6" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;"><?php echo "{$info['drphone']}"; ?></p></div>
                    <label class="control-label col-sm-6 input-group-addon" style="min-width: 85px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-phone" aria-hidden="true"></i> تلفن</label>
                  </div>
                </form>
              </div>
              <div class="col-md-7">
                <form class="form-horizontal pull-right" style="min-width:80%;">
                  <div class="form-group">
                    <div class="col-sm-7" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;"><?php echo "{$info['name']}"; ?></p></div>
                    <label class="control-label col-sm-4 input-group-addon" style="min-width: 115px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-user-o" aria-hidden="true"></i> نام</label>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-7" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;"><?php echo "{$info['fname']}"; ?></p></div>
                    <label class="control-label col-sm-4 input-group-addon" style="min-width: 115px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-user-o" aria-hidden="true"></i> نام‌خانوادگی</label>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-7" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;"><?php echo "{$info['email']}"; ?></p></div>
                    <label class="control-label col-sm-4 input-group-addon" style="min-width: 115px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-envelope-o" aria-hidden="true"></i> پست‌الکترونیک</label>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="thumbnail">
                <img src="<?php echo "{$info['picture']}"; ?>" class="img-circle" alt="<?php echo "{$info['username']}"; ?>" width="150" height="150">
                <div class="caption" style="text-align: center;">
                  <p>یوزر</p>
                  <div class="btn-group">
                    <button type="button" id="editClass" class="btn btn-primary" disabled><i class="fa fa-file-text-o" aria-hidden="true"></i> پرونده</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- section 1  -->


<?php elseif ($GLOBALS['a'] == 5): ?>
  <?php
  if(!empty($_GET['uname'])) {
    $uname = $_GET['uname'];
  } else {
    redirect("profile-user.php") ;
  }
  $info = pull_out_users_data($uname);
  if ($info['isdr'] == 0) {
    redirect("user.php?uname=$uname") ;
  }
   ?>
      <div class="row">
        <div class="col-md-8">
          <div class="panel panel-default">
            <div class="panel-body"  style="min-height: 285px;padding-top: 10%;">
              <div class="col-md-5" style="left: 130px;">
                <form class="form-horizontal">
                  <div class="form-group">
                    <div class="col-sm-6" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;"><?php echo DateToAge($info['bday']); ?></p></div>
                    <label class="control-label col-sm-6 input-group-addon" style="min-width: 85px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-birthday-cake" aria-hidden="true"></i> سن</label>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-6" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;"><?php echo ($info['gender'] == 0 ? FEMALE : ($info['gender'] == 1 ? MALE : BLUE)) ; ?></p></div>
                    <label class="control-label col-sm-6 input-group-addon" style="min-width: 85px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-mars" aria-hidden="true"></i> جنسیت</label>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-6" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;"><?php echo "{$info['drphone']}"; ?></p></div>
                    <label class="control-label col-sm-6 input-group-addon" style="min-width: 85px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-phone" aria-hidden="true"></i> تلفن</label>
                  </div>
                </form>
              </div>
              <div class="col-md-7">
                <form class="form-horizontal pull-right" style="min-width:80%;">
                  <div class="form-group">
                    <div class="col-sm-7" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;"><?php echo "{$info['name']}"; ?></p></div>
                    <label class="control-label col-sm-4 input-group-addon" style="min-width: 115px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-user-o" aria-hidden="true"></i> نام</label>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-7" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;"><?php echo "{$info['fname']}"; ?></p></div>
                    <label class="control-label col-sm-4 input-group-addon" style="min-width: 115px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-user-o" aria-hidden="true"></i> نام‌خانوادگی</label>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-7" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;"><?php echo "{$info['email']}"; ?></p></div>
                    <label class="control-label col-sm-4 input-group-addon" style="min-width: 115px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-envelope-o" aria-hidden="true"></i> پست‌الکترونیک</label>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="thumbnail">
                <img src="<?php echo "{$info['picture']}"; ?>" class="img-circle" alt="<?php echo "{$info['username']}"; ?>" width="150" height="150">
                <div class="caption" style="text-align: center;">
                  <p>یوزر</p>
                  <div class="btn-group">
                    <button type="button" id="editClass" class="btn btn-primary" disabled><i class="fa fa-file-text-o" aria-hidden="true"></i> درخواست‌نوبت</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- section 1  -->
<?php elseif ($GLOBALS['a'] == 2): ?>
      <div class="row">
        <div class="col-md-8">
          <div class="panel panel-default">
            <div class="panel-body"  style="min-height: 285px;padding-top: 10%;">
              <div class="col-md-5" style="left: 130px;">
                <form class="form-horizontal">
                  <div class="form-group">
                    <div class="col-sm-6" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;"><?php echo $info['age']; ?></p></div>
                    <label class="control-label col-sm-6 input-group-addon" style="min-width: 85px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-birthday-cake" aria-hidden="true"></i> سن</label>
                  </div>
                  <?php
                      echo "<div class=\"form-group\">
                        <div class=\"col-sm-6\" style=\"margin: 0px;padding: 0px;\"><p class=\"form-control\" style=\"border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;\">" ;
                        echo trim($info['phone']) ;
                        echo"</p></div>
                        <label class=\"control-label col-sm-6 input-group-addon\" style=\"min-width: 85px;border-radius: 0px 5px 5px 0px;\"><i class=\"fa fa-mars\" aria-hidden=\"true\"></i> شماره تلفن</label>
                      </div>" ;
                  ?>

                  <div class="form-group">
                    <div class="col-sm-6" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;">
                      <?php
                        $id = $info['id'] ;
                        $depose = null;
                        $sum_depose = 0.0 ;
                        $sql = "SELECT depose FROM invoice WHERE uid = ?" ;
                        if ($stmt = $mysqli->prepare($sql)):
                          $stmt->bind_param('i', $id);
                					$stmt->execute();
                					$stmt->store_result();
                					$stmt->bind_result($depose);
                          while($stmt->fetch()) {
                            $sum_depose += $depose;
                          }
                        endif;
                        echo $sum_depose . " " . "ریال" ;
                      ?>
                    </p></div>
                    <label class="control-label col-sm-6 input-group-addon" style="min-width: 85px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-money" aria-hidden="true"></i> موجودی</label>
                  </div>
                </form>
              </div>
              <div class="col-md-7">
                <form class="form-horizontal pull-right" style="min-width:80%;">
                  <div class="form-group">
                    <div class="col-sm-7" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;"><?php echo $info['fname']; ?></p></div>
                    <label class="control-label col-sm-4 input-group-addon" style="min-width: 115px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-user-o" aria-hidden="true"></i> نام</label>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-7" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;"><?php echo $info['name']; ?></p></div>
                    <label class="control-label col-sm-4 input-group-addon" style="min-width: 115px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-user-o" aria-hidden="true"></i> نام‌خانوادگی</label>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-7" style="margin: 0px;padding: 0px;"><p class="form-control" style="border-radius: 5px 0px 0px 5px;margin: 0px;min-height: 32px;"><?php echo $info['email']; ?></p></div>
                    <label class="control-label col-sm-4 input-group-addon" style="min-width: 115px;border-radius: 0px 5px 5px 0px;"><i class="fa fa-envelope-o" aria-hidden="true"></i> پست‌الکترونیک</label>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="thumbnail">
                <img src=<?php echo  $info['picture'] ; ?> class="img-circle" alt="Cinque Terre" width="150" height="150">
                <div class="caption" style="text-align: center;">
                  <h5><?php echo DR . $info['fname'] . " " .  $info['name'];  ?></h5>
                  <form action="profile-doctor.php" method="post">
                    <div class="btn-group">
                      <button type="button" id="editClass" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ویرایش</button>
                      <button type="submit" class="btn btn-danger" name="exit_btn"><i class="fa fa-sign-out" aria-hidden="true"></i> خروج</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- section 1  -->
<?php endif;} ?>
