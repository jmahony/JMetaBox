<?php namespace JMetaBox;

/**
 * FieldFactory
 *
 * Instansiates Field objects
 *
 * @author Josh Mahony (jalmahony@gmail.com)
 **/
class FieldFactory {

  /**
   * loader
   * Keep a reference to the field loader
   *
   * @var FieldLoader
   **/
  private static $loader;

  /**
   * __construct
   * Create a FieldLoader instance
   *
   * @return void
   **/
  public function __construct() {

    if (!self::$loader) {
      self::$loader = new FieldLoader();
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
  public function make($args = array()) {

    $class = self::$loader->load($args['type']);

    /* Force anyone using MetaBox to adhere to the FieldInterface */
    if (is_subclass_of($class, '\\JMetaBox\\FieldInterface')) {
      return new $class($args);
    }

    throw new FieldFactoryException($class . ' must extend off of Field or implement \JMetaBox\FieldInterface');

  }

}

class FieldFactoryException extends \Exception {}