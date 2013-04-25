<?php namespace JMetaBox;

/**
 * FieldLoader
 *
 * TODO: Add description
 * Responsibilities include:
 * Loading class files
 * @author Josh Mahony (jalmahony@gmail.com)
 **/
class ClassLoader {

  /**
   * loaded
   * Keep a list of the field that have already been loaded
   *
   * @var array
   **/
  private static $loaded = array();

  /**
   * dir
   * Directory to look for classes
   *
   * @var string
   **/
  private $dir;

  public function __construct($dir = null) {

    $this->dir = $dir;

  }

  /**
   * load
   * Takes the class name and sees if it already exists, if not, tries to load
   * the corresponding field file.
   * TODO: Move some logic to isLoaded
   *
   * @param string $className
   * @return string
   **/
  public function load($className = null) {

    $className = ucfirst($className);

    /* Check the global namespace for user defined fields */
    if (class_exists('\\' . $className)) {
      self::success($className);
      return '\\' . ucwords($className);
    }

    $this->loadFile($className);

    /* Any classes loaded should
     * be in the JMetaBox namespace. So lets check that namespace */
    if (class_exists('\\JMetaBox\\' . $className)) {
      self::success($className);
      return '\\JMetaBox\\' . $className;
    }

    throw new FieldLoaderException('Could not find ' . $className . ' in ' . $this->dir);

  }

  /**
   * loadFieldFile
   * Loads a field file
   *
   * @param string $className
   * @return bool
   **/
  private function loadFile($className = null) {

    $path = __DIR__ . '/' . $this->dir . '/' . strtolower(str_replace('Sanitiser', '', $className)) . '/' . $className . '.class.php';

    if (file_exists($path) && !self::isLoaded($path)) {
      require_once($path);
    }

  }

  /**
   * load
   * Checks if a class has already been loaded
   *
   * @param string $className
   * @return bool
   **/
  private function isLoaded($className = null) {

    return in_array($className, self::$loaded);

  }

  /**
   * success
   * Add the classname to the loaded array
   *
   * @param string $className
   * @return void
   **/
  private function success($className = null) {

    array_push(self::$loaded, $className);

  }

}

class FieldLoaderException extends \Exception {}
