<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/assets/functions.php');

if (isset($_POST['check'])) {
  if (isset($_POST['username'])) { 
    echo (json_encode(true));
    die();
  } else {
    echo (json_encode(false));
    die();
  }
}  
$mysqli = isset($mysqli) ? $mysqli : Connection();
   
$e = false;
$u = false;
$p = false;
$cp = false;
$q = false;
$s = false;
$snr = '0';

if (isset($_POST["dfm"])) {
  if (isset($_POST["snr"])) {
    $snr = $_POST['snr'];
    if (!filter_var($snr, FILTER_VALIDATE_INT)) {
      echo false;
    } else {
      echo true;
    }
    $s = true;
  }
  if (isset($_POST["email"])) {
    $email = $_POST['email'];
  
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo false;
    }
    if ($stmt = $mysqli->prepare("SELECT id
                           FROM users
                           WHERE email = ?")) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $e = false;
        } else {
            $e = true;
        }
    } else {
      echo (json_encode(true));
      echo json_encode('
            <p class="notification is-danger">
              <button id="delete" class="delete"></button>
                500.11 لطفا با ادمین سایت تماس بگیرید !
            </p>
           ');
      die();
    }
  }
  if (isset($_POST["username"])) {
    $username = $_POST['username'];
  
    if ($stmt = $mysqli->prepare("SELECT id
                           FROM users
                           WHERE username = ?")) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $u = false;
        } else {
            $u = true;
        }
    } else {
      echo json_encode('
            <p class="notification is-danger">
              <button id="delete" class="delete"></button>
                500.12 لطفا با ادمین سایت تماس بگیرید !
            </p>
           ');
      die();
    }
  }
  if (isset($_POST["password"])) {
    $passwd = $_POST['password'];
    try {
      $p = true;
    } catch (Exception $e) {
      $p = false;
      echo '
            <p class="notification is-danger">
              <button id="delete" class="delete"></button>
                500.13 لطفا با ادمین سایت تماس بگیرید !
            </p>
           '; 
      return;
    }
  }
  if (isset($_POST["cpassword"])) {
    $cpasswd = $_POST['cpassword'];
    try {
      $cp = true;
    } catch (Exception $e) {
      $cp = false;
      echo '
            <p class="notification is-danger">
              <button id="delete" class="delete"></button>
                500.123 لطفا با ادمین سایت تماس بگیرید !
            </p>
           '; 
      return;
    }
  }
  if ($cpasswd !== $passwd) { 
    echo '
          <p class="notification is-danger">
            <button id="delete" class="delete"></button>
              500.133 لطفا با ادمین سایت تdasdaماس بگیرید !
          </p>
         '; 
    return; 
  }
  if (isset($_POST["qavanin"])) {
    $qavanin = $_POST['qavanin'];
    try {
      $q = true;
    } catch (Exception $e) {
      $q = false;
      echo '
            <p class="notification is-danger">
              <button id="delete" class="delete"></button>
                500.143 لطفا با ادمین سایت تماس بگیرید !
            </p>
           '; 
      return;
    }
  }

  $isdr = 1;
} elseif (isset($_POST["fm"])) { 
  if (isset($_POST["email"])) {
    $email = $_POST['email']; 
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo false;
    }
    if ($stmt = $mysqli->prepare("SELECT id
                           FROM users
                           WHERE email = ?")) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $e = false;
        } else {
            $e = true;
        }
    } else {
      echo '
            <p class="notification is-danger">
              <button id="delete" class="delete"></button>
                500.11 لطفا با ادمین سایت تماس بگیرید !
            </p>
           '; 
    }
  }
  if (isset($_POST["username"])) {
    $username = $_POST['username'];
  
    if ($stmt = $mysqli->prepare("SELECT id
                           FROM users
                           WHERE username = ?")) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $u = false;
        } else {
            $u = true;
        }
    } else {
      echo '
            <p class="notification is-danger">
              <button id="delete" class="delete"></button>
                500.12 لطفا با ادمین سایت تماس بگیرید !
            </p>
           '; 
    }
  }
  if (isset($_POST["password"])) {
    $passwd = $_POST['password'];
    try {
      $p = true;
    } catch (Exception $e) {
      $p = false;
      echo '
            <p class="notification is-danger">
              <button id="delete" class="delete"></button>
                500.153 لطفا با ادمین سایت تماس بگیرید !
            </p>
           '; 
      return;
    }
  }
  if (isset($_POST["cpassword"])) {
    $cpasswd = $_POST['cpassword'];
    try {
      $cp = true;
    } catch (Exception $e) {
      $cp = false;
      echo '
            <p class="notification is-danger">
              <button id="delete" class="delete"></button>
                500.163 لطفا با ادمین سایت تماس بگیرید !
            </p>
           '; 
      return;
    }
  }
  if (isset($_POST["qavanin"])) {
    $qavanin = $_POST['qavanin'];
    try {
      $q = true;
    } catch (Exception $e) {
      $q = false;
      echo '
            <p class="notification is-danger">
              <button id="delete" class="delete"></button>
                500.173 لطفا با ادمین سایت تماس بگیرید !
            </p>
           '; 
      return;
    }
  }
  $isdr = 0;
} else {
  
}

if (!empty($passwd) && !empty($username) && !empty($email)) {
  $reg = register($username, $passwd, $email, $isdr, $snr);

  if ($reg) {
    echo '
          <p class="notification is-success">
            <button id="delete" class="delete"></button>
              ثبت نام انجام شد. لطفا ایمیل خود را بررسی کنید.
          </p>
         '; 
    return;
  } else {
    echo '
          <p class="notification is-danger">
            <button id="delete" class="delete"></button>
              500.113 لطفا با ادمین سایت تماس بگیرید !
          </p>
         ';
    return;
  }
}  
 ?>
