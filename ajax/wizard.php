<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/assets/functions.php');

$myObj = new StdClass;
$myObj->a = "danger";
$myObj->b = "<a href=\".\">صفحه خود را دوباره بارگذاری کنید.</a>";
$error500 = json_encode($myObj, JSON_UNESCAPED_UNICODE);

if (!is_ajax()) {
  // echo $error500;die();
}

$mysqli = isset($mysqli) ? $mysqli : Connection();
$log_check = login_check("wizard") ;
if ($log_check === false) {
	echo $error500;die();
} else {
	if($log_check[0] === false) {
		echo $error500;die();
	}
}

//Function to check if the request is an AJAX request
function is_ajax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

if (empty($_SESSION['user_id'])) {
	echo $error500;die();
} else {
	$uid = $mysqli->real_escape_string($_SESSION['user_id']);
}
$isdr = $log_check[1];

if (isset($_SESSION['wizard']) && $_SESSION['wizard'] == 1) {
	$myObj->a = "danger";
    if($log_check[0] === true && $log_check[1] === 1) {
      // dr dashbord !
		$myObj->b = "شما نیازی به تکمیل این اطلاعات ندارید لطفا به <a href=\"profile-doctor.php\">پروفایل</a> خود بروید.";
		$r = json_encode($myObj, JSON_UNESCAPED_UNICODE);
		echo $r;die();
    } elseif($log_check[0] === true && $log_check[1] === 0) {
			// us dashbord !
			$myObj->b = "شما نیازی به تکمیل این اطلاعات ندارید لطفا به <a href=\"profile-user.php\">پروفایل</a> خود بروید.";
			$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
			echo $r;die();
    }
    else {
      // there was some errros !
      echo $error500;die();
    }
}

