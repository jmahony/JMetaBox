<?php namespace Rep;

/**
 * MetaBox
 *
 * TODO: Add description
 * Responsibilities include:
 * TODO: Add responsibilities
 * @author Josh Mahony (jalmahony@gmail.com)
 **/
class MetaBox extends \Rep\Renderer {

  /**
   * postTypes
   * The post types to assosiate this metabox with.
   *
   * @var string
   **/
  private $postTypes;

  /**
   * id
   * The css id that is added to the metabox by WordPress
   *
   * @var string
   **/
  private $id;

  /**
   * title
   * The title that sits in the title bar of the metabox
   *
   * @var string
   **/
  private $title;

  /**
   * desc
   * HTML description that sits above the fields
   *
   * @var string
   **/
  private $desc;

  /**
   * fields
   * Stores the metabox's fields
   *
   * @var array <Field>
   **/
  private $fields = array();

  /**
   * context
   * Where to display the metabox, current available
   * locations include 'normal', 'advanced' and 'side'
   *
   * @var string
   **/
  private $context;

  /**
   * priority
   * How high the metabox should appear
   *
   * @var string
   **/
  private $priority;

  /**
   * nonce
   * The WordPress nonce to use
   *
   * @var string
   **/
  private $nonce = 'rep_meta_boxes_nonce';

  /**
   * fieldFactory
   * Instansiates fields
   *
   * @var FieldFactory
   **/
  private $fieldFactory;

  /**
   * __construct
   * ($i) id is required
   * ($c) context is required
   * ($pt) postType is required
   * ($p) priority is required
   * TODO: Clean this up a bit!
   * TODO: Make it so you can pass in an array of fields, rather than keep calling addField
   * @param string $i (id)
   * @param string $t (title)
   * @param string $d (desc)
   * @param string $pt (postType)
   * @param string $c (contact)
   * @param string $p (priority)
   * @return void
   **/
  public function __construct($args = array()) {

    if (!isset($args['id']) && is_numeric(substr($args['id'], 0, 1)))
      throw new MetaBoxException('ID is required and cannot start with int');

    $this->id = $args['id'];

    if (!isset($args['context']))
      throw new MetaBoxException('Context is required');

    $this->context = $args['context'];

    if (!isset($args['priority']))
      throw new MetaBoxException('Priority is required');

    $this->priority = $args['priority'];

    if (!isset($args['title']))
      throw new MetaBoxException('Title is required');

    $this->title = $args['title'];

    if (!isset($args['types']))
      throw new MetaBoxException('Types is required');

    $this->postTypes = (array) $args['types'];

    $this->desc = $args['desc'];

    $this->fieldFactory = new \Rep\metabox\FieldFactory();

    $this->addFields($args['fields']);

    $this->addActions();

  }

  /**
   * render
   * Renders the metabox and iterates over the fields render them aswell
   * Needs to be public so WordPress can call
   *
   * @return string
   **/
  public function render() {

    $this->output .= '<div class="rep-meta-box">';

    $this->output .= sprintf('<h2>%s</h2>', $this->desc);

    $this->output .= wp_nonce_field('rep_meta_save', $this->nonce, true, false);

    $this->output .= '<div class="form-horizontal">';

    foreach ($this->fields as $field) {

      $field->render();

      $this->output .= $field;

    }

    $this->output .= '</div>';

    $this->output .= '</div>';

    echo $this->output;

    return $this->output;

  }

  /**
   * addField
   * Add a field to the metabox
   * TODO: Don't like this
   * @param array $mbfa (MetaBoxFieldArray)
   * @return void
   **/
  public function addField($mbfa = array()) {

    if (array_key_exists($mbfa['id'], $this->fields)) {
      throw new MetaBoxException('Duplicate field ids');
    }

    $mbf = $this->fieldFactory->make($mbfa);

    $mbf->register(&$this);

    $this->fields[$mbf->getId()] = $mbf;

  }

  public function getField($id = null) {

    return $this->fields[$id];

  }

  /**
   * addFields
   * Add a multiple fields to the metabox
   *
   * @param array $fields (MetaBoxFieldArrays)
   * @return void
   **/
  public function addFields($fields = array()) {

    foreach ($fields as $field) {
      $this->addField($field);
    }

  }

  /**
   * save
   * Validate the user and nonce and then iterate over the fields saving them.
   * Params are passed in by WordPress
   *
   * @param int $postId
   * @param WP_Post $post
   * @return void
   **/
  public function save($postId = null, \WP_Post $post = null) {

    if (!$this->userIsAuthorised() || !$this->verifyNonce()) return;

    foreach ($this->fields as $field) {
      $field->save($postId, $post);
    }

  }

  /**
   * enqueueStyles
   * Callback for WordPress to enqueue the stylesheet
   *
   * @return void
   **/
  public function enqueueStyles() {

    wp_enqueue_style(
      'rep-meta-style',
      get_stylesheet_directory_uri() . '/metabox/build/assets/css/rep-meta.css'
    );

  }

  /**
   * initMeta
   * Tell WordPress about this metabox, needs to be public so WordPress can call
   *
   * @return void
   **/
  public function initMeta() {

    foreach ($this->postTypes as $postType) {
      add_meta_box(
        $this->id,
        $this->title,
        array(
          &$this,
          'render'
        ),
        $postType,
        $this->context,
        $this->priority
      );
    }

  }

  /**
   * userIsAuthorised
   * Make sure the user is allowed to edit the current page/post
   * TODO: The logic could be better
   * @param int $postId
   * @return bool
   **/
  private function userIsAuthorised($postId = null) {

    if (in_array($_POST['post_type'], $this->postTypes)) {
      if (!current_user_can('edit_page', $postId)) {
        return false;
      }
    } else {
      if (!current_user_can('edit_post', $postId)) {
        return false;
      }
    }
    return true;

  }

  /**
   * verifyNonce
   * Validate the nonce
   *
   * @param int $postId
   * @return bool
   **/
  private function verifyNonce() {

    return (isset($_POST[$this->nonce] ) &&
      wp_verify_nonce($_POST[$this->nonce], 'rep_meta_save'));

  }

  /**
   * addActions
   * Hook up an actions
   *
   * @return void
   **/
  private function addActions() {

    add_action('add_meta_boxes', array(&$this, 'initMeta'));
    add_action('save_post', array(&$this, 'save'), 1, 2);
    add_action('admin_enqueue_scripts', array(&$this, 'enqueueStyles'));

  }

}

class MetaBoxException extends \Exception {}