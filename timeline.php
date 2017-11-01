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

$er = "";
if (isset($_POST['submit-post'])) {
	$msg = "";
	$input1 = "";
	$header = "";
	if (!empty($_POST['msg'])) {
		$msg = $mysqli->real_escape_string($_POST['msg']);
	} else {
		$er = "لطفا متن پست خود را وارد کنید";
	}
	if (!empty($_POST['p-header'])) {
		$header = TextToDB($_POST['p-header']);
	} else {
		$er = "لطفا تیتر پست را وارد کنید";
	}

	$image = "";
	if (!empty($_FILES['input-1'])) {
		$image = new Bulletproof\Image($_FILES);

		// Pass a custom name, or leave it if you want it to be auto-generated
		// $image->setName($name);

		// define the min/max image upload size (size in bytes)
		$image->setSize(0, 1000000);

		// define allowed mime types to upload
		$image->setMime(array('jpg', 'png', 'jpeg'));

		// set the max width/height limit of images to upload (limit in pixels)
		//$image->setDimension($width, $height);

		// pass name (and optional chmod) to create folder for storage
		$image->setLocation(UPLOAD_POST, $optionalPermission = "");
	} else {
		$er = "لطفا عکس پست را انتخاب کنید";
	}
	if (empty($er)) {

		if($image["input-1"]) {
			$upload = $image->upload();

			if($upload) {
				$im_g = $image->getFullPath();
				$zero = 0;

				if ($stmt = $mysqli->prepare("INSERT INTO posts(publisher, views, likes, header, image, txt) VALUES(?, ?, ?, ?, ?, ?)")) {
					$stmt->bind_param('iiisss', $uid, $zero, $zero, $header, $im_g, $msg);
					$stmt->execute();
					$er = "پست با موفقیت فرستاده شد";
				}

			}else{
				$er = $image["error"];
			}
		}
	}
}

