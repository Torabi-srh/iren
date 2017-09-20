<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>IDK - IDK</title>
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
    <div class="container" style="margin-top: 35px;">
        <div class="col-lg-5 col-md-5 hidden-sm hidden-xs col-xs-5 bg t-color t-left" style="height: 89.9vh;background-position: center;background-image: url(assets/images/bg/phone.png); background-size: 70%; background-repeat: no-repeat;"></div>

        <div class="col-lg-2 col-md-2  hidden-sm hidden-xs col-sm-2 col-xs-2 bg" style="height: 90vh;padding: 0;">
		<div class="t-bot"></div>
		<div class="t-mid t-color"></div>
		<div class="t-top"></div>
	  </div>
		
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 t-color t-right" style="height: 83.7vh;margin-top: 20px;">
            <form accept-charset="UTF-8" action="profile-user.php" method="post" role="form" style="">
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
				<input value="ورود" style="width: 100%;border-radius: 0px;height: 40px;font-size: 16px;" class="btn btn-primary btn-block" type="submit">
              <input style="width: 100%;margin: 0px;border-top-right-radius: 0px;border-top-left-radius: 0px;direction: ltr;height: 40px;font-size: 16px;" class="btn btn-danger btn-block" value="Google +" type="submit">
        		</div>
        		      	</form>
        </div>
    </div>
	<script src="js/jquery.min.js" type="text/javascript">
	</script><script src="js/jquery-ui.js" type="text/javascript">
	</script><script src="js/bootstrap.min.js" type="text/javascript">
	</script>
</body>
</html>
