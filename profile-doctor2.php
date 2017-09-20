<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/telephaty/assets/functions.php");
	include("pages/header.php");head("d2");
	$log_check = login_check() ;
  if ($log_check === false) {
    saferedirect("login.php") ;
  } else {
    if($log_check[0] === false) {
      saferedirect("login.php") ;
    }
  }
   ?>
    <div class="row">
        <div class="panel panel-default">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <article>
            <div class="row">
              <div class="col-sm-6 col-md-4">
                <figure>
                  <img src="assets/images/tmp/placehold.it2.png">
                </figure>
              </div>
              <div class="col-sm-6 col-md-8">
                <span class="label label-default pull-left"><i class="glyphicon glyphicon-comment"></i>50</span>
                <h4>دکتر دکتریان</h4>
                <p>متن ارتیکل درباره‌ی روانشناسی.</p>
                <section class="pull-left">
                  <i class="glyphicon glyphicon-user"></i>دکتر دکتریان
                  <i class="glyphicon glyphicon-calendar"></i>1396/5/23
                  <i class="glyphicon glyphicon-eye-open"></i>10000
                  <a href="post.php" class="btn btn-default btn-sm pull-left">بیشتر ... </a>
                </section>
              </div>
            </div>
          </article>
          <article>
            <div class="row">
              <div class="col-sm-6 col-md-4">
                <figure>
                  <img src="assets/images/tmp/placehold.it2.png">
                </figure>
              </div>
              <div class="col-sm-6 col-md-8">
                <span class="label label-default pull-left"><i class="glyphicon glyphicon-comment"></i>50</span>
                <h4>دکتر</h4>
                <p>متن ارتیکل درباره‌ی روانشناسی.</p>
                <section class="pull-left">
                  <i class="glyphicon glyphicon-user"></i>دکتر
                  <i class="glyphicon glyphicon-calendar"></i>1396/5/23
                  <i class="glyphicon glyphicon-eye-open"></i>10000
                  <a href="post.php" class="btn btn-default btn-sm pull-left">بیشتر ... </a>
                </section>
              </div>
            </div>
          </article>
          <article>
            <div class="row">
              <div class="col-sm-6 col-md-4">
                <figure>
                  <img src="assets/images/tmp/placehold.it2.png">
                </figure>
              </div>
              <div class="col-sm-6 col-md-8">
                <span class="label label-default pull-left"><i class="glyphicon glyphicon-comment"></i>50</span>
                <h4>دکتر</h4>
                <p>متن ارتیکل درباره‌ی روانشناسی.</p>
                <section class="pull-left">
                  <i class="glyphicon glyphicon-user"></i>دکتر
                  <i class="glyphicon glyphicon-calendar"></i>1396/5/23
                  <i class="glyphicon glyphicon-eye-open"></i>10000
                  <a href="post.php" class="btn btn-default btn-sm pull-left">بیشتر ... </a>
                </section>
              </div>
            </div>
          </article>

          <ul class="pagination">
            <li class="active"><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
          </ul>
        </div>
			</div>
		</div>
<?php include("pages/footer.php"); ?>
