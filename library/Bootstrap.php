<?php

/**
 * Application bootstrapper
 *
 * @category  TechTest
 * @package   TechTest
 * @copyright 2011 Everything Everywhere
 */

/**
 * Application bootstrapper
 *
 * The bootstrapper class handles class autoloading of other classes within the
 * application. It will look for a class in a variety of paths relative to
 * {@link DOCUMENTROOT_PATH}.
 *
 * @category TechTest
 * @package  TechTest
 * @author   Customer Interactions <tactical.cs@everythingeverywhere.com>
 */
class Bootstrap
{
    /**
     * Autoloader paths
     *
     * @var string[]
     */
    protected $_autoloaderPaths = array(
        'library'
    );

    /**
     * Instance of Bootstrap class
     *
     * @var Bootstrap
     */
    protected static $_instance;

    /**
     * Initialise the Bootstrap class
     *
     * @return void
     */
    protected function __construct()
    {
        $this->_initAutoloader();
    }

    /**
     * Initialise the autoloader
     *
     * @return void
     */
    protected function _initAutoloader()
    {
        spl_autoload_register(array($this, '_autoloaderCallback'));
    }

    /**
     * SPL Autoloader callback method
     *
     * This function checks to see if the class exists in its array of known
     * paths. It loops through {@link Bootstrap::$_autoloaderPaths} and
     * includes the class if found.
     *
     * @param string $class Name of the class to load.
     * @return void
     */
    protected function _autoloaderCallback($class)
    {
        $classFilename = str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';

        foreach ($this->_autoloaderPaths as $path) {
            $file = implode(DIRECTORY_SEPARATOR, array(
                DOCUMENTROOT_PATH,
                $path,
                $classFilename
            ));

            if (file_exists($file)) {
                require $file;
                return;
            }
        }
    }

    /**
     * Add an autoloader path
     *
     * This function is used to add an additional path to the list of locations
     * that are checked during the autoload.
     *
     * @param string $path Path to add.
     * @return Bootstrap Provides a fluent interface.
     */
    public function addAutoloaderPath($path)
    {
        $this->_autoloaderPaths[] = $path;
        return $this;
    }

    /**
     * Get the instance of the Bootstrap
     *
     * @return Bootstrap Returns the Bootstrap instance.
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}
