<?php namespace JMetaBox;

/**
*
*/
class Datepicker extends Field {

  public function render() {

    $this->output .= sprintf(
      '<div class="control-group">
        <label class="control-label" for="%1$s">%2$s</label>
        <div class="controls">
          <input type="text" id="%1$s" name="%1$s" class="span2 datepicker" placeholder="%2$s" value="%3$s" />%4$s
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
      'rep_datepicker',
      $this->directory . '/js/rep_datepicker.init.min.js',
      array(
        'jquery-ui-datepicker'
      ),
      '0.1',
      true
    );

    wp_enqueue_script('rep_datepicker');

  }

}