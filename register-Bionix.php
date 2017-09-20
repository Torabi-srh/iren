<?php

include ("/assets/functions.php");
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

  </head>
  <body dir="rtl">
    <div class="container">
      <div class="row vertical-offset-100">
            <div class="row" id="er"> 
              <?php echo $err; ?>
            </div>
            <div class="col-xs-6 form-group">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">ثبت نام دکتر</h3>
              </div>
                <div class="panel-body">
                  <form accept-charset="UTF-8" name="dfm" id="dfm" role="form">
                          <fieldset>
                      <div class="form-group">
                        <input class="form-control" placeholder="پست الکترونیکی" name="demail" id="demail" type="text">
                    </div>
                <div class="form-group">
                  <input class="form-control" placeholder="نام کاربری" name="dusername" id="dusername" type="text">
              </div>
                    <div class="form-group">
                      <input class="form-control" placeholder="گذرواژه" name="dpassword" id="dpassword" type="password" value="">
                    </div>
                          <div class="form-group">
                            <input class="form-control" placeholder="تکرار گذرواژه" name="dcpassword" id="dcpassword" type="password" value="">
                          </div>
                      <div class="form-group">
                        <input class="form-control" placeholder="شماره نظام روانشناسی" maxlength="5" name="dsnr" id="dsnr" type="text">
                    </div>
                    <div class="checkbox">
                        <label>
                          <input name="dqavanin" id="dqavanin" type="checkbox" style="margin: 19px;" value="agreement"> <a href=""> قوانین </a>
                        </label>
                      </div>
                    <input class="btn btn-lg btn-success btn-block" id="drubm" name="drubm" type="submit" value="ثبت نام دکتر">
                  </fieldset>
                  </form>
                </div>
            </div>
          </div>
              <div class="col-xs-6 form-group">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">ثبت نام کاربر</h3>
                </div>
                  <div class="panel-body">
                    <form accept-charset="UTF-8" action="register.php" name="fm" id="fm" method="post" role="form">
                            <fieldset>
                        <div class="form-group">
                          <input class="form-control" placeholder="پست الکترونیکی" name="email" id="email" type="text">
                      </div>
                  <div class="form-group">
                    <input class="form-control" placeholder="نام کاربری" name="username" id="username" type="text">
                </div>
                      <div class="form-group">
                        <input class="form-control" placeholder="گذرواژه" name="password" id="password" type="password" value="">
                      </div>
                            <div class="form-group">
                              <input class="form-control" placeholder="تکرار گذرواژه" name="cpassword" id="cpassword" type="password" value="">
                            </div>
                      <div class="checkbox">
                            <input name="qavanin" id="qavanin" type="checkbox" style="margin: 19px;" value="agreement"><a href=""> قوانین </a></input>
                        </div>
                      <input class="btn btn-lg btn-success btn-block" name="usubm" id="usubm" type="submit" value="ثبت نام کاربر">
                    </fieldset>
                    </form>
                  </div>
              </div>
            </div>
      </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/register.js" type="text/javascript"></script>
  </body>
</html>