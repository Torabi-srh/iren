<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/assets/functions.php');
$log_check = login_check();
if ($log_check === false) {
  saferedirect("login.php");
} else {
  if($log_check[0] === false) {
    redirect("login.php");
  } elseif ($log_check[1] === 1) {
    redirect("profile-doctor.php") ;
  }
}

if (!is_ajax()) {
  echo $error500;die();
}
$mysqli = isset($mysqli) ? $mysqli : Connection();
if (!empty($_POST['mdialog'])) {
  $ididi = TextToDB($_POST['mdialog']);
  $sql = "SELECT `id`, `picture`, `fname`, `name`, `username`, `bio` FROM users where id = ?";
  if ($stmt = $mysqli->prepare($sql)):
    $stmt->bind_param('i', $ididi);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($pid, $ppicture, $pfname, $pname, $pusername, $pbio);
    $stmt->fetch();
?>

<div class="col-*-*">
  <div class="panel-body">
      <a class="btn btn-default" id ="close-smoshaverClass" style="float: left;">X</a>
      <div class="form-group" style="width: 200px;float: right;">
        <img src="<?php echo "{$ppicture}"; ?>" alt="<?php echo "{$pusername}"; ?>">
        <span style="align-content: center;text-align: center;display: block;margin-top: 10px;"><i class="fa fa-star fa-3x" aria-hidden="true"></i><i class="fa fa-star  fa-3x" aria-hidden="true"></i><i class="fa fa-star fa-3x" aria-hidden="true" style="color: gold;"></i></span>
      </div>
     <div class="form-group" style="padding-right: 195px;margin-top: 10%;">
          <blockquote class="blockquote-reverse">
            <p><?php echo "{$pbio}"; ?></p>
            <footer>دکتر <?php echo "{$pname} {$pfname}"; ?></footer>
          </blockquote>
      </div>

      <div class="btn-group" style="margin-right: 20px;">
        <button type="button" id="editClass" class="btn btn-primary">چت</button>
        <button type="button" class="btn btn-primary">بلاگ</button>
        <button type="button" class="btn btn-primary">درخواست نوبت</button>
        <button type="button" class="btn btn-primary">انتخاب به عنوان مشاور</button>
        <button type="button" class="btn btn-primary">نظر شما</button>
      </div>
  </div>
</div>

<?php
  endif;
  die();
}
if (isset($_POST['u'])) {
  $fileupload = "";
  $s4phone = "";
  $s4province = "";
  $s4city = "";
  $s4addr = "";
  $s4post = "";
  $s4drphone = "";
  if (isset($_FILES["fileupload"])) {
    if ($imger = Image_Upload($_FILES["fileupload"])) {
      $myObj->b = $imger;
      $r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
      echo $r;die();
    }
  }
  if (isset($_POST["s4phone"])) {
    $s4phone = TextToDB($_POST["s4phone"]);
  } else {
    $myObj->b = "لطفا شماره خود را وارد کنید";
    $r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
    echo $r;die();
  }
  if (isset($_POST["s4province"])) {
    $s4province = TextToDB($_POST["s4province"]);
  } else {
    $myObj->b = "لطفا استان خود را وارد کنید";
    $r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
    echo $r;die();
  }
  if (isset($_POST["s4city"])) {
    $s4city = TextToDB($_POST["s4city"]);
  } else {
    $myObj->b = "لطفا شهر خود را وارد کنید";
    $r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
    echo $r;die();
  }
  if (isset($_POST["s4addr"])) {
    $s4addr = TextToDB($_POST["s4addr"]);
  } else {
    $myObj->b = "لطفا آدرس خود را وارد کنید";
    $r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
    echo $r;die();
  }
  if (isset($_POST["s4post"])) {
    $s4post = TextToDB($_POST["s4post"]);
  } else {
    $myObj->b = "لطفا کدپستی خود را وارد کنید";
    $r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
    echo $r;die();
  }
  if (!$isdr) {
    $sql = "UPDATE users SET phone = ?, province = ?, city = ?, addr = ?, pcode = ? WHERE id = ?";
  } else {
    if (isset($_POST["s4drphone"])) {
      $s4drphone = TextToDB($_POST["s4drphone"]);
    } else {
      $myObj->b = "لطفا شماره مطب خود را وارد کنید";
      $r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
      echo $r;die();
    }
    $sql = "UPDATE users SET phone = ?, province = ?, city = ?, addr = ?, pcode = ?, drphone = ? WHERE id = ?";
  }
  if ($stmt = $mysqli->prepare($sql)) {
    if ($isdr) {
      $stmt->bind_param('ssssssi', $s4phone, $s4province, $s4city, $s4addr, $s4post, $s4drphone, $uid);
    } else {
      $stmt->bind_param('sssssi', $s4phone, $s4province, $s4city, $s4addr, $s4post, $uid);
    }
    $stmt->execute();
    $stmt->store_result();
    $stmt->fetch();
    $myObj->a = "success";
    $myObj->b = "";
    $r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
    echo $r;die();
  } else { echo $error500;die(); }
  die();
}

$page = 0;
if (!empty($_POST['p'])) $page = $_POST['p'] - 1;
if (!filter_var($page, FILTER_VALIDATE_INT) || !is_numeric($page)) $page = 0;
$sql = "SELECT id, picture, fname, name, username FROM users where isdr = 1 LIMIT 8 OFFSET ?";
if ($stmt = $mysqli->prepare($sql)):
  $stmt->bind_param('i', $page);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($pid, $ppicture, $pfname, $pname, $pusername);
  while ($stmt->fetch()):
    $full_name = "$pname $pfname";
    ?>
    <div class="col-sm-3"  id="dr-item" v="<?php echo"{$pid}"; ?>">
      <div class="panel-body">
        <div class="thumbnail"><a class="xmoshaver-popup" href="#">
          <img src="<?php echo "{$ppicture}"; ?> " class="img-circle" alt="<?php echo "{$pusername}"; ?>" width="150" height="150">
          <a style="margin:70px"><?php echo "{$full_name}"; ?></a>
          </a>
        </div>
      </div>
    </div>
    <?php
  endwhile;
endif;
?>
