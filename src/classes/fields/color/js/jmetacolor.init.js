(function($, window, document, undefined) {

  $(function() {

    $('input.colorpicker').each(function(i, el) {

      var $input = $(this);
      var $picker = $('#colorpicker-' + el.id);

      $picker.farbtastic('#' + el.id);

      $picker.css({
        top: $input.position().top - $picker.outerHeight(),
        left: $input.position().left
      });

      $input.on('focus', function() {
        $picker.fadeIn();
      });

      $input.on('blur', function() {
        $picker.fadeOut();
      });

    });

  });

})(jQuery, window, document);