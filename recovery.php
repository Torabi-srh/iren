
<?php

  require_once("functions.php") ;

  if(isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
  	$sql = "SELECT * FROM `users` WHERE username = '$username' OR email = '$username'";
  	$res = mysqli_query($connection, $sql);
  	$count = mysqli_num_rows($res);
  	if($count == 1){
  		echo "Send email to user with password";
  	}else{
  		echo "Username does not exist in database";
  	}
  }
?>

<!DOCTYPE html PUBLIC "-//W3C/DTD HTML 5 TRANSITIONAL//EN"
  "http://www.w3.org/TR/html5/loose.dtd">

<html lang="en">
  <head>
    <title></title>
  </head>
  <body>
    
  </body>
</html>
