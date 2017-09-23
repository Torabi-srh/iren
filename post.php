<?php
if (empty($_GET['id'])) {
	redirect("timeline.php");die();
} else {
	$pid = $_GET['id'];
	if (!filter_var($pid, FILTER_VALIDATE_INT) || !is_numeric($pid)) { redirect("timeline.php");die(); }
}
include_once($_SERVER['DOCUMENT_ROOT'].'/assets/functions.php');

$log_check = login_check() ;
if ($log_check === false) {
	saferedirect("login.php");
} else { 
	if($log_check[0] === false) {
		redirect("login.php");
	} 
}

$mysqli = isset($mysqli) ? $mysqli : Connection();
$sql = "SELECT p.id, p.views, p.likes, p.header, p.image, txt, p.p_date, u.username, u.picture,(SELECT SUM(pc.id) FROM post_comments AS pc WHERE pc.pid = p.id) FROM posts AS p INNER JOIN users AS u ON u.id = p.publisher WHERE p.id = ? ORDER BY p.p_date";
if ($stmt = $mysqli->prepare($sql)) {
	$pid = $mysqli->real_escape_string($pid);
	$stmt->bind_param('d', $pid);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($pid, $pviews, $plikes, $pheader, $pimage, $txt, $pp_date, $uusername, $upicture, $pcmds);
	$stmt->fetch();
}
include("pages/header.php");head(""); ?>
      <!-- section 3 -->
			<div class="well"> 
        <div class="row">
             <div class="col-md-12">
                 <div class="pull-left col-md-4 col-xs-12 thumb-contenido"><img class="center-block img-responsive" src='<?php echo "$upicture"; ?>' /></div>
                 <div class="">
                     <h1  class="hidden-xs hidden-sm"><?php echo "$pheader"; ?></h1>
                     <hr>
                     <small><?php echo "$pp_date"; ?></small><br>
                     <small><strong>دکتر <?php echo "$uusername"; ?></strong></small>
                     <hr>
                     <p class="text-justify">
					<?php echo "$txt"; ?>
					
				 </p></div>
             </div>
        </div>
				
				
    </div>
			<div class="row">
				<div class="panel panel-default">
					<div class="col-md-12">
							<div class="row">
								<div class="widget-area no-padding blank">
										<div class="status-upload">
											<form>
												<textarea id="comment-text" placeholder="Comment" ></textarea>
												<button type="submit" id="comment-submit" class="btn btn-success green pull-left"><i class="fa fa-share"></i> Send</button>
											</form>
										</div><!-- Status Upload  -->
								</div><!-- Widget Area -->
							</div>
					</div>
			<div class="row">
						<div class="col-md-12">
							<h2 class="page-header">Comments</h2>
								<section class="comment-list">
									<!-- First Comment -->
									<?php
								$sql = "SELECT pc.comment, pc.c_date, u.username, u.picture FROM post_comments AS pc INNER JOIN users AS u ON u.id = pc.uid WHERE pc.pid = ?";
				if ($stmt = $mysqli->prepare($sql)):
					$stmt->bind_param('d', $page);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($pccomment, $pcc_date, $uusername, $upicture);
					while ($stmt->fetch()):
			?>
				<article class="row">
					<div class="col-md-2 col-sm-2 hidden-xs">
						<figure class="thumbnail">
							<img class="img-responsive" src="<?php echo "$upicture"; ?>" />
							<figcaption class="text-center"><?php echo "$uusername"; ?></figcaption>
						</figure>
					</div>
					<div class="col-md-10 col-sm-10">
						<div class="panel panel-default arrow left">
							<div class="panel-body">
								<header class="text-left">
									<div class="comment-user"><i class="fa fa-user"></i> <?php echo "$uusername"; ?></div>
									<time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i><?php echo "$pcc_date"; ?></time>
								</header>
								<div class="comment-post">
									<p>
										<?php echo "$pccomment"; ?>
									</p>
								</div>
							</div>
						</div>
					</div>
				</article>
			<?php		
					endwhile;
				endif;
			?>
									
									
								</section>
						</div>
					</div>
				</div>
			</div>
      <!-- section 3 -->
      <?php include("pages/footer.php"); ?>