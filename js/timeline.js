var ck = false;
var editor;
$("#editor1, msgpost").click (function () {
  editor = CKEDITOR.replace( 'editor1' );
  ck = true;
});
$("#editor1, msgpost").focus (function () {
  editor = CKEDITOR.replace( 'editor1' );
  ck = true;
}); 