<?php namespace JMetaBox;

/**
 * Field
 *
 * Any fields e.g. MultiFields should extend off of this class.
 * for example radio buttons and dropdowns.
 * All it really does is make an options attribute available and
 * add an option arguments
 *
 * Responsibilities include:
 * Holding options values
 *
 * @author Josh Mahony (jalmahony@gmail.com)
 * @abstract
 **/
abstract class MultiField extends Field {

  /**
   * options
   * Holds key value pairs of options
   *
   * @var array
   **/
  protected $options = array();

  /**
   * __construct
   *
   * @param array $args
   * @return void
   **/
  public function __construct($args = array()) {

    if (!isset($args['options']) || !is_array($args['options'])) {
      throw new FieldException('Please supply valid options');
    }

    $this->options = $args['options'];

    parent::__construct($args);

  }

}