<?php

/**
 * View renderer
 *
 * @category  TechTest
 * @package   TechTest
 * @copyright 2011 Everything Everywhere
 */

/**
 * View renderer
 *
 * This class is used to load the correct view script from the specified
 * location. It can also have variables assigned to it from the controller
 * which are then present in the view script.
 *
 * Because this class includes the view script, all view scripts have the scope
 * of this object; in other words, using $this in a view script will refer to an
 * instance of the View class.
 *
 * @category TechTest
 * @package  TechTest
 * @author   Customer Interactions <tactical.cs@everythingeverywhere.com>
 */
class View
{
    /**
     * Controller name
     *
     * @var string
     */
    protected $_controller;

    /**
     * Action name
     *
     * @var string
     */
    protected $_action;

    /**
     * Storage for the view variables
     *
     * @var ArrayObject
     */
    protected $_variables;

    /**
     * Base path for scripts
     *
     * @var string
     */
    protected $_scriptPath = '/application/view';

    /**
     * Initialise the View using the controller and action name
     *
     * @param string $controller Controller name.
     * @param string $action     Action name.
     * @return void
     */
    public function __construct($controller, $action)
    {
        $this->_controller = $controller;
        $this->_action = $action;

        $this->_variables = new ArrayObject();

        // used so that view scripts can include partials
        set_include_path(
            realpath(DOCUMENTROOT_PATH . $this->_scriptPath) .
            PATH_SEPARATOR . get_include_path()
        );
    }

    /**
     * Magic get method
     *
     * This function is used to get a variable from the view.
     *
     * @param string $key Name of the variable.
     * @return mixed Returns the value of the variable, or null if not found.
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->_variables)) {
            return $this->_variables[$key];
        }

        return null;
    }

    /**
     * Magic set method
     *
     * This function is used to set a variable on the view.
     *
     * @param string $key   Name of the variable.
     * @param mixed  $value Value to set.
     * @return void
     */
    public function __set($key, $value)
    {
        $this->_variables[$key] = $value;
    }

    /**
     * Render the view script
     *
     * @return void
     * @throws Exception Thrown if the specified view script cannot be found.
     */
    public function render()
    {
        $viewScript = implode(DIRECTORY_SEPARATOR, array(
            DOCUMENTROOT_PATH,
            $this->_scriptPath,
            $this->_controller,
            $this->_action . '.phtml'
        ));

        if (!file_exists($viewScript)) {
            throw new Exception("Cannot load view script $viewScript", 500);
        }

        require $viewScript;
    }
}