<?php
  $emote = true;
  if (isset($_POST["aq"])) {
    echo "مرسی";die();
  }
  if ($emote):
?>
<h3>امروز من</h3>
<div class="row">
  <img src="/assets/images/emote/emote_2.png" class="emote img-circle" alt="emote_2">
  <img src="/assets/images/emote/emote_3.png" class="emote img-circle" alt="emote_3">
  <img src="/assets/images/emote/emote_4.png" class="emote img-circle" alt="emote_4">
  <img src="/assets/images/emote/emote_1.png" class="emote img-circle" alt="emote_1">
</div>
<?php endif; ?>
