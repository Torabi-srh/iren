<?php
include_once 'statics.php';
isdebug();
/* create database */
if (!islocal()) {
    ob_start();
    if (!file_exists("DB_CREAT")) {
        if (dbc()) {
            $myfile = fopen("DB_CREAT", "w") or die("Unable to open file!");
            fclose($myfile);
        }
    }
}
function dbc() {
    $sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?";
    $mysqli = isset($mysqli) ? $mysqli : Connection();
    if ($stmt = $mysqli->prepare($sql)) {
        $var1 = DB_NAME;
        $stmt->bind_param('s', $var1);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $mysqli->close();
            return true;
        } else {
            $filename = 'db/main.sql';
            if (!file_exists($filename)) {
                $mysqli->close();
                return false;
            }
            $querys = explode("\n", file_get_contents($filename));
            foreach ($querys as $q) {
              $q = trim($q);
              if (strlen($q)) {
                if ($stmt = $mysqli->prepare($q)) {
                    $stmt->execute();
                }
              }
            }
            $mysqli->close();
            return true;
        }
    }
}
if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
    http_response_code(400);
    //include('errors/400.htm');
    die();
}
// include_once 'assets/handler.php';
///////////////////////////////Security Function's//////////////////////////////
function is_session_started() {
    if (php_sapi_name() !== 'cli') {
        if (version_compare(phpversion(), '5.4.0', '>=')) {
            return session_status() === PHP_SESSION_ACTIVE ? true : false;
        } else {
            return session_id() === '' ? false : true;
        }
    }
    return false;
}
function sessionStart($name, $limit = 7200, $path = '/', $domain = DOMAIN, $secure = null) {
    if (isset($_SESSION['user_id'])) {
        if ($_SESSION['user_id'] == 0 || $_SESSION['user_id'] == "0" || empty($_SESSION['user_id'])) {
            lagout();
        }
    }
    session_name('telepath_' . SaltMD5($name));
    $https = isset($secure) ? $secure : isset($_SERVER['HTTPS']);
    session_set_cookie_params($limit, $path, $domain, $https, true);
    session_start();
    if (validateSession()) {
        if (!preventHijacking()) {
            $_SESSION = array();
            $_SESSION['IPaddress'] = SaltMD5($_SERVER['REMOTE_ADDR']);
            $_SESSION['userAgent'] = SaltMD5($_SERVER['HTTP_USER_AGENT']);
            $_SESSION['now'][0] = date('Y.m.d H:i:s');
            $_SESSION['now'][1] = date('Y.m.d');
            $_SESSION['now'][2] = date('H:i:s');

            regenerateSession();
        } elseif (rand(1, 100) <= 5) {
            regenerateSession();
        }
    } else {
        $_SESSION = array();
        session_destroy();
        session_start();
    }
}
function validateSession() {
    if (isset($_SESSION['OBSOLETE']) && !isset($_SESSION['EXPIRES'])) {
        return false;
    }
    if (isset($_SESSION['EXPIRES']) && $_SESSION['EXPIRES'] < time()) {
        return false;
    }
    return true;
}
function regenerateSession() {
    if (isset($_SESSION['OBSOLETE'])) {
        if ($_SESSION['OBSOLETE'] == true) {
            return;
        }
    }

    $_SESSION['OBSOLETE'] = true;
    $_SESSION['EXPIRES'] = time() + 10;
    session_regenerate_id(false);
    $newSession = session_id();
    session_write_close();
    session_id($newSession);
    session_start();
    unset($_SESSION['OBSOLETE']);
    unset($_SESSION['EXPIRES']);
}
function preventHijacking() {
    if (!isset($_SESSION['IPaddress']) || !isset($_SESSION['userAgent'])) {
        return false;
    }
    if ($_SESSION['IPaddress'] != SaltMD5($_SERVER['REMOTE_ADDR'])) {
        return false;
    }
    if ($_SESSION['userAgent'] != SaltMD5($_SERVER['HTTP_USER_AGENT'])) {
        return false;
    }
    return true;
}
function checkbrute($user_id) {
    $mysqli = isset($mysqli) ? $mysqli : Connection();
    // change Y-m-d H:i:s to now
    $now = date('now');
    $valid_attempts = $now - (2 * 60 * 60);
    if ($stmt = $mysqli->prepare("DELETE
                               FROM login_attempts
                               WHERE user_id = ?
                               AND now < '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
    }
    if ($stmt = $mysqli->prepare("SELECT now
                           FROM login_attempts
                           WHERE user_id = ?
                          AND now > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->store_result();
        $mysqli->close();
        if ($stmt->num_rows > 10) {
            return true;
        } else {
            return false;
        }
    }
}

function esc_url($url) {
    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);
    $url = htmlentities($url);
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        return '';
    } else {
        return $url;
    }
}
function login_check($from = "") {
    $actual_link = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/{$_SERVER['REQUEST_URI']}";
    $mysqli = isset($mysqli) ? $mysqli : Connection();
    if (!isset($_SESSION['user_id']) && !is_session_started()) {
        sessionStart("Login");
    }
    if (!empty($_SESSION['user_id'])) {
        $uid = TextToDB($_SESSION['user_id']);
        if ($stmt = $mysqli->prepare("SELECT wizard
                                  FROM users
                                  WHERE id = ?
                                  LIMIT 1")) {
            $stmt->bind_param('i', $uid);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($wiz);
            $stmt->fetch();
            $_SESSION['wizard'] = $wiz;
        }
    }
    if (isset($_SESSION['wizard']) && $_SESSION['wizard'] == 0  && $from != "wizard") {
        $mysqli->close();
        redirect("wizard.php");die();
    }
    if (!isset($_SESSION['cookie']) && empty($_SESSION['user_id'])) {
        if (!isset($_COOKIE['telepath'])) {
            if (strpos($actual_link, 'login') == false) {
                $_SESSION['Last_URL'] = $_SERVER['REQUEST_URI'];
            }
            $mysqli->close();
            return false;
        }
        $uname = $_COOKIE['telepath'];
        if (!empty($uname)) {
            $uname = TextToDB($uname);
            $sql = "SELECT id, username, password, verify, isdr FROM `users` WHERE `login_session`=?";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param('s', $uname);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($user_id, $username, $db_password, $verify, $isdr);
                $stmt->fetch();
                if ($verify == 0) {
                    $mysqli->close();
                    return false;
                }

                if ($stmt = $mysqli->prepare("SELECT ip FROM ip_table WHERE id='$user_id'")) {
                    $stmt->execute();
                    $stmt->bind_result($ips_);
                    $stmt->store_result();
                }
                $ipz = GetUserIP();
                if ($stmt->num_rows > 0) {
                    while ($stmt->fetch()) {
                        if ($ipz !== $ips_) {
                            $mysqli->close();
                            return false;
                        }
                    }
                }
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                $_SESSION['login_string'] = $uname;
                $_SESSION['cookie'] = $uname;
                setcookie("telepath", $uname, time()+1123200, '/', DOMAIN);
                return array(true, $isdr);
            }
        }
    }
    if (isset($_SESSION['user_id']) && isset($_SESSION['username']) && isset($_SESSION['login_string'])) {
        if ($_SESSION['user_id'] == 0 || $_SESSION['user_id'] == "0" || empty($_SESSION['user_id'])) {
            lagout();
            if (strpos($actual_link, 'login') == false) {
                $_SESSION['Last_URL'] = $_SERVER['REQUEST_URI'];
            }
            $mysqli->close();
            return false;
        }
        $user_id = TextToDB($_SESSION['user_id']);
        $login_string = TextToDB($_SESSION['login_string']);
        $username = TextToDB($_SESSION['username']);
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
        if ($stmt = $mysqli->prepare("SELECT login_session, isdr
                                      FROM users
                                      WHERE id = ? LIMIT 1")) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                $stmt->bind_result($password, $isdr);
                $stmt->fetch();
                if ($password == $login_string) {
                    $mysqli->close();
                    return array(true, $isdr);
                } else {
                    if (strpos($actual_link, 'login') == false) {
                        $_SESSION['Last_URL'] = $_SERVER['REQUEST_URI'];
                    }
                    $mysqli->close();
                    return false;
                }
            } else {
                if (strpos($actual_link, 'login') == false) {
                    $_SESSION['Last_URL'] = $_SERVER['REQUEST_URI'];
                }
                $mysqli->close();
                return false;
            }
        } else {
            if (strpos($actual_link, 'login') == false) {
                $_SESSION['Last_URL'] = $_SERVER['REQUEST_URI'];
            }
            $mysqli->close();
            return false;
        }
    } else {
        if (strpos($actual_link, 'login') == false) {
            $_SESSION['Last_URL'] = $_SERVER['REQUEST_URI'];
        }
        $mysqli->close();
        return false;
    }
    if (strpos($actual_link, 'login') == false) {
        $_SESSION['Last_URL'] = $_SERVER['REQUEST_URI'];
    }
    $mysqli->close();
    return false;
}
function Login($email, $password, $remember = false, $wiz = false) {
    $mysqli = isset($mysqli) ? $mysqli : Connection();
    $email = TextToDB($email);
    $password = SaltMD5($password, $email);
    $HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
    $IP = GetUserIP();
    if ($stmt = $mysqli->prepare("SELECT id, username, password, verify, isdr, wizard
                                  FROM users
                                  WHERE username = ? or email = ?
                                  LIMIT 1")) {
        $stmt->bind_param('ss', $email, $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($user_id, $username, $db_password, $verify, $is_dr, $wiz);
        $stmt->fetch();
        if ($stmt = $mysqli->prepare("SELECT ip FROM ip_table WHERE id='$user_id'")) {
            $stmt->execute();
            $stmt->bind_result($ips_);
            $stmt->store_result();
        }
        $ipz = GetUserIP();
        if ($stmt->num_rows > 0) {
            while ($stmt->fetch()) {
                if ($ipz !== $ips_) {
                    $mysqli->close();
                    return "شما با IP غیر مجاز وارد شده اید";
                }
            }
        }
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
        $now = date('Y-m-d H:i:s');
        if ((empty($user_id) || empty($username)) || ($user_id === 0 || $username === 0)) {
            $mysqli->close();
            return "نام کاربری غیر معتبر است";
        }
        if ($wiz == false) {
          if ( isset($verify) && $verify === 0) {
            $mysqli->close();
              return 'حساب خود را فعال کنید';
          }
        }
        if (isset($db_password) && strlen($db_password) > 0) {
            if (checkbrute($user_id, $mysqli) == true) {
              $mysqli->close();
                return 'خطایی پیش آمده لطفا مجددا تلاش کنید';
            } else {
                if ($db_password == $password) {
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/",
                                                              "",
                                                              $username);
                    lagout();
                    if (!isset($_SESSION['user_id']) && !is_session_started()) {
                        sessionStart("Login");
                    }
                    $d_day = strtotime( '+1 days' ) ;
                    if (isset($remember) && $remember!==false) {
                      $d_day = strtotime( '+7 days' ) ;
                    }
                    $cookiehash = SaltMD5($user_id . $IP . $now);
                    // change Y-m-d H:i:s -> now

                    setcookie("telepath", $cookiehash, $d_day, '/', DOMAIN);
                    $sql = "UPDATE `users` SET `login_session`='$cookiehash' WHERE `id`='$user_id'";
                    if ($stmt = $mysqli->prepare($sql)) {
                        $stmt->execute();
                    }
                    $_SESSION['emall'] = encrypt($email);
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = $cookiehash;
                    $_SESSION['wizard'] = $wiz;
                    $mysqli->close();
                    return array(true, $is_dr);
                } else {
                    if ($stmt = $mysqli->prepare("INSERT INTO login_attempts(user_id, now, user_agent, ip)
                                  VALUES ('$user_id', '$now', '$user_browser', '$IP')")) {
                        $stmt->execute();
                    }
                    $mysqli->close();
                    $mysqli->close();
                    return 'نام کاربری یا گذرواژه اشتباه است';
                }
            }
        } else {
          $mysqli->close();
            return 'خطا در ورود به حساب کاربری لطفا چند دقیقه دیگر دوباره تلاش کنید';
        }
    } else { $mysqli->close();return "could not get mysql query !" ;}
}
// logout
function lagout() {
  $_uid = NULL;
    if (!isset($_SESSION['user_id']) && !is_session_started()) {
        sessionStart("Login");
    }
    $mysqli = isset($mysqli) ? $mysqli : Connection();
    try {
        $_uid = TextToDB($_SESSION['user_id']);
    } catch (Exception $e) {
        $_uid = 0;
    }

    $sql = "UPDATE `users` SET `login_session`='' WHERE `id`='" . $_uid ."'";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->execute();
    }
    $mysqli->close();
    $_SESSION = array();
    session_unset();
    $params = session_get_cookie_params();
    setcookie(session_name(),
          '', time() - 42000,
          $params["path"],
          $params["domain"],
          $params["secure"],
          $params["httponly"]);
    ini_set('session.gc_max_lifetime', 0);
    ini_set('session.gc_probability', 1);
    ini_set('session.gc_divisor', 1);
    session_destroy();
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach ($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time()-1000);
            setcookie($name, '', time()-1000, '/');
        }
    }
}
/////////////////////////////////Logs Function's////////////////////////////////
function user_activitys() {
    if (!isset($_SESSION['Last_URL']) && !is_session_started()) {
        sessionStart("Login");
    }
    $mysqli = isset($mysqli) ? $mysqli : Connection();
    $user_id = isset($_SESSION['user_id'])?$_SESSION['user_id']:'-1';
    $actual_link = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/{$_SERVER['REQUEST_URI']}";
    $user_ip = GetUserIP();
    $now = date('Y-m-d H:i:s');
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $mysqli->query("INSERT INTO user_activitys(user_id, actual_link, user_agent, ip, now)
                  VALUES ('$user_id', '$actual_link', '$user_agent', '$user_ip', '$now')");
    $mysqli->close();
}
/////////////////////////////////Core Function's////////////////////////////////
function sendemail($to, $subject, $message) {
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <noreplay@telepathy.ir>' . "\r\n";
  //$headers .= 'Cc: tspersian@gmail.com' . "\r\n";
  mail($to, $subject, $message, $headers, '-fnoreplay@telepathy.ir');
}
function register($username, $password, $email, $isdr = 0, $drcode = '') {
    $mysqli = isset($mysqli) ? $mysqli : Connection();
    $username = TextToDB($username);
    try {
      $password = SaltMD5($password, $email);
    } catch (Exception $e) {
      return false;
    }
    $email = TextToDB($email);
    $IP = TextToDB(GetUserIP());
    $now = date('Y-m-d H:i:s');
    $verify_send_hash = SaltMD5($username.$email.$now);
    $sql = "SELECT * FROM `users` WHERE username = '$username' OR email = '$email'";
    $res = mysqli_query($mysqli, $sql);
  	$count = mysqli_num_rows($res);
  	if($count == 1){
      $mysqli->close();
      return false ;
    }
    if ($stmt = $mysqli->prepare("INSERT INTO users(username, password, email,
                                  verify_send, verify_send_hash, isdr, register_ip, drcode)
                                  VALUES ('$username', '$password', '$email', '$now', '$verify_send_hash', $isdr, '$IP', '$drcode')")) {
        $stmt->execute();
        try {
          $emailstruct = "سلام :$username <br>".
                         DOMAIN."/verify.php?email=$email&username=$username&confirm=".$verify_send_hash;
                         //echo ?
          sendemail($email, "Registeration", $emailstruct);
        } catch (Exception $e) {
          $mysqli->close();
            return false;
        }
        $mysqli->close();
        return true;
    } else {
      $mysqli->close();
      return false;
    }
}
function renewverify($username, $email) {
    $mysqli = isset($mysqli) ? $mysqli : Connection();
    $now = date('Y-m-d H:i:s');
    $verify_send_hash = SaltMD5($username.$email.$now);
    if ($stmt = $mysqli->prepare("SELECT verify_send FROM users WHERE username = ? or email = ?
      LIMIT 1")) {
        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($verify_send);
        $stmt->fetch();
        if (strtotime(time()) >= strtotime($verify_send) + 7200) {
            if ($stmt = $mysqli->prepare("UPDATE users
                                      SET verify_send='".$now."',verify_send_hash='".$verify_send_hash."'
                                      WHERE username = ? or email = ?")) {
                $stmt->bind_param('ss', $username, $email);
                $stmt->execute();
            }
        }
    }
    $emailstruct = "user:$username thank you for register<br>".
                   DOMAIN."/verify.php?email=$email&username=$username&confirm=".$verify_send_hash;
    sendemail($email, "Registeration", $emailstruct);
    $mysqli->close();
}
function Image_Upload($uFile) {
    $error       = false;
    $ds          = DIRECTORY_SEPARATOR;
    $storeFolder = UPLOAD_PROFILE_PIC;
    $maxsize    = 216791;
    $mysqli = isset($mysqli) ? $mysqli : Connection();

    if (!empty($uFile) && $uFile['tmp_name']) {
        $tempFile = $uFile['tmp_name'][0];
        if (isset($_SESSION['user_id'])) {
            $next_id = $_SESSION['user_id'];
            $email_ = decrypt($_SESSION['emall']);
            $username_ = $_SESSION['username'];
        } else {
            $error = true;
        }
    }

    if (!$error) {
        $fileName = time().'_'.SaltMD5($uFile['name'][0]).'.jpg';
        if (!empty($tempFile)) {
            $detectedType = exif_imagetype($tempFile);

            $allowedTypes = array(IMAGETYPE_PNG);
            $error = !in_array($detectedType, $allowedTypes);
            $pngz = $error;
            $allowedTypes = array(IMAGETYPE_JPEG);

            $error = !in_array($detectedType, $allowedTypes);
      // end of check
      if (!$error || !$pngz) {
          if (($uFile['size'][0] >= $maxsize) || ($uFile["size"][0] == 0)) {
              return 'فایل باید کمتر از 200 KB باشد';
          } else {
              if ($stmt = $mysqli->prepare("SELECT picture
                                          FROM users
                                          WHERE username = ? or email = ?")) {
                  $stmt->bind_param('ss', $username_, $email_);
                  $stmt->execute();
                  $stmt->store_result();
                  $stmt->bind_result($picture);
                  $stmt->fetch();
              }
              $targetPath = $storeFolder . $ds;

              $targetFile =  $targetPath. $fileName;

              if (move_uploaded_file($tempFile, $targetFile)) {
                  if ($stmt = $mysqli->prepare("UPDATE users
                                            SET picture='$targetFile'
                                            WHERE username = ? or email = ?")) {
                      $stmt->bind_param('ss', $username_, $email_);
                      $stmt->execute();
                      if ($picture == "assets/images/users/no-image.jpg") {
                          // return 1;
                      } else {
                          unlink($picture);
                      }
                      $mysqli->close();
                      return false;
                  }
              }
          }
      } else {
        $mysqli->close();
          return 'فرمت فایل نادرست است';
      }
        } else {
          $mysqli->close();
            return 'فایل خالی است';
        }
    } else {
      $mysqli->close();
        return '<a href=\".\">صفحه خود را دوباره بارگذاری کنید.</a>';
    }
}
function SaltMD5($str, $salt = 'kM3@A2RdYuA!MeNmA0@E1IvM$IzsQ2l@B8g0s') {
    $salt = sha1(md5("$str")).$salt;
    return crypt("$str", $salt);
}
function encrypt($pure_string, $encryption_key = "emnacrryyapmtdiuosne_tkdeayr1a3m", $tag = "1234123412341234") {
    $cipher = "aes-128-gcm";
    $iv_size = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($iv_size);
    $encrypted_string = openssl_encrypt($pure_string, $cipher, $encryption_key, $options=0, $iv);
    return $encrypted_string;
}
function decrypt($encrypted_string, $encryption_key = "emnacrryyapmtdiuosne_tkdeayr1a3m", $tag = "1234123412341234") {
    $cipher = "aes-128-gcm";
    $iv_size = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($iv_size);
    $original_plaintext = openssl_decrypt($encrypted_string, $cipher, $encryption_key, $options=0, $iv);
    return $original_plaintext;
}
function Connection() {
    try {
        if (islocal()) {
            $conn = new mysqli("127.0.0.1", "root", "123", "telepathymaster");
        } else {
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);//, DB_PORT);
        }
        $conn->set_charset("utf8");
        return $conn;
    } catch (Exception $e) {
        $globals["errors"] .= 'Caught exception: '.  $e->getMessage(). PHP_EOL;
    }
}
function FixPersianNumber($number) {
    $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $num = range(0, 9);
    return str_replace($persian, $num, $number);
}
function FixPersianString($text) {
    if (is_null($text)) {
        return null;
    }
    $replacePairs = array(
        chr(0xD9).chr(0xA0) => chr(0xDB).chr(0xB0),
        chr(0xD9).chr(0xA1) => chr(0xDB).chr(0xB1),
        chr(0xD9).chr(0xA2) => chr(0xDB).chr(0xB2),
        chr(0xD9).chr(0xA3) => chr(0xDB).chr(0xB3),
        chr(0xD9).chr(0xA4) => chr(0xDB).chr(0xB4),
        chr(0xD9).chr(0xA5) => chr(0xDB).chr(0xB5),
        chr(0xD9).chr(0xA6) => chr(0xDB).chr(0xB6),
        chr(0xD9).chr(0xA7) => chr(0xDB).chr(0xB7),
        chr(0xD9).chr(0xA8) => chr(0xDB).chr(0xB8),
        chr(0xD9).chr(0xA9) => chr(0xDB).chr(0xB9),
        chr(0xD9).chr(0x83) => chr(0xDA).chr(0xA9),
        chr(0xD9).chr(0x89) => chr(0xDB).chr(0x8C),
        chr(0xD9).chr(0x8A) => chr(0xDB).chr(0x8C),
        chr(0xDB).chr(0x80) => chr(0xD9).chr(0x87) . chr(0xD9).chr(0x94));
    return strtr($text, $replacePairs);
}
function GetUserIP() {
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip); // just to be safe

                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
}
function safeRedirect($url, $exit = true) {
    try {
        if (!headers_sent()) {
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . $url, true, 303);
            header("Connection: close");
        }
        print '<html>';
        print '<head><title>Redirecting you...</title>';
        print '<meta http-equiv="Refresh" content="0;url=' . $url . '" />';
        print '</head>';
        print '<body onload="location.replace(\'' . $url . '\')">';
        print 'You should be redirected to this URL:<br />';
        print "<a href='$url'>$url</a><br /><br />";
        print 'If you are not, please click on the link above.<br />';
        print '</body>';
        print '</html>';
        if ($exit) {
            exit;
        }
    } catch (Exception $err) {
        return $err->getMessage();
    }
}
function redirect($url, $statusCode = 303) {
    header('Location: ' . urlencode($url));
    die();
}
function hide_email($email) {
    for ($i = 0; $i < strlen($email); $i++) {
        $output .= '&#'.ord($email[$i]).';';
    }
    return $output;
  // $character_set = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
  // $key = str_shuffle($character_set); $cipher_text = ''; $id = 'e'.rand(1,999999999);
  // for ($i=0;$i<strlen($email);$i+=1) $cipher_text.= $key[strpos($character_set,$email[$i])];
  // $script  = 'var a="'.$key.'";var b=a.split("").sort().join("");var c="'.$cipher_text.'";var d="";';
  // $script .= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));';
  // $script .= 'document.getElementById("'.$id.'").innerHTML="<span class="fa fa-phone"></span>"';
  // $script .= 'document.getElementById("'.$id.'").href = \\"mailto:"+d+"\\"';
  // $script = "eval(\"".str_replace(array("\\",'"'),array("\\\\",'\"'), $script)."\")";
  // $script = '<script type="text/javascript">'.$script.'</script>';
  // return '<a id="'.$id.'" class="profile-control-left"></a>'.$script;
}
function date_number_to_word_persian($num) {
      $arr1 = array('یک', 'دو', 'سه', 'چهار', 'پنج','شش', 'هفت');
      if ($num < 7) {
          if ($num == 0) {
              return "امروز";
          }
          return $arr1[$num]." روز پیش";
      } elseif ($num <= 14) {
          return (intval($num / 7)) ." هفته پیش";
      } else {
          return  ($num);
      }
  }
function is_numeric_array($array) {
      foreach ($array as $a => $b) {
          if (!is_int($a)) {
              return false;
          }
      }
      return true;
  }
/* UPLOAD */
function getOS() {

    $user_agent     =   $_SERVER['HTTP_USER_AGENT'];

    $os_platform    =   "Unknown OS Platform";

    $os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );

    foreach ($os_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }
    }
    return $os_platform;
}
function getBrowser() {

    $user_agent     =   $_SERVER['HTTP_USER_AGENT'];

    $browser        =   "Unknown Browser";

    $browser_array  =   array(
                            '/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/edge/i'       =>  'Edge',
                            '/opera/i'      =>  'Opera',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
                            '/mobile/i'     =>  'Handheld Browser'
                        );

    foreach ($browser_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }

    }

    return $browser;

}

