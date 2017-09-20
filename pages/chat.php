<!-- chat -->
<div class="popup-box chat-popup" id="chat-box-popup" style="z-index: 10000;">
  <div class="col-*-*">
    <div class="popup-head">
      <!-- <div class="popup-head-right pull-right">
      </div> -->
      <div class="popup-head-left pull-left"><img class="upper-avatar"src="assets/images/users/no-image.jpg"> <a class="upper-chat"></a></div>
    </div>
    <div class="popup-messages">
      <div class="direct-chat-messages">
        <div class="frame">
            <ul id="chat-msg" style="top: 0px;overflow: hidden;"></ul>
        </div>
      </div>
    </div>
    <div class="popup-messages-footer">
      <textarea id="send_message" placeholder="پیام خود را بنویسید" rows="10" cols="40" name="message"></textarea>
      <button class="bg_none" id="send_message_btn" style="float: left;"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
      <div class="btn-footer">
        
      </div>
    </div>
  </div>
</div>

<!--moshavere menu-->
<div class="popup-box chat-popup" id="moshavere-popup" style="z-index: 10000;width: 400px;margin-right: -150px;height: 40px;min-height: 250px;">
  <div class="col-*-*">
    <!--<div class="popup-head">
      <div class="popup-head-left pull-left"><img class="upper-avatar"src="assets/images/users/no-image.jpg"> <a class="upper-chat"></a></div>
    </div>-->
    <div class="popup-messages-footer">
      <textarea id="status_message" placeholder="پیام خود را بنویسید" rows="10" cols="40" name="message"></textarea>
      <button class="bg_none" style="float: left;"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
      <div class="btn-footer">
        
      </div>
    </div>
  </div>
</div>
<!--moshavere menu-->
<!-- chat menu -->
<div class="popup-box2 chat-popup" id="chat-box-popup2" style="z-index: 10000;">
  <div class="popup-messages">
    <div class="direct-chat-messages">
      <div class="frame2">
          <ul id="chat-contacts">
            
          </ul>
      </div>
    </div>
  </div>
</div>
<!-- chat menu -->

<!-- app menu -->
<div class="popup-box2 chat-popup" id="app-popup" style="z-index: 10000;margin-right: 5px;">
  <div class="popup-messages">
    <div class="direct-chat-messages">
      <div class="frame2">
          <ul id="app-contents">
            <a class="contact-list online" href="#">
              <li class="popup-item">
                <div class="macro">
                  <div class="avatar" style="padding:0px 0px 0px 10px !important">
                    <img class="" src="assets/images/users/no-image.jpg">
                  </div>
                  <div class="text text-r">
                    <p>app name</p>
                  </div>
                </div>
              </li>
            </a>
            <a class="contact-list" href="#">
              <li class="popup-item">
                <div class="macro">
                  <div class="avatar" style="padding:0px 0px 0px 10px !important">
                    <img class="" src="assets/images/users/no-image.jpg">
                  </div>
                  <div class="text text-r">
                    <p>app name</p>
                  </div>
                </div>
              </li>
            </a>
            <a class="contact-list" href="#">
              <li class="popup-item">
                <div class="macro">
                  <div class="avatar" style="padding:0px 0px 0px 10px !important">
                    <img class="" src="assets/images/users/no-image.jpg">
                  </div>
                  <div class="text text-r">
                    <p>app name</p>
                  </div>
                </div>
              </li>
            </a>
            <!-- <li class="popup-item">  test</li>
            <li class="popup-item"><img src="assets/images/users/no-image.jpg">  test</li>
            <li class="popup-item"><img src="assets/images/users/no-image.jpg">  test</li> -->
          </ul>
      </div>
    </div>
  </div>
</div>
<!-- app menu -->


<!-- chat  -->
<div class="chat class=btn-group" style="z-index: 10000;">
  <button class="btn btn-primary" type="button" id="addClass" data-toggle="chat-tooltip" title="چت">
    <i class="fa fa-envelope" aria-hidden="true"></i>
  </button>
  <button class="btn btn-danger" type="button" id="moshaClass" data-toggle="help-tooltip" title="مشاوره گرفتن!">
      <i class="fa fa-asterisk" aria-hidden="true"></i>
  </button>
  <button class="btn btn-success" type="button" id="appClass" data-toggle="apps-tooltip" title="برنامه های من!">
    <i class="fa fa-comments" aria-hidden="true"></i>
  </button>
</div>
