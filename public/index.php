<?php

/**
 * System entry point
 *
 * This script is executed whenever a request is made which does not match a
 * file name in the public/ directory. It defines some project constants,
 * instantiates the bootstrapper and runs the application code.
 *
 * @category  TechTest
 * @package   TechTest
 * @copyright 2011 Everything Everywhere
 */

/**#@+
 * Project constants
 *
 * @var string
 */
define('DOCUMENTROOT_PATH', realpath(dirname(__FILE__) . '/..'));
define('DATA_PATH', DOCUMENTROOT_PATH . '/data');
/**#@-*/

// Bootstrap the framework
require_once DOCUMENTROOT_PATH . '/library/Bootstrap.php';
Bootstrap::getInstance();

// Create an application and run
$application = new Application();
$application->run();
