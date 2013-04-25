<?php namespace JMetaBox;

/**
 * FieldFactory
 *
 * Instansiates Field objects
 *
 * @author Josh Mahony (jalmahony@gmail.com)
 **/
class FieldFactory extends Factory {

  /**
   * __construct
   * Create a FieldLoader instance
   *
   * @return void
   **/
  public function __construct() {

    parent::__construct('fields');

  }

  /**
   * make
   * Instantiates a field object
   *
   * @param string $fieldType
   * @param array $args
   * @return void
   **/
  public function make($args = array()) {

    $class = $this->loader->load($args['type']);

    /* Force anyone using MetaBox to adhere to the FieldInterface */
    if (is_subclass_of($class, '\\JMetaBox\\FieldInterface')) {
      return new $class($args);
    }

    throw new FieldFactoryException($class . ' must extend off of Field or implement \JMetaBox\FieldInterface');

  }

}