/* is_email
// check mikone ke ye string
 yek reshte i hast ke email hast ya na */
function is_email($email) {
  $ret = false ;
  if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $ret = true ;
  }
  return ret ;
}




  function is_user_activities_set() {
    if (!isset($_SESSION['Last_URL']) && !is_session_started()) {
        sessionStart("Login");
    }
    $mysqli = isset($mysqli) ? $mysqli : Connection();
    $user_id = isset($_SESSION['user_id'])?$_SESSION['user_id']:'-1';
    $actual_link = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/{$_SERVER['REQUEST_URI']}";
    $user_ip = GetUserIP();
    // $now = date('Y-m-d H:i:s');
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    // echo $user_id . " " . $actual_link . " " . $user_ip . " " . $now . " " . $user_agent . "<br />" ;
    $user_id = TextToDB($user_id);
    $sql = "SELECT ua.user_agent, u.email FROM user_activitys as ua INNER JOIN users as u ON u.id = ? WHERE ua.user_id = ? ORDER BY ua.ua_id desc limit 1" ;
    if ($result = $mysqli->prepare($sql)) {
      $result->bind_param('ii', $user_id,$user_id);
      $result->execute();
      $result->store_result();
      $result->bind_result($user_agent, $to);
      $result->fetch();
    }
    if ($user_agent === false) {
      $subject = "account problem" ;
      $message = "sombody login with diffrent os in your account !";
      sendemail($to, $subject, $message);
    }
    $mysqli->close();
    return ($user_agent == $user_agent ? true : false);
  }
