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
  $uid = $_SESSION['user_id'];
  $isdr = true;
  $page = 0;
/////////////////////////////////////
$myObj = new StdClass;
$myObj->a = "danger";
$myObj->b = "<a href=\".\">صفحه خود را دوباره بارگذاری کنید.</a>";
$error500 = json_encode($myObj, JSON_UNESCAPED_UNICODE);
if (isset($_POST["token"])) {
  $myObj->a = "warning";
	if (!empty($_POST['w'])) {
		$w = $_POST['w'];
		if ($w == "1") {
			if (!empty($_POST["s1fname"])) {
        $fname = TextToDB($_POST["s1fname"]);
			} else {
				$myObj->b = "لطفا نام‌خانوادگی خود را وارد کنید.";
				$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
				echo $r;die();
			}
			if (!empty($_POST["s1name"])) {
					$name = TextToDB($_POST["s1name"]);
			} else {
				$myObj->b = "لطفا نام خود را وارد کنید.";
				$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
				echo $r;die();
			}
			if (!empty($_POST["s1bday"])) {
					$bday = TextToDB($_POST["s1bday"]);
			} else {
				$myObj->b = "لطفا تاریخ‌تولد خود را وارد کنید.";
				$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
				echo $r;die();
			}
			if (!empty($_POST["s1cid"])) {
					$cid = TextToDB($_POST["s1cid"]);
			} else {
				$myObj->b = "لطفا شماره‌شناسنامه خود را وارد کنید.";
				$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
				echo $r;die();
			}
			if (!empty($_POST["s1nid"])) {
					$nid = TextToDB($_POST["s1nid"]);
			} else {
				$myObj->b = "لطفا کدملی خود را وارد کنید.";
				$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
				echo $r;die();
			}
			if (!empty($_POST["s1gen"])) {
					$gen = TextToDB($_POST["s1gen"]);
			} else {
				$myObj->b = "لطفا جنسیت خود را مشخص کنید.";
				$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
				echo $r;die();
			}
			$bday = FixPersianNumber($bday);
			$sql = "UPDATE users SET `fname` = ?, `name` = ?, `bday` = ?, `scode` = ?, `ncode` = ?, `gender` = ? WHERE `id` = ?";
			if ($stmt = $mysqli->prepare($sql)) {
				$stmt->bind_param('sssssii', $fname, $name, $bday, $cid, $nid, $gen, $uid);
				$stmt->execute();
				$stmt->store_result();
				$stmt->fetch();
				$myObj->a = "success";
				$myObj->b = "";
				$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
				echo $r;die();
			} else { echo $error500;die(); }
		} elseif ($w == "2") {
			if (!empty($_POST["s2f1mal"])) {
        $s2f1mal = TextToDB($_POST["s2f1mal"]);
			} elseif ($isdr) {
				$myObj->b = "لطفا شماره شبا خود را وارد کنید.";
				$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
				echo $r;die();
			} else {
				$myObj->b = "لطفا شغل خود را وارد کنید.";
				$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
				echo $r;die();
			}
			if (isset($_POST["s2f2mal"])) {
        $s2f2mal = TextToDB($_POST["s2f2mal"]);
			} elseif ($isdr) {
				$myObj->b = "لطفا هزینه یکساعت مشاوره خود را وارد کنید.";
				$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
				echo $r;die();
			} else {
				$myObj->b = "لطفا میزان درآمد خود را وارد کنید.";
				$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
				echo $r;die();
			}
			$sql = "UPDATE users SET iban = ?, salary = ? WHERE id = ?";
			if ($stmt = $mysqli->prepare($sql)) {
				$stmt->bind_param('sii', $s2f1mal, $s2f2mal, $uid);
				$stmt->execute();
				$stmt->store_result();
				$stmt->fetch();
				$myObj->a = "success";
				$myObj->b = "";
				$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
				echo $r;die();
			} else { echo $error500;die(); }
		} elseif ($w == "3") {
			// step 3.
      $s3f2 = NULL;
      $s3f1u = NULL;
			if (!$isdr) {
				if (isset($_POST["s3f1u"])) {
					$s3f1u = TextToDB($_POST["s3f1u"]);
				} else {
					$myObj->b = "لطفا تحصیلات خود را وارد کنید.";
					$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
					echo $r;die();
				}
				if (isset($_POST["s3f2"])) {
					$s3f2 = TextToDB($_POST["s3f2"]);
				} else {
					//$myObj->b = "لطفا تحصیلات خود را وارد کنید.";
					//$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
					//echo $r;die();
				}
        $sql = "UPDATE users SET edu = ?, bio = ? WHERE id = ?";

			} else {
        if (isset($_POST["takhasos"])) {
					$takhasos = $_POST["takhasos"];
				} else {
          $takhasos = null;
					// $myObj->b = "لطفا تخصص خود را وارد کنید.";
					// $r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
					// echo $r;die();
				}
        if (isset($_POST["roykard"])) {
					$roykard = $_POST["roykard"];
				} else {
          $roykard = null;
					// $myObj->b = "لطفا رویکرد خود را وارد کنید.";
					// $r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
					// echo $r;die();
				}
        if (isset($_POST["drcode"])) {
					$drcode = TextToDB($_POST["drcode"]);
				} else {
					$myObj->b = "لطفا شماره‌نظام‌روانشناسی خود را وارد کنید.";
					$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
					echo $r;die();
				}

				if (isset($_POST["s3f2"])) {
					$s3f2 = TextToDB($_POST["s3f2"]);
				} else {
					//$myObj->b = "لطفا تحصیلات خود را وارد کنید.";
					//$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
					//echo $r;die();
				}
        $trr = array();
        if ($stmt = $mysqli->prepare("DELETE FROM takhasos WHERE takhasos.uid = ?;")) {
          $stmt->bind_param('i', $uid);
          $stmt->execute();
          $stmt->store_result();
          $stmt->fetch();
        } else { echo $error500;die(); }
        if ($stmt = $mysqli->prepare("DELETE FROM roykard WHERE roykard.uid = ?;")) {
          $stmt->bind_param('i', $uid);
          $stmt->execute();
          $stmt->store_result();
          $stmt->fetch();
        } else { echo $error500;die(); }
        foreach ($takhasos as $key => $value) {
          $sql = "INSERT INTO takhasos(`uid`, `name`) VALUES (? , ?);";
          if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('is', $uid, $value);
            $stmt->execute();
            $stmt->store_result();
            $stmt->fetch();
          } else { echo $error500;die(); }
          $myObj->b .= "$key => $value";
        }
        foreach ($roykard as $key => $value) {
          $sql = "INSERT INTO roykard(`uid`, `name`) VALUES (? , ?);";
          if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('is', $uid, $value);
            $stmt->execute();
            $stmt->store_result();
            $stmt->fetch();
          } else { echo $error500;die(); }
          $myObj->b .= "$key => $value";
        }
        $sql = "UPDATE users SET drcode = ?, bio = ? WHERE id = ?";
			}

			if ($stmt = $mysqli->prepare($sql)) {
        if ($isdr) {
  				$stmt->bind_param('ssi', $drcode, $s3f2, $uid);
  			} else {
				  $stmt->bind_param('isi', $s3f1u, $s3f2, $uid);
  			}
				$stmt->execute();
				$stmt->store_result();
				$stmt->fetch();
				$myObj->a = "success";
				$myObj->b = "";
				$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
				echo $r;die();
			} else { echo $error500;die(); }
    } elseif ($w == "4") {
      // step 4.
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
      } else {
        $myObj->b = "لطفا عکس خود را وارد کنید";
        $r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
        echo $r;die();
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
    } elseif ($w == "5") {
			// step 5
			if ($isdr) {
				$sql = "SELECT username, fname, name, email, phone, gender, picture, scode, ncode, bday, iban, salary, drphone, province, city, addr, pcode FROM users WHERE id = ?";
			} else {
				$sql = "SELECT username, fname, name, email, phone, gender, picture, scode, ncode, bday, iban, salary, edu, province, city, addr, pcode FROM users WHERE id = ?";
			}
      if ($stmt = $mysqli->prepare($sql)) {
      	$stmt->bind_param('i', $uid);
      	$stmt->execute();
      	$stmt->store_result();
				if ($isdr) {
					$stmt->bind_result($username, $fname, $name, $email, $phone, $gender, $picture, $scode, $ncode, $bday, $iban, $salary, $drphone, $province, $city, $addr, $pcode);
				} else {
					$stmt->bind_result($username, $fname, $name, $email, $phone, $gender, $picture, $scode, $ncode, $bday, $iban, $salary, $edu, $province, $city, $addr, $pcode);
				}
      	$stmt->fetch();
				if ($isdr) {
					$are = array($username, $fname, $name, $email, $gender, $picture);
				} else {
					$are = array($username, $fname, $name, $email, $gender, $picture);
				}
        foreach ($are as $key => $value) {
            if (empty($value)) {
               echo $error500;die();
            }
        }
        $wiz = 1;
        $sql = "UPDATE users SET wizard = ? WHERE id = ?";
        if ($stmt2 = $mysqli->prepare($sql)) {
            $stmt2->bind_param('ii', $wiz, $uid);
            $stmt2->execute();
            $stmt2->store_result();
            $stmt2->fetch();
        }

        $myObj->a = "success";
        $myObj->b = "";
        $r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
        echo $r;die();
      }
    } else { echo $error500;die(); }
	}
}

////////////////////////////////////
  if (!empty($_POST['p'])) $page = $_POST['p'] - 1;
  if (!filter_var($page, FILTER_VALIDATE_INT) || !is_numeric($page)) $page = 0;
  $sql = "SELECT u.id, u.fname, u.name, r.date_time FROM users AS u INNER JOIN reservation AS r ON r.did = ? WHERE u.id = r.uid LIMIT 5 OFFSET ?";
  ///////////////////////////
  if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param('ii', $uid, $page);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($uid, $ufname, $uname, $rdate);
    $row_ind = ($page*5)+1;
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
