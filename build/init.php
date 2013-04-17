<?php namespace JMetaBox;

if (!defined('LIBRARY_URL')) {

  define('LIBRARY_URL', '/JMetaBox/build');

}

if (!defined('ASSETS_URL')) {

  define('ASSETS_URL', LIBRARY_URL . '/assets');

}

require_once('classes/fields/FieldInterface.interface.php');

require_once('classes/Renderer.abstract.php');
require_once('classes/ConditionGenerator.class.php');

require_once('classes/fields/Field.abstract.php');
require_once('classes/fields/MultiField.abstract.php');

require_once('classes/FieldLoader.class.php');
require_once('classes/FieldFactory.class.php');

require_once('classes/MetaBox.class.php');