/* to get user datas */
  function pull_out_users_data() {
    $mysqli = isset($mysqli) ? $mysqli : Connection();

    $username = (!empty($_SESSION['username']) ? TextToDB($_SESSION['username']) : "guest");
    $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
    if ($result = $mysqli->prepare($sql)) {
      $result->bind_param('s', $username);
      $r = $result->execute();

      if ($r) {
        $row = $result->get_result();
        $_data = $row->fetch_assoc();
        $mysqli->close();
        return $_data;
      } else {
        $mysqli->close();
        echo "There is not such a row in users table !" ;
        die();
      }
    } else {
        echo "error";
    }

    $mysqli->close() ;
  }
/* to validate national id */
function isValidIranianNationalCode($input) {
    if (!preg_match("/^\d{10}$/", $input)) {
        return false;
    }

    $check = (int) $input[9];
    $sum = array_sum(array_map(function ($x) use ($input) {
        return ((int) $input[$x]) * (10 - $x);
    }, range(0, 8))) % 11;

    return ($sum < 2 && $check == $sum) || ($sum >= 2 && $check + $sum == 11);
}
function TextToDB($input) {
  $mysqli = isset($mysqli) ? $mysqli : Connection();
  $input = $mysqli->real_escape_string($input);
  $input = strip_tags($input);
  $input = trim($input);
  $mysqli->close();
  return $input;
}
function is_ajax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}
function CleanFullCalendarEvents($events_) {
  foreach ($events_ as $ik => $insider) {
    if (empty($insider) || $insider == '') continue;
    foreach ($events_ as $ok => $outsider) {
      if (empty($outsider) || $outsider == '') continue;
      if($outsider === $insider) continue;
      if ($insider->isWithinDayRange($outsider->start, $outsider->end)) {
        if ($outsider->start === $insider->start) {
          if ($outsider->end === $insider->end) {
            if (strpos($insider->title, 'ساعت ثبت شده' ) !== false) {
              if (strpos($outsider->title, 'ساعت ثبت شده' ) !== false) {
                // {{   }}
                // echo "{{   }}".PHP_EOL;
                unset($events_[$ok]);
                continue;
              } else {
                // |{   }|
                // echo "|{   }|".PHP_EOL;
                unset($events_[$ok]);
                continue;
              }
            } else {
              if (strpos($outsider->title, 'ساعت ثبت شده' ) !== false) {
                // {|   |}
                // echo "{|   |}".PHP_EOL;
                unset($events_[$ik]);
                break;
              } else {
                // ||   ||
                // echo "||   ||".PHP_EOL;
                unset($events_[$ok]);
                continue;
              }
            }
          } else {
            if (strpos($insider->title, 'ساعت ثبت شده' ) !== false) {
              if (strpos($outsider->title, 'ساعت ثبت شده' ) !== false) {
                // {{   }  }
                // echo "{{   }  }".PHP_EOL;
                unset($events_[$ik]);
                break;
              } else {
                // |{   }   |
                // echo "|{   }   |".PHP_EOL;
                $outsider->start = $insider->end;
                continue;
              }
            } else {
              if (strpos($outsider->title, 'ساعت ثبت شده' ) !== false) {
                // {|   |   }
                // echo "{|   |   }".PHP_EOL;
                unset($events_[$ik]);
                break;
              } else {
                // ||   |   |
                // echo "||   |   |".PHP_EOL;
                unset($events_[$ik]);
                break;
              }
            }
          }
        } else {
          if ($outsider->end === $insider->end) {
            if (strpos($insider->title, 'ساعت ثبت شده' ) !== false) {
              if (strpos($outsider->title, 'ساعت ثبت شده' ) !== false) {
                // {   {   }}
                // echo "{   {   }}".PHP_EOL;
                unset($events_[$ik]);
                break;
              } else {
                // |   {   }|
                // echo "|   {   }|".PHP_EOL;
                $outsider->end = $insider->start;
                continue;
              }
            } else {
              if (strpos($outsider->title, 'ساعت ثبت شده' ) !== false) {
                // {   |   |}
                // echo "{   |   |}".PHP_EOL;
                unset($events_[$ik]);
                break;
              } else {
                // |   |   ||
                // echo "|   |   ||".PHP_EOL;
                unset($events_[$ik]);
                break;
              }
            }
          } else {
            if (strpos($insider->title, 'ساعت ثبت شده' ) !== false) {
              if (strpos($outsider->title, 'ساعت ثبت شده' ) !== false) {
                // {   {     }    }
                // echo "{   {     }    }".PHP_EOL;
                unset($events_[$ik]);
                break;
              } else {
                // |   {     }    |
                // echo "|   {     }    |".PHP_EOL;
                $events__ = new Event($outsider);
                $events__->start = $insider->end;
                $outsider->end = $insider->start;
                $events_[] = $events__;
                continue;
              }
            } else {
              if (strpos($outsider->title, 'ساعت ثبت شده' ) !== false) {
                // {   |     |    }
                // echo "{   |     |    }".PHP_EOL;
                unset($events_[$ik]);
                break;
              } else {
                // |   |     |    |
                // echo "|   |     |    |".PHP_EOL;
                unset($events_[$ik]);
                break;
              }
            }
          }
        }
      } else {
        // NOT INSIDE
        if ($insider->start == $outsider->start && $insider->end !== $outsider->end) {
          if (strpos($insider->title, 'ساعت ثبت شده' ) !== false) {
            if (strpos($outsider->title, 'ساعت ثبت شده' ) !== false) {
              // {[   }   ]
              if ($insider->end > $outsider->end) {
                // {[   ]   }
                // echo "{[   ]   }".PHP_EOL;
                unset($events_[$ok]);
                continue;
              } else {
                // {[   }   ]
                // echo "{[   }   ]".PHP_EOL;
                unset($events_[$ik]);
                break;
              }
            } else {
              // |{   |   }
              if ($insider->end > $outsider->end) {
                // echo "|{   }   |".PHP_EOL;
                unset($events_[$ok]);
                continue;
              } else {
                // echo "|{   |   }".PHP_EOL;
                $outsider->start = $insider->end;
                continue;
              }
            }
          } else {
            if (strpos($outsider->title, 'ساعت ثبت شده' ) !== false) {
              // {|     }    |
              if ($insider->end > $outsider->end) {
                // echo "{|     }    |".PHP_EOL;
                $insider->start = $outsider->end;
                continue;
              } else {
                // echo "{|     |    }".PHP_EOL;
                unset($events_[$ik]);
                break;
              }
            } else {
              // |/     |    /
              if ($insider->end > $outsider->end) {
                // echo "|/     |    /".$outsider.PHP_EOL;
                unset($events_[$ok]);
                continue;
              } elseif ($insider->end == $outsider->end) {
                // echo "|/     /|".PHP_EOL;
                unset($events_[$ik]);
                break;
              } else {
                // echo "|/     /    |".PHP_EOL;
                unset($events_[$ik]);
                break;
              }
            }
          }
        } elseif ($insider->start !== $outsider->start && $insider->end == $outsider->end) {
          if (strpos($insider->title, 'ساعت ثبت شده' ) !== false) {
            if (strpos($outsider->title, 'ساعت ثبت شده' ) !== false) {
              // {  [   }]
              if ($insider->start > $outsider->start) {
                // echo "{  [   }]".PHP_EOL;
                unset($events_[$ik]);
                break;
              } else {
                // echo "{  [   }]".PHP_EOL;
                unset($events_[$ok]);
                continue;
              }
            } else {
              // |    {   |}
              if ($insider->start > $outsider->start) {
                // echo "|    {   |}".PHP_EOL;
                $outsider->end = $insider->start;
                continue;
              } else {
                // echo "|    {   |}".PHP_EOL;
                unset($events_[$ok]);
                continue;
              }
            }
          } else {
            if (strpos($outsider->title, 'ساعت ثبت شده' ) !== false) {
              // {    |     }|
              // echo "{    |     }|".PHP_EOL;
              if ($insider->start > $outsider->start) {
                unset($events_[$ik]);
                break;
              } else {
                $insider->end = $outsider->start;
                continue;
              }
            } else {
              // |    /     |/
              // echo "|    /     |/".PHP_EOL;
              if ($insider->start > $outsider->start) {
                unset($events_[$ik]);
                break;
              } else {
                unset($events_[$ok]);
                continue;
              }
            }
          }
        } elseif ($insider->start == $outsider->end) {
          if (strpos($insider->title, 'ساعت ثبت شده' ) !== false) {
            if (strpos($outsider->title, 'ساعت ثبت شده' ) !== false) {
              // {}[]
              // echo "{}[]".PHP_EOL;
              $insider->start = $outsider->start;
              unset($events_[$ok]);
              continue;
            } else {
              // ||{}
              // echo "||{}".PHP_EOL;
              continue;
            }
          } else {
            // echo "{}||".PHP_EOL;
            if (strpos($outsider->title, 'ساعت ثبت شده' ) !== false) {
              // {}||
            } else {
              // ||//
              $insider->start = $outsider->start;
              unset($events_[$ok]);
              continue;
            }
          }
        } elseif ($insider->end == $outsider->start) {
          if (strpos($insider->title, 'ساعت ثبت شده' ) !== false) {
            if (strpos($outsider->title, 'ساعت ثبت شده' ) !== false) {
              // []{}
              // echo "[]{}".PHP_EOL;
              $insider->start = $outsider->start;
              unset($events_[$ok]);
              continue;
            } else {
              // echo "{}||".PHP_EOL;
              // {}||
            }
          } else {
            if (strpos($outsider->title, 'ساعت ثبت شده' ) !== false) {
              // ||{}
              // echo "||{}".PHP_EOL;
            } else {
              // //||
              // echo "//||".PHP_EOL;
              $insider->start = $outsider->end;
              unset($events_[$ok]);
              continue;
            }
          }
        }
      }
    }
  }
  return $events_;
}
