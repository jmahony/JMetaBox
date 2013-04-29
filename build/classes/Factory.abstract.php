<?php namespace JMetaBox;

/**
 * Factory
 *
 *
 * @author Josh Mahony (jalmahony@gmail.com)
 **/
abstract class Factory {

  /**
   * loader
   * Keep a reference to the field loader
   * TODO: This should be made static, possibly move into extending classes
   * @var Loader
   **/
  protected $loader;

  /**
   * __construct
   * Create a FieldLoader instance
   *
   * @return void
   **/
  public function __construct($dir) {

    if (!$this->loader) {
      $this->loader = new ClassLoader($dir);
    }

  }

  /**
   * make
   * Instantiates a field object
   *
   * @param string $fieldType
   * @param array $args
   * @return void
   **/
  abstract public function make($args = array());

}

class FieldFactoryException extends \Exception {}