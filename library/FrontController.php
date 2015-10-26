<?php

/**
 * Front controller to handle application dispatching
 *
 * @category  TechTest
 * @package   TechTest
 * @copyright 2011 Everything Everywhere
 */

/**
 * Front controller to handle application dispatching
 *
 * The purpose of this class is to initialise the request environment and route
 * the incoming request to the correct controller and action.
 *
 * @category TechTest
 * @package  TechTest
 * @author   Customer Interactions <tactical.cs@everythingeverywhere.com>
 */
class FrontController
{
    /**
     * Regular expression for the standard routing pattern
     *
     * @var string
     */
    const ROUTE = '#^/(?P<controller>\w+)?(?:/(?P<action>\w+))?#';

    /**
     * Default routing options
     *
     * @var string[]
     */
    protected $_defaults = array(
        'controller' => 'default',
        'action'     => 'index'
    );

    /**
     * Request environment
     *
     * @var string[]
     */
    protected $_request = array(
        'uri'             => '',
        'controller'      => '',
        'controllerClass' => '',
        'action'          => '',
        'actionMethod'    => ''
    );

    /**
     * Initialise the request by parsing the request URI
     *
     * @param string $requestUri URI of the request.
     * @return FrontController Provides a fluent interface.
     * @throws Exception Thrown if the URI does not match the routing pattern.
     */
    public function setRequest($requestUri)
    {
        if (0 === preg_match(self::ROUTE, $requestUri, $matches)) {
            throw new Exception("Cannot set request from URI $requestUri", 404);
        }

        $route = array_merge($this->_defaults, $matches);

        $this->_request = array(
            'uri'             => $requestUri,
            'controller'      => $route['controller'],
            'controllerClass' => ucfirst($route['controller']) . 'Controller',
            'action'          => $route['action'],
            'actionMethod'    => $route['action'] . 'Action'
        );

        return $this;
    }

    /**
     * Get the request
     *
     * @return string[] Returns the request environment.
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * Dispatch the current request
     *
     * This function checks for the existence of the requested controller and
     * action and, if they exist, dispatches that action.
     *
     * @return void
     * @throws Exception Thrown if the controller or action don't exist.
     */
    public function dispatch()
    {
        $request = $this->getRequest();
        $controllerClass = $request['controllerClass'];
        $action = $request['actionMethod'];

        if (!class_exists($controllerClass)) {
            throw new Exception("Cannot find controller \"$controllerClass\"", 404);
        }

        $controllerInstance = new $controllerClass($this);

        if (!method_exists($controllerInstance, $action)) {
            throw new Exception("Cannot find action $controllerClass::$action()", 40);
        }

        $controllerInstance->preDispatch();

        // Call the action
        $controllerInstance->$action();

        $controllerInstance->postDispatch();
    }

    /**
     * Handle any exception thrown during processing of the request
     *
     * This function displays the message of the exception.
     *
     * @param Exception $exception Exception to display.
     * @return void
     */
    public function handleException(Exception $exception)
    {
        if (!headers_sent()) {
            // send the HTTP status code from the exception
            header('Content-Type: text/plain; charset=utf8', true, $exception->getCode());
        }

        echo 'Error: ' . $exception->getMessage();
    }
}
