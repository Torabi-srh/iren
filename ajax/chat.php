<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/assets/functions.php');
$mysqli = isset($mysqli) ? $mysqli : Connection();

if (isset($_POST['chat'])) {
    $getChatName = "SELECT users.username, users.picture, chat_users.cid FROM chat_users INNER JOIN users ON users.id = chat_users.uid AND users.id != ? INNER JOIN chat ON chat_users.cid = chat.id WHERE chat_users.cid IN (SELECT cid FROM chat_users WHERE uid = ?)";
    if ($stmt = $mysqli->prepare($getChatName)) {
        $parm = 1;
        $stmt->bind_param('dd', $parm, $parm);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($username, $pic, $cid);
        while ($stmt->fetch()) {
            echo "<a class=\"contact-list online c-contact\" id=\"c-$cid\" href=\"javascript:void(0)\">";
            echo "<li class=\"popup-item\">";
            echo "<div class=\"macro\">";
            echo "<div class=\"avatar\" style=\"padding:0px 0px 0px 10px !important\">";
            echo "<img class=\"\" src=\"$pic\">";
            echo "</div>";
            echo "<div class=\"text text-r\">";
            echo "<p>$username</p>";
            echo "</div>";
            echo "</div>";
            echo "</li>";
            echo "</a>";
        }
    }
    /*
     */

} elseif (!empty($_POST['msg'])) {
    $msgid = TextToDB($_POST['msg']);
    if (!filter_var($msgid, FILTER_VALIDATE_INT)) {
        die();
    }
    $userID = 1;
    $getMsg = "SELECT m.msg, pyear(m.msg_date),pmonth(m.msg_date), pday(m.msg_date), IF(c.uid = ?,'me', 'you'), u.picture, u.username FROM msg AS m INNER JOIN chat_users AS c ON c.cid = ? INNER JOIN users AS u ON u.id = c.uid WHERE m.cid = c.id ORDER BY m.msg_date;";
    if ($stmt = $mysqli->prepare($getMsg)) {
        $stmt->bind_param('dd', $userID, $msgid);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($msg, $msg_date_y, $msg_date_m, $msg_date_d, $who, $pic, $username);
        $res = array();
        while ($stmt->fetch()) {
            array_push($res, array($who, $msg, "$msg_date_y/$msg_date_m/$msg_date_d", $pic, $username));
        }
        echo json_encode($res);
    }
} elseif (!empty($_POST['send']) && !empty($_POST['cid'])) {
    $msg = TextToDB($_POST['send']);
    $cid = TextToDB($_POST['cid']);
    $userID = 1;
    $last_id = 0;
    $sql = "INSERT INTO msg (cid, msg) VALUES (?, ?)";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param('ds', $cid, $msg);
        $stmt->execute();

        $last_id = $stmt->insert_id;
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error; die();
    }

    $getMsg = "SELECT m.msg, pyear(m.msg_date),pmonth(m.msg_date), pday(m.msg_date), IF(c.uid = ?,'me', 'you'), u.picture, u.username FROM msg AS m INNER JOIN chat_users AS c ON c.cid = ? INNER JOIN users AS u ON u.id = c.uid WHERE m.id = ? ORDER BY m.msg_date;";

    if ($stmt = $mysqli->prepare($getMsg)) {
        $stmt->bind_param('ddd', $userID, $cid, $last_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($msg, $msg_date_y, $msg_date_m, $msg_date_d, $who, $pic, $username);
        $res = array();
        while ($stmt->fetch()) {
            array_push($res, array($who, $msg, "$msg_date_y/$msg_date_m/$msg_date_d", $pic, $username));
        }
        echo json_encode($res);
    }
} else {
    echo "NO";
}
?>
