<?php namespace JMetaBox;

/**
*
*/
class Editor extends Field {

  public function render() {

    $cg = (string) '';

    if (isset($this->args['cond'])) {
      $cg = new \JMetaBox\ConditionGenerator($this->args['cond'], $this);
      $cg->render();
    }

    $this->output .= sprintf(
      '<div class="control-group" id="%1$s-container">
        <label class="control-label" for="%1$s">%2$s</label>
        <div class="controls">
          %3$s
        </div>%5$s
      </div>',
      $this->id,
      $this->label,
      $this->getEditor(),
      $this->renderHelpText(),
      $cg
    );

    return $this->output;

  }

  private function getEditor() {

    ob_start();
    \wp_editor($this->value, $this->id);
    $buffer = ob_get_contents();
    ob_end_clean();
    return $buffer;

  }

}