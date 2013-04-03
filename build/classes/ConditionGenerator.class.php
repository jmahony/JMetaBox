<?php namespace Rep\MetaBox;

/**
*
*/
class ConditionGenerator extends \Rep\Renderer {

  private $cond = array();
  private $field;

  public function __construct($cond = array(), &$field = null) {
    $this->cond = $cond;
    $this->field = $field;
  }

  public function render() {

    $this->generateJS();

  }

  private function generateJS() {

    $this->output .= '<script type="text/javascript">(function($, window, document, undefined) {$(function(){ ';

    $this->generateIf();

    $this->generateListener();

    $this->output .= '});})(jQuery, window, document);</script>';

  }

  private function generateIf($hide = 'hide', $show = 'show') {

    $this->output .= 'if (';

    for ($i = 0; $i < count($this->cond); $i++) {
      $this->output .= $this->field->getMetaBox()->getField($this->cond[$i]['field'])->ifCondition($i, $this->cond);
      $this->op($i);
    }

    $this->output .= ') {';

    $this->output .= '$("#' . $this->field->getId() . '-container").' . $show . '();';

    $this->output .= '} else {';

    $this->output .= '$("#' . $this->field->getId() . '-container").' . $hide . '();';

    $this->output .= '}';

  }

  private function generateListener() {

    $this->output .= '$("';

    for ($i=0; $i < count($this->cond); $i++) {
      $this->output .= '#' . $this->cond[$i]['field'];
      $this->output .= (isset($this->cond[$i+1])) ? ', ' : null;
    }

    $this->output .= '").on("change", function() {';

    $this->generateIf('slideUp', 'slideDown');

    $this->output .= '});';

  }
  //TODO: This needs some attention!
  private function op($i = null) {

    if ((!isset($this->cond[$i+1]['op']) || !$this->cond[$i+1]['op']) && $i < count($this->cond) - 1) {
      throw new \Exception('op must be set');
    } else {
      if (isset($this->cond[$i+1]['op'])) {
        switch ($this->cond[$i+1]['op']) {
          case 'and':
            $this->output .= ' && ';
            break;
          case 'or':
            $this->output .= ' || ';
            break;
        }
      }
    }

  }

}