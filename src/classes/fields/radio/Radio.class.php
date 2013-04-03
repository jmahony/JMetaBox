<?php namespace Rep\MetaBox;

/**
*
*/
class Radio extends MultiField {

  public function render() {

    $this->output .= sprintf(
      '<div class="control-group">
        <label class="control-label">%1$s</label>
        <div class="controls">
          %2$s%3$s
        </div>
      </div>',
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
        '<label class="radio">
          <input type="radio" name="%1$s" value="%2$s"%3$s \>
          %4$s
        </label>',
        $this->id,
        $value,
        ($this->value == $value) ? ' checked' : null,
        $option
      );

    }

    return $rs;

  }

}
