<?php namespace JMetaBox;

/**
*
*/
class Radio extends MultiField {

  public function render() {

    $cg = (string) '';

    if (isset($this->args['cond'])) {
      $cg = new \JMetaBox\ConditionGenerator($this->args['cond'], $this);
      $cg->render();
    }

    $this->output .= sprintf(
      '<div class="control-group" id="%1$s-container">
        <label class="control-label">%2$s</label>
        <div class="controls">
          %3$s%4$s
        </div>%5$s
      </div>',
      $this->id,
      $this->label,
      $this->renderOptions(),
      $this->renderHelpText(),
      $cg
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
