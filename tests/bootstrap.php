<?php
define('DOCUMENTROOT_PATH', realpath(dirname(__FILE__) . '/..'));
define('DATA_PATH', DOCUMENTROOT_PATH . '/data');

// Bootstrap the framework
require_once DOCUMENTROOT_PATH . '/library/Bootstrap.php';

$bootstrap = Bootstrap::getInstance();
$bootstrap->addAutoloaderPath('application/controller')
          ->addAutoloaderPath('application/model')
          ->addAutoloaderPath('application/view');
