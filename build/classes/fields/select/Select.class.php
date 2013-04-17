<?php namespace JMetaBox;

/**
*
*/
class Select extends MultiField {

  public function render() {

    $this->output .= sprintf(
      '<div class="control-group">
        <label class="control-label" for="%1$s">%2$s</label>
        <div class="controls">
          <select name="%1$s">%3$s</select>%4$s
        </div>
      </div>',
      $this->id,
      $this->label,
      $this->renderOptions(),
      $this->renderHelpText()
    );

    return $this->output;

  }

  private function renderOptions() {

    $rs = (string) '';

    foreach ($this->options as $option => $value) {
      $rs .= sprintf(
        '<option value="%1$s"%2$s>%3$s</option>',
        $value,
        ($this->value == $value) ? ' selected' : null,
        $option
      );
    }

    return $rs;

  }

}