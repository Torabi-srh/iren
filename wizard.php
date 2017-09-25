<?php include("pages/header.php");head(""); ?>
      <!-- section 3 -->
      <style>
            .container {
                  line-height: 3.429;     
            }           
/* Hiding the checkbox, but allowing it to be focused */
.badgebox
{
    opacity: 0;
}
label.btn {
	white-space: normal!important;
}
.badgebox + .badge
{
    float: left;
    
    /* Move the check mark away when unchecked */
    text-indent: -999999px;
    /* Makes the badge's width stay the same checked and unchecked */
    width: 27px;
}

.badgebox:focus + .badge
{
    /* Set something to make the badge looks focused */
    /* This really depends on the application, in my case it was: */
    
    /* Adding a light border */
    box-shadow: inset 0px 0px 5px;
    /* Taking the difference out of the padding */
}

.badgebox:checked + .badge
{
    /* Move the check mark back when checked */
	text-indent: 0;
}
.child {
    display: inline-block;
    background:#E2E2E2;
    margin:10px 0 0 2%;
    flex-grow: 1;   
    width: calc(100% * (1/4) - 10px - 1px);
}
      </style>
      <div class="row">
            <div class="wizard">
                <div class="wizard-inner  color-full">
                    <div class="connecting-line"></div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="ویژگی های کلی بیمار">
                                <span class="round-tab">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="ویژگی های رفتاری بیمار">
                                <span class="round-tab">
                                    <i class="fa fa-puzzle-piece" aria-hidden="true"></i>
                                </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="ارزیابی های درمانگر">
                                <span class="round-tab">
                                    <i class="fa fa-id-card" aria-hidden="true"></i>
                                </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab" title="برنامه درمانی">
                                <span class="round-tab">
                                    <i class="fa fa-tasks" aria-hidden="true"></i>
                                </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="ملاحظات کلی">
                                <span class="round-tab">
                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
                    <div class="tab-content" style="padding: 0% 5% 5% 5%;">
                        <div class="tab-pane active" role="tabpanel" id="step1">
                           <h3><span class="fa fa-pencil">
                                                  </span>اطلاعات ثبت‌نام</h3>
                           <p class="plain-text">اطلاعات شخصی شما به صورت محرمانه نگهداری خواهد شد.</p>
                           <hr>
                           <div class="form-group">
                               <div class="col-md-7">
                                   <input class="form-control" name="company_name" value="" type="text">
                               </div>
                               <label class="col-md-4 control-label">نام</label>
                           </div>
                           <div class="form-group">
                              <div class="col-md-7">
                                   <input class="form-control" name="company_family" value="" type="text">
                               </div>
                               <label class="col-md-4 control-label">نام خانوادگی</label>
                           </div>
                           <div class="form-group">
                               <div class="col-md-7">
                                   <input class="form-control" name="" value="" dir="ltr" disabled="" type="text">
                               </div>
                               <label class="col-md-4 control-label">پست الکترونیک</label>
                           </div>
                           <div class="form-group">
                               <div class="col-md-7">
                                   <input class="form-control" name="" value="" dir="ltr" disabled="" type="text">
                               </div>
                               <label class="col-md-4 control-label">نام کاربری</label>
                           </div>
                           
                           <div class="form-group">
                               <div class="col-md-4 col-xs-12">
                                   <label>
                                       <input type="radio" name="optradio">مرد </label>
                                   <label>
                                       <input type="radio" name="optradio">زن </label>
                                   <label>
                                       <input type="radio" name="optradio">دیگر </label>
                               </div>
                               <label class="control-label col-md-2 col-xs-12">جنسیت</label>
                           </div>
                           <div class="form-group">
                               <div class="col-md-4 col-xs-12">
                                   <input name="host_national_id" value="" class="form-control" type="text">
                               </div>
                               <label class="control-label col-md-2 col-xs-12">شماره ملی</label>
                           </div>
                           <div class="form-group">
                               <div class="col-md-4 col-xs-12">
                                   <input name="host_certificate_id" value="" class="form-control" type="text">
                               </div>
                               <label class="control-label col-md-2 col-xs-12">شماره شناسنامه</label>
                           </div>
                           <div class="form-group">
                               <div class="col-md-4 col-xs-12">
                                   <input name="host_date" value="" class="form-control datepicker" type="text">
                               </div>
                               <label class="control-label col-md-2 col-xs-12">تاریخ تولد</label>
                           </div>
                       
                           <!--</div>  -->
                           <ul class="list-inline pull-left">
                               <li>
                                   <button type="button" class="btn btn-primary next-step">ذخیره و ادامه</button>
                               </li>
                           </ul>
                       </div>
                        <div class="tab-pane" role="tabpanel" id="step2">
                            <h3><span class="fa fa-pencil">
                                                  </span>اطلاعات مالی</h3>
                           <p class="plain-text">اطلاعات شخصی شما به صورت محرمانه نگهداری خواهد شد.</p>
                           <hr>
                           <div class="form-group">
                               <div class="col-md-7">
                                   <input class="form-control" name="company_name" value="" type="text">
                               </div>
                               <label class="col-md-4 control-label">شماره شبا</label>
                           </div>
                           <div class="form-group">
                              <div class="col-md-7">
                                   <input class="form-control" name="company_family" value="" type="text">
                              </div>
                              <label class="col-md-4 control-label">هزینه‌مشاوره</label>
                           </div>
                            <ul class="list-inline pull-left">
                                <li><button type="button" class="btn btn-default prev-step">صفحه قبل</button></li>
                                <li><button type="button" class="btn btn-primary next-step">ذخیره و ادامه</button></li>
                            </ul>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="step3">
                            <form class="form-horizontal">
                              <h3></h3>
                              <p>اطلاعات‌تماس</p>
                              
                              <div class="form-group">
                                 <label for="comment">شماره‌نظام‌روانشناسی</label>
                                 <textarea class="form-control" rows="5" id="comment"></textarea>
                              </div>
                              <div class="form-group">
                                <label for="comment">تخصص‌ها</label>
                              <div class="row">
                                    <label for="p-1" class="btn btn-default child">استرس <input type="checkbox" id="p-1" class="badgebox"><span class="badge">&check;</span></label>
                                    <label for="p-2" class="btn btn-default child">وسواس <input type="checkbox" id="p-2" class="badgebox"><span class="badge">&check;</span></label>
                                    <label for="p-3" class="btn btn-default child">روابط بین فردی <input type="checkbox" id="p-3" class="badgebox"><span class="badge">&check;</span></label>
                                    <label for="p-4" class="btn btn-default child">رابطه <input type="checkbox" id="p-4" class="badgebox"><span class="badge">&check;</span></label>
                                    <label for="p-5" class="btn btn-default child">اختلالات اضطرابی <input type="checkbox" id="p-5" class="badgebox"><span class="badge">&check;</span></label>
                                    <label for="p-6" class="btn btn-default child">اختلالات شخصیت <input type="checkbox" id="p-6" class="badgebox"><span class="badge">&check;</span></label>
                                    <label for="p-7" class="btn btn-default child">افسردگی <input type="checkbox" id="p-7" class="badgebox"><span class="badge">&check;</span></label>
                                    <label for="p-8" class="btn btn-default child">خانواده <input type="checkbox" id="p-8" class="badgebox"><span class="badge">&check;</span></label>
                                    <label for="p-9" class="btn btn-default child">کنکور / مشاوره‌درسی <input type="checkbox" id="p-9" class="badgebox"><span class="badge">&check;</span></label>
                                    <label for="p-10" class="btn btn-default child">مسائل جنسی <input type="checkbox" id="p-10" class="badgebox"><span class="badge">&check;</span></label>
                                    <label for="p-11" class="btn btn-default child">کنترل خشم <input type="checkbox" id="p-11" class="badgebox"><span class="badge">&check;</span></label> 
                              </div>
                              <div class="row">
                                    <div class="col-md-5" style="display: inline-flex;float: right;margin-top: 10px;">
                                           <input class="form-control" id="p-n" placeholder="تخصص" required="" type="text">
							 <button type="button" class="btn btn-success" style="margin-right: 10px;" id="p-b">
								<i class="fa fa-plus" aria-hidden="true"></i>
                                           </button>
                                    </div>
                              </div>
                              </div>
                              <div class="form-group">
                                <label for="comment">رویکردها</label>
                                    <div class="row">
                                          <label for="m-1" class="btn btn-default child">درمان شناختی رفتاری <input type="checkbox" id="m-1" class="badgebox"><span class="badge">&check;</span></label>
                                          <label for="m-2" class="btn btn-default child">درمان روان کاوی <input type="checkbox" id="m-2" class="badgebox"><span class="badge">&check;</span></label>
                                          <label for="m-3" class="btn btn-default child">درمان روان پوشی <input type="checkbox" id="m-3" class="badgebox"><span class="badge">&check;</span></label>
                                          <label for="m-4" class="btn btn-default child">درمان ترنس پرسنال <input type="checkbox" id="m-4" class="badgebox"><span class="badge">&check;</span></label>
                                          <label for="m-5" class="btn btn-default child">درمان اگزیستانسیالیست <input type="checkbox" id="m-5" class="badgebox"><span class="badge">&check;</span></label>
                                          <label for="m-6" class="btn btn-default child">درمان زوج <input type="checkbox" id="m-6" class="badgebox"><span class="badge">&check;</span></label>
                                          <label for="m-7" class="btn btn-default child">درمان گروهی <input type="checkbox" id="m-7" class="badgebox"><span class="badge">&check;</span></label>
                                          <label for="m-8" class="btn btn-default child">درمان معنایی <input type="checkbox" id="m-8" class="badgebox"><span class="badge">&check;</span></label>
                                    </div>
                                    <div class="row">
                                          <div class="col-md-5" style="display: inline-flex;float: right;margin-top: 10px;">
                                                <input class="form-control" placeholder="رویکرد" required="" type="text">
  <button type="button" class="btn btn-success" style="margin-right: 10px;">
                                          <i class="fa fa-plus" aria-hidden="true"></i>
                                          </button>
                                          </div>
                                            </Div>
                              </div>
                            </form>
                            <ul class="list-inline pull-left">
                                <li><button type="button" class="btn btn-default prev-step">صفحه قبل</button></li>
                                <li><button type="button" class="btn btn-primary next-step">ذخیره و ادامه</button></li>
                            </ul>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="step4">
                            <h3>برنامه درمانی</h3>
                            <p>افزودن برنامه درمانی</p>
                            
                            <div class="form-group">
                               <label for="comment">هدف های درمان مورد توجه:</label>
                               <textarea class="form-control" rows="5" id="comment"></textarea>
                            </div>
                            
                            <div class="form-group">
                               <label for="comment">طرح و برنامه:</label>
                               <textarea class="form-control" rows="5" id="comment"></textarea>
                            </div>
                            
                            <ul class="list-inline pull-left">
                                <li><button type="button" class="btn btn-default prev-step">صفحه قبل</button></li>
                                <li><button type="button" class="btn btn-primary next-step">ذخیره و ادامه</button></li>
                            </ul>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="complete">
                            <h3>ملاحظات  کلی</h3>
                            <p>افزودن ملاحظات کلی</p>
                            <div class="form-group">
                               <label for="comment">آیا خطری برای خود یا دیگران دارد:<br/><small>اگر بله توضیح دهید</small></label>
                               <textarea class="form-control" rows="5" id="comment"></textarea>
                            </div>
                            
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>شماره</th>
                                        <th>نام دارو</th>
                                        <th>دوز</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="col-md-5">
                                            <h4><a href="#">1</a></h4>
                                        </td>
                                        <td class="col-md-3"><h5><strong>diaspam</strong></h5></td>
                                        <td class="col-md-1">
                                            100
                                        </td> 
                                        <td class="col-sm-1 col-md-1">
                                            <button type="button" class="btn btn-danger">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><input type="text" class="form-control" placeholder="نام دارو" required></td>
                                        <td><input type="text" class="form-control input-number" placeholder="دوز دارو" required></td>
                                        <td>
                                            <button type="button" class="btn btn-success">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>                        
                            <div class="form-group">
                              <label for="pwd">پیشرفت درمان:</label>
                              <label class="" style="margin-right: 10px;"><input type="radio" name="optradio">استثنایی</label>
                              <label class="" style="margin-right: 10px;"><input type="radio" name="optradio">ثابت</label>
                              <label class="" style="margin-right: 10px;"><input type="radio" name="optradio">آرام</label>
                              <label class="" style="margin-right: 10px;"><input type="radio" name="optradio">رها کرده</label>
                              <label class="" style="margin-right: 10px;"><input type="radio" name="optradio">پایدار</label>
                              <label class="" style="margin-right: 10px;"><input type="radio" name="optradio">نگهداری</label>
                            </div>
                            
                            <ul class="list-inline pull-left">
                                <li><button type="button" class="btn btn-default end-step">ذخیره</button></li>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    </div> 
            </div>

      
      </div>  
      <!-- section 3 -->
      <!-- section 2  -->  
      <!-- section 2  -->
      <?php include("pages/footer.php"); ?>