<?php
  include_once 'functions.php';
  $mysqli = isset($mysqli) ? $mysqli : Connection();

  if (login_check() == true) {
    header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
    include('pages-error-404-2.html');
    exit();
    die();
  }
  if (isset($_GET['confirm'])) {
    $confirm = $mysqli->real_escape_string($_GET['confirm']);
    $email = $mysqli->real_escape_string($_GET['email']);
    $username = $mysqli->real_escape_string($_GET['username']);
    if ($stmt = $mysqli->prepare("SELECT verify_send,verify_send_hash,verify
                                  FROM users WHERE username = ? or email = ?
                                  LIMIT 1")) {
        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($verify_send,$verify_send_hash,$verify);
        $stmt->fetch();
        if ($verify == 1) {
          echo "Account is activated.";
          die();
        }
        if (strtotime(date('Y-m-d H:i:s')) < strtotime($verify_send) + 7200) {
          if ($verify_send_hash == $confirm) {
            if ($stmt = $mysqli->prepare("UPDATE users
                                          SET verify=1
                                          WHERE username = ? or email = ?")) {
                $stmt->bind_param('ss', $username, $email);
                $stmt->execute();

                $FormError = Login2($email);
                if ($FormError === true) {
                  echo 'Account is now activated click here to <a href="login.php">login</a>';
                } else {
                  echo 'Error Access denied';
                }
              }
            }
            else {
              echo "Code is wrong.";
            }
          }
            else {
              echo "expired.";

          }
        }
      }
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body class="bg" dir="rtl">
</body>
</html>
