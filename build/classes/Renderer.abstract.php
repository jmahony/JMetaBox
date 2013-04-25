<?php namespace JMetaBox;

/**
*  TODO: Extend off of mustache
*/
abstract class Renderer {

  /**
   * html
   * Stores the rendered HTML
   *
   * @var string
   **/
  public $output;

  public function __construct() {

    $this->output = (string) '';

  }

  /**
   * render
   * Renders the content and stores it in $this->output
   * Should return the rendered string
   * @return string $this->output
   **/
  abstract function render();

  /**
   * __toString
   * Returns this->output
   *
   * @return string
   **/
  public function __toString() {

    $this->render();

    return $this->output;

  }

}