<?php

/**
 * Abstract controller
 *
 * @category  TechTest
 * @package   TechTest
 * @copyright 2011 Everything Everywhere
 */

/**
 * Abstract controller
 *
 * This class is an abstract implementation of a controller to be used for
 * implementing controllers in the main application. It takes request
 * instructions from the {@link FrontController} and provides a {@link View}
 * object which can be assigned variables. It also handles the rendering of
 * the view.
 *
 * @category TechTest
 * @package  TechTest
 * @author   Customer Interactions <tactical.cs@everythingeverywhere.com>
 */
abstract class ControllerAbstract
{
    /**
     * Storage for the View instance
     *
     * @var View
     */
    protected $_view;

    /**
     * Storage for the FrontController instance
     *
     * @var FrontController
     */
    protected $_frontController;

    /**
     * Initialise the controller
     *
     * @param FrontController $frontController Instance of the FrontController.
     * @return void
     */
    public function __construct($frontController)
    {
        $this->_frontController = $frontController;
    }

    /**
     * Pre-dispatch hook
     *
     * This function is called before the action is executed. It is generally
     * used for object initialisation.
     *
     * @return void
     */
    public function preDispatch()
    {
        $request = $this->_frontController->getRequest();

        $this->_view = new View(
            $request['controller'],
            $request['action']
        );
    }

    /**
     * Post-dispatch hook
     *
     * This function is called after the action is executed.
     *
     * @return void
     */
    public function postDispatch()
    {
        $this->_view->render();
    }

    /**
     * Get the View instance
     *
     * @return View Returns the view for the controller.
     */
    public function getView()
    {
        return $this->_view;
    }
}