if (isset($_POST["token"])) {
  $myObj->a = "warning";
	if (!empty($_POST['w'])) {
		$w = $_POST['w'];
		if ($w == "1") {
			if (!empty($_POST["s1fname"])) {
        $fname = $mysqli->real_escape_string($_POST["s1fname"]);
			} else {
				$myObj->b = "لطفا نام‌خانوادگی خود را وارد کنید.";
				$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
				echo $r;die();
			}
			if (!empty($_POST["s1name"])) {
					$name = $mysqli->real_escape_string($_POST["s1name"]);
			} else {
				$myObj->b = "لطفا نام خود را وارد کنید.";
				$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
				echo $r;die();
			}
			if (!empty($_POST["s1bday"])) {
					$bday = $mysqli->real_escape_string($_POST["s1bday"]);
			} else {
				$myObj->b = "لطفا تاریخ‌تولد خود را وارد کنید.";
				$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
				echo $r;die();
			}
			if (!empty($_POST["s1cid"])) {
					$cid = $mysqli->real_escape_string($_POST["s1cid"]);
			} else {
				$myObj->b = "لطفا شماره‌شناسنامه خود را وارد کنید.";
				$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
				echo $r;die();
			}
			if (!empty($_POST["s1nid"])) {
					$nid = $mysqli->real_escape_string($_POST["s1nid"]);
			} else {
				$myObj->b = "لطفا کدملی خود را وارد کنید.";
				$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
				echo $r;die();
			}
			if (!empty($_POST["s1gen"])) {
					$gen = $mysqli->real_escape_string($_POST["s1gen"]);
			} else {
				$myObj->b = "لطفا جنسیت خود را مشخص کنید.";
				$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
				echo $r;die();
			}
			$sql = "UPDATE users SET fname = ?, name = ?, bday = ?, scode = ?, ncode = ?, gender = ? WHERE id = ?";
			if ($stmt = $mysqli->prepare($sql)) {
				$stmt->bind_param('sssiiii', $fname, $name, $bday, $cid, $nid, $gen, $uid);
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
        $s2f1mal = $mysqli->real_escape_string($_POST["s2f1mal"]);
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
        $s2f2mal = $mysqli->real_escape_string($_POST["s2f2mal"]);
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
					$s3f1u = $mysqli->real_escape_string($_POST["s3f1u"]);
				} else {
					$myObj->b = "لطفا تحصیلات خود را وارد کنید.";
					$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
					echo $r;die();
				}
				if (isset($_POST["s3f2"])) {
					$s3f2 = $mysqli->real_escape_string($_POST["s3f2"]);
				} else {
					//$myObj->b = "لطفا تحصیلات خود را وارد کنید.";
					//$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
					//echo $r;die();
				}
        $sql = "UPDATE users SET edu = ?, bio = ? WHERE id = ?";

			} else {
        if (isset($_POST["takhasos"])) {
					$takhasos = $mysqli->real_escape_string($_POST["takhasos"]);
				} else {
					// $myObj->b = "لطفا تخصص خود را وارد کنید.";
					// $r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
					// echo $r;die();
				}
        if (isset($_POST["roykard"])) {
					$roykard = $mysqli->real_escape_string($_POST["roykard"]);
				} else {
					// $myObj->b = "لطفا رویکرد خود را وارد کنید.";
					// $r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
					// echo $r;die();
				}
        if (isset($_POST["drcode"])) {
					$drcode = $mysqli->real_escape_string($_POST["drcode"]);
				} else {
					$myObj->b = "لطفا شماره‌نظام‌روانشناسی خود را وارد کنید.";
					$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
					echo $r;die();
				}

				if (isset($_POST["s3f2"])) {
					$s3f2 = $mysqli->real_escape_string($_POST["s3f2"]);
				} else {
					//$myObj->b = "لطفا تحصیلات خود را وارد کنید.";
					//$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
					//echo $r;die();
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
      if (!$isdr) {
        if (isset($_POST["fileupload"])) {
          //if ($imger = Image_Upload($fileupload)) {
            //$myObj->b = $imger;
            //$r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
            //echo $r;die();
          //} <=== enable me
        } else {
          $myObj->b = "لطفا عکس خود را وارد کنید";
          $r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
          echo $r;die();
        }
        if (isset($_POST["s4phone"])) {
          $s4phone = $mysqli->real_escape_string($_POST["s4phone"]);
        } else {
          $myObj->b = "لطفا شماره خود را وارد کنید";
          $r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
          echo $r;die();
        }
        if (isset($_POST["s4province"])) {
          $s4province = $mysqli->real_escape_string($_POST["s4province"]);
        } else {
          $myObj->b = "لطفا استان خود را وارد کنید";
          $r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
          echo $r;die();
        }
        if (isset($_POST["s4city"])) {
          $s4city = $mysqli->real_escape_string($_POST["s4city"]);
        } else {
          $myObj->b = "لطفا شهر خود را وارد کنید";
          $r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
          echo $r;die();
        }
        if (isset($_POST["s4addr"])) {
          $s4addr = $mysqli->real_escape_string($_POST["s4addr"]);
        } else {
          $myObj->b = "لطفا آدرس خود را وارد کنید";
          $r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
          echo $r;die();
        }
        if (isset($_POST["s4post"])) {
          $s4post = $mysqli->real_escape_string($_POST["s4post"]);
        } else {
          $myObj->b = "لطفا کدپستی خود را وارد کنید";
          $r = json_encode($myObj, JSON_UNESCAPED_UNICODE );
          echo $r;die();
        }
        $sql = "UPDATE users SET phone = ?, province = ?, city = ?, addr = ?, pcode = ? WHERE id = ?";
      } else {
        $sql = "UPDATE users SET drcode = ?, bio = ? WHERE id = ?";
      }
      if ($stmt = $mysqli->prepare($sql)) {
        if ($isdr) {
          $stmt->bind_param('ssi', $drcode, $s3f2, $uid);
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
      $sql = "SELECT username, fname, name, email, phone, gender, picture, scode, ncode, bday, iban, salary, edu, province, city, addr, pcode FROM users WHERE id = ?";
      if ($stmt = $mysqli->prepare($sql)) {
      	$stmt->bind_param('i', $uid);
      	$stmt->execute();
      	$stmt->store_result();
      	$stmt->bind_result($username, $fname, $name, $email, $phone, $gender, $picture, $scode, $ncode, $bday, $iban, $salary, $edu, $province, $city, $addr, $pcode);
      	$stmt->fetch();
        $are = array($username, $fname, $name, $email, $phone, $gender, $picture, $scode, $ncode, $bday, $iban, $salary, $edu, $province, $city, $addr, $pcode);
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
	} else { echo $error500;die(); }
} else { echo $error500;die(); }

?>
