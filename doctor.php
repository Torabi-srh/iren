<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/functions.php");
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
$isdr = $log_check[1];

$mysqli = isset($mysqli) ? $mysqli : Connection();


	include("pages/header.php");head("d2");
   ?>
    <div class="row">
        <div class="panel panel-default">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div id="content">
					</div>

					<ul class="pagination" id="pagination">
						<?php
							if ($stmt = $mysqli->prepare("SELECT count(id) FROM reservation AS r WHERE r.did = ?")):
									$stmt->bind_param('i', $uid);
									$stmt->execute();
									$stmt->store_result();
									$stmt->bind_result($cnt);
									$stmt->fetch();
									for ($cnti = 1; $cnti <= ceil($cnt / 5); $cnti++):
						?>
							<li class="<?php echo (1 == $cnti ? "active" : ""); ?>"><a href="#" id="<?php echo "$cnti"; ?>"><?php echo "$cnti"; ?></a></li>
						<?php
							endfor;
							endif;
						?>
					</ul>
        </div>
			</div>
		</div>
<?php include("pages/footer.php"); ?>
