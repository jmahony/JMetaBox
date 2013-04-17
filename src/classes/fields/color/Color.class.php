<?php namespace JMetaBox;

/**
*
*/
class Color extends Field {

  public function render() {

    $this->output .= sprintf(
      '<div class="control-group">
        <label class="control-label" for="%1$s">%2$s</label>
        <div class="controls">
          <input type="text" id="%1$s" name="%1$s" class="span2 colorpicker" placeholder="%2$s" value="%3$s" />%4$s
        </div>
        <div id="colorpicker-%1$s" class="color-wheel-container"></div>
      </div>',
      $this->id,
      $this->label,
      $this->value,
      $this->renderHelpText()
    );

    return $this->output;

  }

  public function enqueueScripts() {

    wp_register_script(
      'farbtastic2',
      LIBRARY_URL . '/JMetaBox/build/assets/js/farbtastic.js',
      array(
        'jquery'
      ),
      '2.0',
      true
    );

    wp_register_script(
      'jmetacolor',
      $this->directory . '/js/jmetacolor.init.min.js',
      array(
        'jquery',
        'farbtastic2'
      ),
      '0.1',
      true
    );

    wp_enqueue_script('jmetacolor');

  }

}