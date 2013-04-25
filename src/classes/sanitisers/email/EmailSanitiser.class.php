<?php namespace JMetaBox;

/**
*
*/
class EmailSanitiser extends Sanitiser {

  public function clean($email = null) {

    return sanitize_email($email);

  }

}