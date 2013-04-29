<?php namespace JMetaBox;

/**
*
*/
class Upload extends Field {

  public function render() {

    $this->output .= sprintf(
      '<div class="control-group">
        <label class="control-label" for="%1$s">%2$s</label>
        <div class="controls">
          <input type="text" id="%1$s" name="%1$s" class="span6" value="%3$s" />%4$s
          <a class="jmeta-upload button insert-media add_media">Add Media</a>
        </div>
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
      'jmetaupload',
      $this->directory . '/js/jmetaupload.init.js',
      array(
        'jquery'
      ),
      '0.1',
      true
    );

    wp_enqueue_script('jmetaupload');

  }

}