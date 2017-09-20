<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/assets/functions.php');
$mysqli = isset($mysqli) ? $mysqli : Connection();
include("pages/header.php");head("");
?>
			<div class="row">
				<div class="panel panel-default">
					<div class="col-lg-8 col-md-8 col-sm-9 col-xs-12">
						<form id="posteditor">
								<!--<input name="editor1" id="editor1" placeholder="Click here to edit." />-->
								<div class="input-group" style="margin-top: 1%;">
									<span class="input-group-addon">Post</span>
									<input id="msg" type="text" class="form-control" name="msg" placeholder="titile">
								</div>
								<div class="input-group" style="margin-top: 1%;margin-bottom: 1%;">
									    <label class="control-label">Select File</label>
											<input id="input-1" type="file" class="file">
								</div>
								
								<div class="input-group" name="editor1" id="editor1" style="margin-bottom: 1%;">
									<span class="input-group-addon">Post</span>
									<input id="msg" type="text" class="form-control" name="msg" placeholder="Post to your blog">
								</div>
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
						<figure>
						  <img src="<?php echo "$upicture"; ?>">
						</figure>
					  </div>
						<div class="col-sm-6 col-md-8">
							<span class="label label-default pull-left no-rad"><i class="glyphicon glyphicon-comment"></i><?php echo "$pcmds"; ?></span>
							<span class="label label-default pull-left no-rad"><i class="glyphicon glyphicon-heart"></i><?php echo "$plikes"; ?></span>
							<h4>دکتر <?php echo "$pheader"; ?></h4>
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
					$stmt->bind_param('d', $page);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($cnt);
					$stmt->fetch();
					for ($cnti = 1; $cnti <= $cnt; $cnti++):
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
        								<a href="#home" aria-controls="home" role="tab"
        								   data-toggle="tab">پربازدید</a>
        							</li>
        							<li role="presentation">
        								<a href="#profile" aria-controls="profile" role="tab"
        								   data-toggle="tab">جدیدترین</a>
        							</li>
        							<li role="presentation">
        								<a href="#messages" aria-controls="messages" role="tab"
        								   data-toggle="tab">نظرات</a>
        							</li>
        						</ul>

        						<!-- Tab panes -->
        						<div class="tab-content">
        							<div role="tabpanel" class="tab-pane active" id="home">
        								<div class="tab-post-list">
        									<div class="tab-post-list-wrap clearfix">
        										<div class="tab-post-thumb pull-left">
        											<figure>
        												<a href="single.html">
        													<img src="assets/images/tmp/placehold.it.png"
        														 alt="Post thumb">
        												</a>
        											</figure>
        										</div>
        										<div class="tab-post-title">
        											<h6><a href="single.html">تست</a>
        											</h6>
        											<span>1396/5/23</span>
        										</div>
        									</div>
        									<div class="tab-post-list-wrap clearfix">
        										<div class="tab-post-thumb pull-left">
        											<figure>
        												<a href="single.html">
        													<img src="assets/images/tmp/placehold.it.png"
        														 alt="Post thumb">
        												</a>
        											</figure>
        										</div>
        										<div class="tab-post-title">
        											<h6><a href="single.html">تست 2</a>
        											</h6>
        											<span>1396/5/23</span>
        										</div>
        									</div>
        									<div class="tab-post-list-wrap clearfix">
        										<div class="tab-post-thumb pull-left">
        											<figure>
        												<a href="single.html">
        													<img src="assets/images/tmp/placehold.it.png"
        														 alt="Post thumb">
        												</a>
        											</figure>
        										</div>
        										<div class="tab-post-title">
        											<h6><a href="single.html">تست 3</a></h6>
        											<span>1396/5/23</span>
        										</div>
        									</div>
        								</div>
        							</div>
        							<div role="tabpanel" class="tab-pane" id="profile">
        								<div class="tab-post-list">
        									<div class="tab-post-list-wrap clearfix">
        										<div class="tab-post-thumb pull-left">
        											<figure>
        												<a href="single.html">
        													<img src="assets/images/tmp/placehold.it.png"
        														 alt="Post thumb">
        												</a>
        											</figure>
        										</div>
        										<div class="tab-post-title">
        											<h6><a href="single.html">تست 4</a>
        											</h6>
        											<span>1396/5/23</span>
        										</div>
        									</div>
        									<div class="tab-post-list-wrap clearfix">
        										<div class="tab-post-thumb pull-left">
        											<figure>
        												<a href="single.html">
        													<img src="assets/images/tmp/placehold.it.png"
        														 alt="Post thumb">
        												</a>
        											</figure>
        										</div>
        										<div class="tab-post-title">
        											<h6><a href="single.html">تست</a>
        											</h6>
        											<span>1396/5/23</span>
        										</div>
        									</div>
        									<div class="tab-post-list-wrap clearfix">
        										<div class="tab-post-thumb pull-left">
        											<figure>
        												<a href="single.html">
        													<img src="assets/images/tmp/placehold.it.png"
        														 alt="Post thumb">
        												</a>
        											</figure>
        										</div>
        										<div class="tab-post-title">
        											<h6><a href="single.html">تست 3</a></h6>
        											<span>1396/5/23</span>
        										</div>
        									</div>
        								</div>
        							</div>
        							<div role="tabpanel" class="tab-pane" id="messages">
        								<div class="tab-post-list">
        									<ul>
        										<li class="tab-post-list-wrap">
        											<a href="#">ناشناس</a>
        											<span>در</span>
        											<a href="#">تست</a>
        											<small>
        												<abbr title="30-04-2015">2 روزپیش</abbr>
        											</small>
        											<p>یک نظر...</p>
        										</li>
        										<li class="tab-post-list-wrap">
        											<a href="#">بیمار 1</a>
        											<span>در</span>
        											<a href="#">تست 2</a>
        											<small>
        												<abbr title="30-04-2015">12 ماه‌پیش</abbr>
        											</small>
        											<p>نظر</p>
        										</li>
        										<li class="tab-post-list-wrap">
        											<a href="#">بیمار 1</a>
        											<span>در</span>
        											<a href="#">تست 2</a>
        											<small>
        												<abbr title="30-04-2015">12 ماه‌پیش</abbr>
        											</small>
        											<p>نظر</p>
        										</li>
        									</ul>
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
