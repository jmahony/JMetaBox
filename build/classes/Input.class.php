<?php namespace JMetaBox;

/**
 * Input
 *
 *
 * @author Josh Mahony (jalmahony@gmail.com)
 **/
class Input {

  public static function get($k, $default = null) {

    return array_key_exists($k, $_GET) ? $_GET[$k] : $default;

  }

  public static function getHas($k) {
    return array_key_exists($k, $_GET);
  }

}