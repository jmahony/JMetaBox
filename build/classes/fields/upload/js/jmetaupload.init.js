(function($, window, document, undefined) {

  $(document).ready(function() {
    /* Store WordPress's original send to editor */
    var OrigSendToEditor = window.send_to_editor,

    /* Used to determine whether to use our custom send_to_editor or use WordPress's default */
    jmetaSendToEditor = false,

    /* Store the field to store the value */
    $field;

    /* Add Media click listener*/
    $(".jmeta-upload").on('click', function() {
      $field = $(this).prev();
      /* We need to use our custom send to editor function */
      jmetaSendToEditor = true;
      tb_show("", "media-upload.php?post_id=" + get_post_id() + "&amp;type=file&amp;TB_iframe=true");
      return false;
    });

    window.send_to_editor = function(html) {
      if (jmetaSendToEditor) {
        var imgurl = $("img",html).attr("src");
        $field.val(imgurl);
        tb_remove();
      } else {
        /* Call original send to editor function */
        OrigSendToEditor(html);
      }
      /* Reset send to editor */
      jmetaSendToEditor = false;
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