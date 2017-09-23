<?php 
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/functions.php");
  $log_check = login_check();
  include("pages/header.php");head("");
?>
      <div class="row">
        <div class="col-*-*">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="row margin-bot-2">
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">شماره شبا</span>
                    <input id="shaba" type="text" class="form-control number-text" name="msg" placeholder="IR890170000000108847184007">
                  </div>
                </div>
                <div class="col-md-6">
                  <button type="button" class="btn btn-success bottom-mali float-left">افزودن</button>
                  <div class="input-group">
                     <span class="input-group-btn">
                          <span class="input-group-addon">اعتبار</span>
                     </span>
                     <input type="text" class="form-control input-mali number-text" placeholder="100000 ريال">
                  </div>
                </div>
              </div>
              <div class="row margin-bot-2">
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">هزینه یک ساعت مشاوره</span>
                    <input id="price" type="text" class="form-control number-text small-inv" name="msg" placeholder="8000 ريال">
                  </div>
                </div>
                <div class="col-md-6">
                   <div class="form-group">
                     <div class="col-sm-10">
                       <p class="form-control-static">100 ريال</p>
                     </div>
                     <label class="control-label col-sm-2" style="padding-top: 7px;" for="email">موجودی:</label>
                   </div>
                </div>
              </div>
              <div class="row">
                <table class="table table-striped table-condensed">
                  <thead>
                  <tr>
                      <th>رسید</th>
                      <th>تاریخ</th>
                      <th>مبلغ</th>
                  </tr>
              </thead>
              <tbody>
                <tr>
                    <td><a href="#">علی علیزاده</a></td>
                    <td>25/5/1396</td>
                    <td><span class="label label-success">+1000 ريال</span></td>
                </tr>
                <tr>
                  <td><a href="#">علی علیزاده</a></td>
                  <td>25/5/1396</td>
                  <td><span class="label label-danger">-500 ريال</span></td>
                </tr>
                <tr>
                  <td><a href="#">علی علیزاده</a></td>
                  <td>25/5/1396</td>
                  <td><span class="label label-danger">-500 ريال</span></td>
                </tr>
              </tbody>

            </table>

                <ul class="pagination">
                  <li class="active"><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">4</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php include("pages/footer.php"); ?>