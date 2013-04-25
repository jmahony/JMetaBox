<?php namespace JMetaBox;

/**
 * Input
 *
 *
 * @author Josh Mahony (jalmahony@gmail.com)
 **/
class Input {

  public static function get($k, $default = null) {

    return self::getHas($k) ? $_GET[$k] : $default;

  }

  public static function getHas($k) {

    return array_key_exists($k, $_GET);

  }

  public static function post($k, $default = null) {

    return self::postHas($k) ? $_POST[$k] : $default;

  }

  public static function postHas($k) {

    return array_key_exists($k, $_POST);

  }

}