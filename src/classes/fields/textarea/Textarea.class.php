<?php namespace Rep\MetaBox;

/**
*
*/
class Textarea extends Field {

  public function render() {

    $this->output .= sprintf(
      '<div class="control-group">
        <label class="control-label" for="%1$s">%2$s</label>
        <div class="controls">
          <textarea type="text" id="%1$s" name="%1$s" rows="5" class="span6">%3$s</textarea>%4$s
        </div>
      </div>',
      $this->id,
      $this->label,
      $this->value,
      $this->renderHelpText()
    );

    return $this->output;

  }

}