<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/assets/functions.php');


$mysqli = isset($mysqli) ? $mysqli : Connection();

$log_check = login_check() ;
if ($log_check === false) {
	redirect("login.php");die();
} else {
	if($log_check[0] === false) {
		redirect("login.php");die();
	}
}

if (empty($_SESSION['user_id'])) {
	redirect("login.php");die();
} else {
	$uid = TextToDB($_SESSION['user_id']);
}

  $page = 0;
  if (!empty($_POST['p'])) $page = $_POST['p'] - 1;
  if (!filter_var($page, FILTER_VALIDATE_INT) || !is_numeric($page)) $page = 0;
  $sql = "SELECT p.id, p.views, p.likes, p.header, p.image, LEFT(txt, 40), p.p_date, u.username, u.picture,(SELECT SUM(pc.id) FROM post_comments AS pc WHERE pc.pid = p.id) FROM posts AS p INNER JOIN users AS u ON u.id = p.publisher ORDER BY p.p_date LIMIT 5 OFFSET ?";
  if ($stmt = $mysqli->prepare($sql)):
    $stmt->bind_param('d', $page);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($pid, $pviews, $plikes, $pheader, $pimage, $txt, $pp_date, $uusername, $upicture, $pcmds);
    while ($stmt->fetch()):
?>
  <article>
    <div class="row">
      <div class="col-sm-6 col-md-4">
      <div>
        <img src="<?php echo "$pimage"; ?>" width="200" height="200">
      </div>
      </div>
      <div class="col-sm-6 col-md-8">
        <span class="label label-default pull-left no-rad"><i class="glyphicon glyphicon-comment"></i><?php echo "$pcmds"; ?></span>
        <span class="label label-default pull-left no-rad"><i class="glyphicon glyphicon-heart"></i><?php echo "$plikes"; ?></span>
        <h4><?php echo "$pheader"; ?></h4>
        <p><?php echo "$txt"; ?></p>
        <section class="pull-left">
          <i class="glyphicon glyphicon-user"></i>دکتر <?php echo "$uusername"; ?>
          <i class="glyphicon glyphicon-calendar"></i><?php echo jdate("Y/m/d", strtotime($pp_date)); ?>
          <i class="glyphicon glyphicon-eye-open"></i><?php echo "$pviews"; ?>
          <a href="post.php?id=<?php echo "$pid"; ?>" class="btn btn-default btn-sm pull-left">بیشتر ... </a>
        </section>
      </div>
    </div>
    </article>
<?php
    endwhile;
  endif;
?>
