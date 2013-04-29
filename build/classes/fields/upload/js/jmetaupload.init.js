(function($, window, document, undefined) {

  $(document).ready(function() {

    var $field;

    $(".jmeta-upload").click(function() {
      $field = $(this).prev();
      tb_show("", "media-upload.php?post_id=" + get_post_id() + "&amp;type=file&amp;TB_iframe=true");
      return false;
    });

    window.send_to_editor = function(html) {
      var imgurl = $("img",html).attr("src");
      $field.val(imgurl);
      tb_remove();
    };

    function get_post_id() {
      var arr    = window.location.search.substring(1).split('&');
      var params = {};
      for (var i = 0; i < arr.length; i++) {
        var t = arr[i].split('=');
        params[t[0]] = t[1];
      }
      return params.post;
    }

  });

})(jQuery, window, document);