<?php
  include_once($_SERVER['DOCUMENT_ROOT'].'/assets/functions.php');
  $log_check = login_check();
  if ($log_check === false) {
    saferedirect("login.php");
  } else {
    if($log_check[0] === false) {
      redirect("login.php");
    } elseif ($log_check[1] === 0) {
      redirect("profile-user.php") ;
    }
  }

  if (!is_ajax()) {
    echo $error500;die();
  }
  $mysqli = isset($mysqli) ? $mysqli : Connection();
  $user_id = $_SESSION['user_id'];
  $page = 0;
  if (!empty($_POST['p'])) $page = $_POST['p'] - 1;
  if (!filter_var($page, FILTER_VALIDATE_INT) || !is_numeric($page)) $page = 0;
  $sql = "SELECT u.id, u.fname, u.name, r.date_time FROM users AS u INNER JOIN reservation AS r ON r.did = ? WHERE u.id = r.uid LIMIT 5 OFFSET ?";
  ///////////////////////////
  if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param('ii', $user_id, $page);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($uid, $ufname, $uname, $rdate);
    $row_ind = 1;
    while ($stmt->fetch()) {
      $full_name = $uname .  " " . $ufname;
      $today = jdate('Y/m/d', strtotime($rdate)) ;
      $html_to_show = "<tr>
                        <td class=\"col-md-1\">
                            <h4>{$row_ind}</h4>
                        </td>
                        <td class=\"col-md-2\"><h5><strong>{$today}</strong></h5></td>
                        <td class=\"col-md-1\">
                            <a href=\"profile-user.php\">
                             <b>{$full_name}</b>
                            </a>
                        </td>
                        <td class=\"col-md-3\">
                            <input type=\"text\" class=\"form-control\" placeholder=\"\">
                        </td>
                        <td class=\"col-sm-4 col-md-4\" style=\"display: contents;\">
                          <div class=\"btn-group\" style=\"margin-top: 5px;\">
                            <button type=\"button\" class=\"btn btn-warning\">
                                <i class=\"fa fa-user-md\" aria-hidden=\"true\"></i>
                                دعوت‌به‌مطب
                            </button>
                            <button type=\"button\" class=\"btn btn-success\">
                                <i class=\"fa fa-times\" aria-hidden=\"true\"></i>
                                ثبت
                            </button>
                            <button type=\"button\" class=\"btn btn-danger\">
                                <i class=\"fa fa-times\" aria-hidden=\"true\"></i>
                                حذف
                            </button>
                          </div>
                        </td>
                    </tr>";
        $row_ind++;
        echo $html_to_show;
    }
  }
  ////////////////////////////
 ?>
