<?php namespace JMetaBox;

if (!defined('JMETA_BASE_URL')) {

  define('JMETA_BASE_URL', get_stylesheet_directory_uri());

}

if (!defined('JMETA_BUILD_URL')) {

  define('JMETA_BUILD_URL', JMETA_BASE_URL . '/JMetaBox/build');

}

if (!defined('JMETA_ASSETS_URL')) {

  define('JMETA_ASSETS_URL', JMETA_BUILD_URL . '/assets');

}

require_once('classes/fields/FieldInterface.interface.php');
require_once('classes/Input.class.php');
require_once('classes/Factory.abstract.php');

require_once('classes/Renderer.abstract.php');
require_once('classes/ConditionGenerator.class.php');

require_once('classes/ClassLoader.class.php');
require_once('classes/FieldFactory.class.php');
require_once('classes/SanitiserFactory.class.php');

require_once('classes/sanitisers/SanitiserInterface.interface.php');
require_once('classes/sanitisers/Sanitiser.abstract.php');

require_once('classes/fields/Field.abstract.php');
require_once('classes/fields/MultiField.abstract.php');

require_once('classes/MetaBox.class.php');
