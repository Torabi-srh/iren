<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/functions.php");
  $log_check = login_check() ;
  if($log_check[0] === true) {
    if($log_check[1] === 1) {
      redirect(urlencode("profile-doctor.php")) ;
    } elseif($log_check[1] === 0){
      redirect(urlencode("profile-user.php")) ;
    }
  } elseif(isset($_POST['submit'])) {
    $username = $_POST['email'] ;
    $password = $_POST['password'] ;
    $t = !empty($_POST['remember']) ;
		$login_ret = Login($username, $password, $t);
    if($login_ret[0] === true && $login_ret[1] === 1 && is_user_activities_set()) {
      // dr dashbord !
      $alrt = 1;
      user_activitys() ;
      redirect(urlencode("profile-doctor.php")) ;
    } elseif($login_ret[0] === true && $login_ret[1] === 0 && is_user_activities_set()) {
      // patient dashbord !
      $alrt = 1 ;
      user_activitys() ;
      redirect(urlencode("profile-user.php")) ;
    }
    else {
      // there was some errros !
      $alrt = 0 ;
    }
  }else {
    // actually there was no submit pressed !
    $alrt = 2 ;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login | Telepathy</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <style type="text/css">
	.t-top {
            border-top: 20px solid rgba(92,87,100,0.5);
		border-right: 175px solid transparent;
            width: 100%;
		border-left: 1px solid black;
      }
	.t-color {
		background-color: rgba(92,87,100,0.5);
	}
	.t-mid {
            height: 93%;
            width: 100%;

		border-width: thin;
		border-top: 0px;
		border-bottom: 0px;
		border-style: solid;
		border-color: black;
      }
	.t-bot {
		border-left: 1px solid black;
            border-bottom: 20px solid rgba(92,87,100,0.5);
            border-right: 175px solid transparent;
            width: 100%;
      }
	.t-left {
		border-top-left-radius: 10px;
		border-bottom-left-radius: 10px;
	}
	.t-right {
		border-top-right-radius: 10px;
		border-bottom-right-radius: 10px;
	}
	.form-control::-webkit-input-placeholder { /* Chrome/Opera/Safari */
		color: #787878;
	}
	.form-control::-moz-placeholder { /* Firefox 19+ */
		color: #787878;
	}
	.form-control:-ms-input-placeholder { /* IE 10+ */
		color: #787878;
	}
	.form-control:-moz-placeholder { /* Firefox 18- */
		color: #787878;
	}
    </style>
</head>

<body dir="rtl" style="background: url('assets/images/bg/background.png'); background-size: 100% 100%;background-repeat: no-repeat;">
  <div id="could_pass">
    <?php
      if ($alrt == 0) {
        echo "<div class=\"alert alert-danger\" id=23>
      <strong>{$login_ret}</strong>
    </div><br />";
      }elseif ($alrt == 1) {
        echo "<div class=\"alert alert-success\" id=24>
      <strong>Success!</strong>
    </div><br />" ;
      }
    ?>
  </div>

    <div class="container" style="margin-top: 35px;">
        <div class="col-lg-5 col-md-5 hidden-sm hidden-xs col-xs-5 bg t-color t-left" style="height: 89.9vh;background-position: center;background-image: url(assets/images/bg/phone.png); background-size: 70%; background-repeat: no-repeat;"></div>

        <div class="col-lg-2 col-md-2  hidden-sm hidden-xs col-sm-2 col-xs-2 bg" style="height: 90vh;padding: 0;">
		<div class="t-bot"></div>
		<div class="t-mid t-color"></div>
		<div class="t-top"></div>
	  </div>

        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 t-color t-right" style="height: 83.7vh;margin-top: 20px;">
            <form accept-charset="UTF-8" id="loginfrm" action="login.php" method="post" role="form" style="">
            	<div class="col-md-10 col-md-offset-1" style="margin-top: 30px;">
                <img src="assets/images/logo/iren-logo.png" style="align-content: center;margin-right: 33.3333333%;margin-bottom: 30px;" width="125px" height="125px">
            		<div class="panel panel-default" style="border-radius: 0px;background-color: #1d1d1d;border-top: 0px;height: 220px;margin-bottom: 0px;border-top-left-radius: 2%;border-top-right-radius: 2%;">
        			  	<div class="panel-body">

                            <fieldset style="margin-top: 10%;">
        			    	  	<div class="form-group">
        			    		    <input class="form-control" placeholder="پست الکترونیکی" name="email" style="text-align: center;height: 40px;background-color: rgba(255, 255, 255, 0.5);color: white;width: 90%;margin-right: 5%;font-size: 16px;" type="text">
        			    		</div>
        			    		<div class="form-group">
        			    			<input class="form-control" placeholder="گذرواژه" name="password" value="" style="text-align: center;background-color: rgba(255, 255, 255, 0.5);color: white;height: 40px;width: 90%;margin-right: 5%;font-size: 16px;" type="password">
        			    		</div>
                      <div style="display: flex;margin-top: -5px;" class="">
          			    		<div style="margin-top: 5px;margin-bottom: 5px;float: left;width: 100%;margin-right: 26px;" class="">
          			    	    	<label style="font-weight: normal;cursor: pointer;">
          			    	    		<input name="remember" value="remember" style="padding-left: 20px;margin-bottom: 0;" type="checkbox"> به یاد داشتن
          			    	    	</label>
          			    	    </div>
                        <div style="margin-top: 5px;margin-bottom: 5px;float: right;width: 576px;"><a class="control is-pulled-left" href="register.php">ثبت نام</a>
                        <span> | </span>
                        <a class="control is-pulled-left" href="register.php">بازیابی کلمه‌عبور</a></div>

            			    </div>

          			    	</fieldset>

        			    </div>
        			</div>
				<input value="ورود" style="width: 100%;border-radius: 0px;height: 40px;font-size: 16px;" class="btn btn-primary btn-block" type="submit" name="submit">
              <input style="width: 100%;margin: 0px;border-top-right-radius: 0px;border-top-left-radius: 0px;direction: ltr;height: 40px;font-size: 16px;" class="btn btn-danger btn-block" value="Google +" type="submit">
        		</div>
        		      	</form>
        </div>
    </div>
	<script src="js/jquery.min.js" type="text/javascript">
	</script><script src="js/jquery-ui.js" type="text/javascript">
	</script><script src="js/bootstrap.min.js" type="text/javascript">
	</script><script src="js/jquery.validate.min.js" type="text/javascript">
	</script>
  <script>
  setInterval(function(){
    $('#could_pass').innerHtml="" ; //intory dakhele ye tag html ro pak mikone
  },4000);
  String.format = function() {
    var s = arguments[0];
    for (var i = 0; i < arguments.length - 1; i += 1) {
        var reg = new RegExp('\\{' + i + '\\}', 'gm');
        s = s.replace(reg, arguments[i + 1]);
    }
    return s;
};
  $(document).ready(function() {
  /* Doctor */
  $('#loginfrm').validate({
      rules: {
          email: {
            required: true
          },
          password: {
              required: true,
              minlength: 7
          }
      },
      messages: {
          email: "لطفا پست‌الکترونیکی خود را وارد کنید",
          password: {
              required: "رمز عبور خود را وارد کنید",
              minlength: String.format("رمز عبور باید بیشتر از {0} رقم باشد")
          }
      }
  });
  $("#drubm").click(function() {
      $.ajax({
          type: "POST",
          url: 'login.php',
          data: {
              email: $("input[name=demail]").val(),
              username: $("input[name=dusername]").val(),
              password: $("input[name=dpassword]").val(),
              cpassword: $("input[name=dcpassword]").val(),
              snr: $("input[name=dsnr]").val(),
              qavanin: $("input[name=dqavanin]").val()
          },
          success: function(result) {
              $("#er").html(result);
          },
          error: function (request, status, error) {
              alert(request.responseText);
              alert(error);
              alert(status);
          }
      });
  });});
  </script>
</body>
</html>
