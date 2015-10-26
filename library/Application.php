<?php

/**
 * Application runner
 *
 * @category  TechTest
 * @package   TechTest
 * @copyright 2011 Everything Everywhere
 */

/**
 * Application runner
 *
 * This class handles the running of the main application. It sets the paths
 * that the autoloader can use to load parts of application code. It also
 * creates and dispatches the {@link FrontController}.
 *
 * @category TechTest
 * @package  TechTest
 * @author   Customer Interactions <tactical.cs@everythingeverywhere.com>
 */
class Application
{
    /**
     * Front controller instance
     *
     * @var FrontController
     */
    protected $_frontController;

    /**
     * Initialise the application
     *
     * This function registers the application autoload paths and creates the
     * {@link FrontController}.
     *
     * @return void
     */
    public function __construct()
    {
        $bootstrap = Bootstrap::getInstance();
        $bootstrap->addAutoloaderPath('application/controller')
            ->addAutoloaderPath('application/model')
            ->addAutoloaderPath('application/view');

        $this->_frontController = new FrontController();
    }

    /**
     * Run the application
     *
     * This function dispatches the {@link FrontController} and catches any
     * Exceptions thrown during the dispatch.
     *
     * @return void
     */
    public function run()
    {
        try {
            $this->_frontController->setRequest(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/');
            $this->_frontController->dispatch();
        } catch (Exception $ex) {
            $this->_frontController->handleException($ex);
        }
    }

}
