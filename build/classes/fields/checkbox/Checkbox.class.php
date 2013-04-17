<?php namespace JMetaBox;

/**
* Checkbox
*/
class Checkbox extends Field {

  public function render() {

    $this->output .= sprintf(
      '<div class="control-group">
        <label class="control-label">%2$s</label>
        <div class="controls">
          <label class="checkbox" for="%1$s">%3$s
            <input type="checkbox" id="%1$s" name="%1$s" value="%6$s"%4$s />
          </label>
          %5$s
        </div>
      </div>',
      $this->id,
      $this->label,
      $this->args['cb-label'],
      ($this->value == $this->args['value']) ? ' checked' : null,
      $this->renderHelpText(),
      $this->args['value']
    );

    return $this->output;

  }

  public function ifCondition($i = null, $cond = array()) {

    $rs = (string) '';

    if ($cond[$i]['is'] == 'notchecked') $rs .= '!';

    $rs .= '$("#' . $cond[$i]['field'] . '").is(":checked")';

    return $rs;

  }

}
