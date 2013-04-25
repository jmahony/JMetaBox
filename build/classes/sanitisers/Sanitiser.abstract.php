<?php namespace JMetaBox;

/**
*
*/
abstract class Sanitiser implements SanitiserInterface {

  private static $errors;

  abstract function clean($v = null);

  public function getErrors() {

    return self::$errors;

  }

  public function addError($field = null, $message = null) {

    $this->errors[$field] = $message;

  }

}