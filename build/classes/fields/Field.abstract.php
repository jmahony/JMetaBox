<?php namespace Rep\MetaBox;

/**
 * Field
 *
 * Any fields e.g. Text fields should extend off of this class.
 * Responsibilities include:
 * Holding required values
 * Saving the form meta values to the database
 * Adding script and style actions
 * Enforcing implementation of the render method
 *
 * @author Josh Mahony (jalmahony@gmail.com)
 * @abstract
 **/
abstract class Field extends \Rep\Renderer implements FieldInterface {

  /**
   * id
   * The WordPress meta_key, this needs to be unique
   *
   * @var string
   **/
  protected $id;

  /**
   * value
   * The current value
   *
   * @var string
   **/
  protected $value;

  /**
   * label
   * The label to display on the front end
   *
   * @var string
   **/
  protected $label;

  /**
   * args
   * Make the arguments accessible
   *
   * @var string
   **/
  protected $args;

  /**
   * directory
   * The directory of the current file
   *
   * @var string
   **/
  protected $directory;

  /**
   * metaBox
   * The fields containing metabox
   *
   * @var MetaBox
   **/
  private $metaBox;

  /**
   * __construct
   * id offset is required
   * TODO: Clean this up a bit!
   * @param array $args
   * @return void
   **/
  public function __construct($args = array()) {

    // Require the id offset
    if (!isset($args['id']))
      throw new FieldException('No field id supplied');

    $this->id = $args['id'];

    if (!is_array($args))
      throw new FieldException('$args must be array');

    $this->args = (array) $args;

    $this->label = (isset($args['label'])) ? $args['label'] : null;

    // Fetch the post meta, we need this to display in the field when rendering
    $this->value = get_post_meta($_GET['post'], $this->id, true);

    // Populate directory attribute
    $this->directory = $this->getDirectory();

    $this->addActions();

  }

  /**
   * save
   * Updates the post meta
   * TODO: Fix the sanitize call
   *
   * @param int $postId
   * @param WP_Post $post
   * @return void
   **/
  public function save($postId = null, \WP_Post $post = null) {

    update_post_meta($postId, $this->id, sanitize_text_field($_POST[$this->id]));

  }

  /**
   * renderHelpText
   * Renders helptext passed via the args array
   *
   * @return string
   **/
  public function renderHelpText() {

    if (isset($this->args['helptext'])) {
      return sprintf(
        '<span class="help-block">%s</span>',
        $this->args['helptext']
      );
    }

    return null;

  }

  /**
   * enqueueScripts
   * This is meant to be overriden by child classes that need to enqueue scripts
   *
   * @return void
   **/
  public function enqueueScripts() {}

  /**
   * enqueueStyles
   * This is meant to be overriden by child classes that need to enqueue styles
   *
   * @return void
   **/
  public function enqueueStyles() {}

  /**
   * getFieldType
   * Returns the fields type
   *
   * @return string
   **/
  protected function getFieldType() {

    $class = explode('\\', get_class($this));

    $class = str_replace('field', '', strtolower(end($class)));

    return $class;

  }

  /**
   * addActions
   * Hook up an actions
   *
   * @return void
   **/
  private function addActions() {

    add_action('admin_enqueue_scripts', array(&$this, 'enqueueScripts'));
    add_action('admin_enqueue_scripts', array(&$this, 'enqueueStyles'));

  }

  /**
   * getDirectory
   * Get the directory, this is used when including any scripts or styles
   * TODO: Stop this depending on wordpress's get_stylesheet_directory_uri
   * @return string
   **/
  private function getDirectory() {

    return get_stylesheet_directory_uri() . '/metabox/build/classes/fields/' . $this->getFieldType();

  }

  /**
   * register
   * Registers the metabox with the field
   *
   * @param MetaBox &$mb
   * @return void
   **/
  public function register(\Rep\MetaBox &$mb) {

    $this->metaBox = $mb;

  }

  /**
   * getId
   * Returns the fields ID
   *
   * @return string
   **/
  public function getId() {

    return $this->id;

  }

  /**
   * getMetaBox
   * Returns the fields containing metabox
   *
   * @return MetaBox
   **/
  public function getMetaBox() {

    return $this->metaBox;

  }

  /**
   * ifCondition
   * This is supposed to generate an if condition for condtional fields
   * TODO: Naming doesn't seem right
   *
   * @param int $i (current index position of condition array)
   * @param array $cond (the condition array)
   * @return string
   **/
  public function ifCondition($i = null, $cond = array()) {}

}

class FieldException extends \Exception {}