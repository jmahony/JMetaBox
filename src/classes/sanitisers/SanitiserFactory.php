<?php namespace JMetaBox;

/**
 * FieldFactory
 *
 * Instansiates Field objects
 *
 * @author Josh Mahony (jalmahony@gmail.com)
 **/
class SanitserFactory {

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
      self::$loader = new ClassLoader('sanitisers');
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

    $class = self::$loader->load($args['sanitiser']);

    /* Force anyone using MetaBox to adhere to the FieldInterface */
    if (is_subclass_of($class, '\\JMetaBox\\SanitiserInterface')) {
      return new $class($args);
    }

    throw new FieldFactoryException($class . ' must extend off of Sanitiser or implement \JMetaBox\SanitiserInterface');

  }

}

class FieldFactoryException extends \Exception {}