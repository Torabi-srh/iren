<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/assets/functions.php');
$log_check = login_check();
if ($log_check === false) {
  saferedirect("login.php");
} else {
  if($log_check[0] === false) {
    redirect("login.php");
  }
}
$myObj = new StdClass;
$myObj->a = "danger";
$myObj->b = "<a href=\".\">صفحه خود را دوباره بارگذاری کنید.</a>";
$error500 = json_encode($myObj, JSON_UNESCAPED_UNICODE);
if (!is_ajax()) {
  echo $error500;die();
}
$mysqli = isset($mysqli) ? $mysqli : Connection();
$uid = TextToDB($_SESSION['user_id']);
$page = 0;


if (!empty($_POST['p'])) $page = $_POST['p'] - 1;
if (!filter_var($page, FILTER_VALIDATE_INT) || !is_numeric($page)) $page = 0;
$sql = "SELECT u.fname, u.name, r.depose, r.depose_date FROM users AS u INNER JOIN invoice AS r ON r.uid = u.id WHERE u.id = ? LIMIT 9 OFFSET ?";
///////////////////////////
if ($stmt = $mysqli->prepare($sql)) {
  $stmt->bind_param('ii', $uid, $page);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($ifname, $iname, $idepose, $iddate);
  $row_ind = ($page*5)+1;
  while ($stmt->fetch()) {
    $full_name = $iname .  " " . $ifname;
    $today = jdate('Y/m/d', strtotime($iddate)) ;
    $html_to_show = "<tr>
                     <td><a href=\"#\">{$full_name}</a></td>
                     <td>{$today}</td>
                     <td><span class=\"label label-".($idepose > 0 ? "success" : "danger")."\">$idepose ريال</span></td>
                     </tr>";
      $row_ind++;
      echo $html_to_show;
  }
}

 ?>
