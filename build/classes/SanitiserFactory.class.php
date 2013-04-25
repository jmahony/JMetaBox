<?php namespace JMetaBox;

/**
 * SanitiserFactory
 *
 * Instansiates Field objects
 *
 * @author Josh Mahony (jalmahony@gmail.com)
 **/
class SanitiserFactory extends Factory {

  /**
   * __construct
   * Create a FieldLoader instance
   *
   * @return void
   **/
  public function __construct() {

    parent::__construct('sanitisers');

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

    $class = $this->loader->load($args['sanitiser'] . 'Sanitiser');

    /* Force anyone using MetaBox to adhere to the FieldInterface */
    if (is_subclass_of($class, '\\JMetaBox\\SanitiserInterface')) {
      return new $class($args);
    }

    throw new FieldFactoryException($class . ' must extend off of Sanititser or implement \JMetaBox\SanitiserInterface');

  }

}