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
?>
<?php include("pages/header.php");head(""); ?>
    <div class="row">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <!--<ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>-->

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
          <div class="item active">
            <img class="banner-shop" src="http://placehold.it/250x250/ffffff/000000/?text=1" alt="test 1">
            <div class="carousel-caption">
              <h3>test header 1</h3>
              <p>test header 1!</p>
            </div>
          </div>

          <div class="item">
            <img class="banner-shop" src="http://placehold.it/250x250/ffffff/000000/?text=2" alt="test 2">
            <div class="carousel-caption">
              <h3>test header 2</h3>
              <p>test header 2!</p>
            </div>
          </div>

          <div class="item">
            <img class="banner-shop" src="http://placehold.it/250x250/ffffff/000000/?text=3" alt="test 3">
            <div class="carousel-caption">
              <h3>test header 3</h3>
              <p>test header 3!</p>
            </div>
          </div>

          <div class="item">
            <img class="banner-shop" src="http://placehold.it/250x250/ffffff/000000/?text=4" alt="test 4">
            <div class="carousel-caption">
              <h3>test header 3</h3>
              <p>test header 3!</p>
            </div>
          </div>

        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>

    <div class="wrap">
        <div class="menu">
            <div class="mini-menu">
                <ul>
                    <li class="sub">
                        <a href="#">برنامه‌ها</a>
                        <ul>
                           <li><a href="#">کاربردی</a></li>
                        </ul>
                    </li>
                    <li class="sub">
                        <a href="#">بازی‌ها</a>
                        <ul>
                           <li><a href="#">بازی</a></li>
                        </ul>
                    </li>
                    <li class="sub">
                        <a href="#">بینورال‌ها</a>
                        <ul>
                            <li><a href="#">بینورال</a></li>
                        </ul>
                    </li>
                    <li class="sub">
                        <a href="#">آزمون‌ها</a>
                        <ul>
                        <li><a href="#">آزمون</a></li>
                        <li><a href="#">آزمون مخصوص مشاور</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

    <div class="items pull-left">
        <div class="layout">
			<section class="inner">
				<ul class="grid">
          <?php
            $conn = Connection() ;
            $sql = "SELECT product,price,picture FROM product LIMIT 9 OFFSET 0" ;
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  $product_name = $row['product'] ;
                  $product_picture = $row['picture'];
                  $product_price = $row['price'] ;

                  $html_to_show = "<li class=\"grid-tile\">
        						<div class=\"item\">
        							<div class=\"item-img\" style=\" background-image: url('$product_picture'); background-size: contain;\"></div>
        							<div class=\"item-pnl\">
        								<div class=\"pnl-wrapper\">
        									<div class=\"pnl-description\">
        										<span class=\"pnl-label\">{$product_name}</span>
        										<span class=\"pnl-price\">{$product_price}</span>
        									</div>
        									<div class=\"pnl-favorites\">
        										<div class=\"pnl-ic-wrapper\">
        											<span class=\"pnl-ic\"><svg version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" viewBox=\"0 0 32 32\" style=\"enable-background:new 0 0 32 32;\" xml:space=\"preserve\"><path d=\"M22.6,6.5c-2.9,0-5.4,1.7-6.6,4.1c-1.2-2.4-3.7-4.1-6.6-4.1C5.3,6.5,2,9.8,2,13.9C2,23.7,15.8,29,15.8,29S30,23.6,30,13.9C30,9.8,26.7,6.5,22.6,6.5L22.6,6.5z\"></path></svg></span>
        										</div>
        									</div>
        									<div class=\"pnl-tocart\">
        										<div class=\"pnl-ic-wrapper\">
        											<span class=\"pnl-ic\"><svg version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" viewBox=\"0 0 32 32\" style=\"enable-background:new 0 0 32 32;\" xml:space=\"preserve\"><g><path d=\"M25.4,29H6.6c-1.7,0-3-1.4-2.8-2.9l1.9-13.8C5.9,11,6.6,10,8,10h16c1.4,0,2.1,1,2.3,2.3l1.9,13.8 C28.4,27.6,27.1,29,25.4,29z\"></path><path d=\"M10.6,12.7V8.4C10.6,5.4,13,3,16,3h0c3,0,5.4,2.4,5.4,5.4v4.3\"></path></g></svg></span>
        										</div>
        									</div>
        								</div>
        							</div>
        						</div>
        					</li>";

                  echo $html_to_show ;
                }
              }
          ?>
				</ul>
			</section>
		</div>
    </div>
    <ul class="pagination">
      <li class="active"><a href="#">1</a></li>
      <li><a href="#">2</a></li>
      <li><a href="#">3</a></li>
      <li><a href="#">4</a></li>
    </ul>

</div>
<?php include("pages/footer.php"); ?>
