<?php

  if(isset($_POST['submit'])) {
    $email = $_POST['email'] ;
    echo $email . "<br />";
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "valid email" ;
    }else {
      echo "not valid email" ; 
    }
  }else {
  }
?>

<!DOCTYPE html PUBLIC "-//W3C/DTD HTML 5 TRANSITIONAL//EN"
  "http://www.w3.org/TR/html5/loose.dtd">

<html lang="en">
  <head>
    <title>Recovery</title>
  </head>
  <body>
    <form class="form-signin" action="" method="POST">
          <h2 class="form-signin-heading">Forgot Password</h2>
          <div class="input-group">
  	  <span class="input-group-addon" id="basic-addon1"></span>
  	  <input type="text" name="username" class="form-control" placeholder="Email or username..." required>
  	</div>
  	<br />
          <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Forgot Password</button>
          <a class="btn btn-lg btn-primary btn-block" href="login.php">Login</a>
    </form>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >

    <link rel="stylesheet" href="style.css" >

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>