include("pages/header.php");head("");
?>
<?php if (isset($_POST['submit-post'])): ?>
  <div id="could_pass">
    <?php
        echo "<div class=\"alert alert-info\" id=23>
      <strong>{$er}</strong>
    </div><br />" ;
    ?>
  </div>
  <?php endif; ?>

			<div class="row">
				<div class="panel panel-default">
					<div class="col-lg-8 col-md-8 col-sm-9 col-xs-12">
						<form id="posteditor" action="" method="post" enctype="multipart/form-data">
							<!--<input name="editor1" id="editor1" placeholder="Click here to edit." />-->
							<input type="hidden" id="msg" name="msg" value="">
							<div class="input-group" style="margin-top: 1%;">
								<span class="input-group-addon">Post</span>
								<input id="header" type="text" class="form-control" name="p-header" placeholder="titile">
							</div>
							<div class="input-group" style="margin-top: 1%;margin-bottom: 1%;">
									<label class="control-label">Select File</label>
									<input id="input-1" name="input-1" type="file" class="file">
							</div>

							<div class="input-group" name="editor1" id="editor1" style="margin-bottom: 1%;">
								<span class="input-group-addon">Post</span>
								<input id="msgpost" type="text" class="form-control" name="msgpost" placeholder="Post to your blog">
							</div>

							<input type="submit" class="form-control" name="submit-post" onclick="document.getElementById('msg').value = editor.getData();" value="Post to your blog">

						</form>
					</div>
				</div>
			</div>
      <div class="row">
        <div class="panel panel-default">
			<div class="col-lg-8 col-md-8 col-sm-9 col-xs-12">
			<?php
				$page = 0;
				if (!empty($_GET['p'])) $page = $_GET['p'] - 1;
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

			  <ul class="pagination">
				<?php
					if ($stmt = $mysqli->prepare("SELECT count(id) FROM posts")):
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($cnt);
					$stmt->fetch();
					for ($cnti = 1; $cnti <= ceil($cnt / 5); $cnti++):
				?>
					<li class="<?php echo ($page == $cnti ? "active" : ""); ?>"><a href="<?php echo "?p=$cnti"; ?>"><?php echo "$cnti"; ?></a></li>
				<?php
					endfor;
					endif;
				?>
			  </ul>
			</div>
        <!-- right side -->
        <div class="col-md-4">
        			<div class="tab-row">
        			    <!-- <h2 class="title-widget-sidebar text-capitalize">Populer Posts</h2> -->
        				<div class="befor-widget">
        					<div class="populat-post-tab">
        					<!-- Nav tabs -->
        						<ul class="nav nav-tabs" role="tablist">
        							<li role="presentation" class="active">
        								<a href="#top" aria-controls="top" role="tab"
        								   data-toggle="tab">پربازدید</a>
        							</li>
        							<li role="presentation">
        								<a href="#new" aria-controls="new" role="tab"
        								   data-toggle="tab">بیشترین لایک شده</a>
        							</li>
        							<li role="presentation">
        								<a href="#comment" aria-controls="comment" role="tab"
        								   data-toggle="tab">نظرات</a>
        							</li>
        						</ul>

        						<!-- Tab panes -->
        						<div class="tab-content">
        							<div role="tabpanel" class="tab-pane active" id="top">
        								<div class="tab-post-list">
											<?php
												$sql = "SELECT p.id, p.header, p.image, LEFT(txt, 40), p.p_date FROM posts AS p ORDER BY p.views LIMIT 3";
												if ($stmt = $mysqli->prepare($sql)):
													$stmt->execute();
													$stmt->store_result();
													$stmt->bind_result($pid, $pheader, $pimage, $txt, $pp_date);
													while ($stmt->fetch()):
											?>
        									<div class="tab-post-list-wrap clearfix">
        										<div class="tab-post-thumb pull-left">
        											<div>
        												<a href="post.php?id=<?php echo "$pid"; ?>">
        													<img src="<?php echo "$pimage"; ?>"
        														 alt="<?php echo "$pheader"; ?>" width="200" height="200">
        												</a>
        											</div>
        										</div>

        										<div class="tab-post-title">
        											<h6><a href="post.php?id=<?php echo "$pid"; ?>"><?php echo "$pheader"; ?></a>
        											</h6>
													<p><?php echo "$txt"; ?></p>
        											<span><?php echo "$pp_date"; ?></span>
        										</div>
        									</div>
											<?php endwhile;endif; ?>
        								</div>
        							</div>
        							<div role="tabpanel" class="tab-pane" id="new">
        								<div class="tab-post-list">
        									<?php
												$sql = "SELECT p.id, p.header, p.image, LEFT(txt, 40), p.p_date FROM posts AS p ORDER BY p.likes LIMIT 3";
												if ($stmt = $mysqli->prepare($sql)):
													$stmt->execute();
													$stmt->store_result();
													$stmt->bind_result($pid, $pheader, $pimage, $txt, $pp_date);
													while ($stmt->fetch()):
											?>
        									<div class="tab-post-list-wrap clearfix">
        										<div class="tab-post-thumb pull-left">
        											<div>
        												<a href="post.php?id=<?php echo "$pid"; ?>">
        													<img src="<?php echo "$pimage"; ?>"
        														 alt="<?php echo "$pheader"; ?>" width="200" height="200">
        												</a>
        											</div>
        										</div>

        										<div class="tab-post-title">
        											<h6><a href="post.php?id=<?php echo "$pid"; ?>"><?php echo "$pheader"; ?></a>
        											</h6>
													<p><?php echo "$txt"; ?></p>
        											<span><?php echo "$pp_date"; ?></span>
        										</div>
        									</div>
											<?php endwhile;endif; ?>
        								</div>
        							</div>
        							<div role="tabpanel" class="tab-pane" id="comment">
        								<div class="tab-post-list">
        									<?php
												$sql = "SELECT p.id, p.header, p.image, LEFT(txt, 40), p.p_date, IFNULL(COUNT(pc.id), 1) AS counte FROM posts AS p LEFT JOIN post_comments AS pc ON pc.pid = p.id GROUP BY p.id ORDER BY counte LIMIT 3";
												if ($stmt = $mysqli->prepare($sql)):
													$stmt->execute();
													$stmt->store_result();
													$stmt->bind_result($pid, $pheader, $pimage, $txt, $pp_date, $__cnt__);
													while ($stmt->fetch()):
											?>
        									<div class="tab-post-list-wrap clearfix">
        										<div class="tab-post-thumb pull-left">
        											<div>
        												<a href="post.php?id=<?php echo "$pid"; ?>">
        													<img src="<?php echo "$pimage"; ?>"
        														 alt="<?php echo "$pheader"; ?>" width="200" height="200">
        												</a>
        											</div>
        										</div>

        										<div class="tab-post-title">
        											<h6><a href="post.php?id=<?php echo "$pid"; ?>"><?php echo "$pheader"; ?></a>
        											</h6>
													<p><?php echo "$txt"; ?></p>
        											<span><?php echo "$pp_date"; ?></span>
        										</div>
        									</div>
											<?php endwhile;endif; ?>
        								</div>
        							</div>
        						</div>
        					</div>
        				</div>
        			</div>
        		</div>
        <!-- right side -->
      </div>
      </div>
      <?php include("pages/footer.php"); ?>
