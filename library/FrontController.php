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
     * Regular expressions for the routing patterns
     *
     * On good it should be like this:
     * '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>'
     * and transferred to the config
     *
     * @var array
     */
    private $_urlManager = array(
        '#^/(?P<controller>\w+)?(?:/(?P<id>\d+))#',
        '#^/(?P<controller>\w+)?(?:/(?P<action>\w+))?#'
    );

    /**
     * Default action for URL like /controller/ID
     */
    const DEFAULT_ACTION_FOR_ID = "display";

    /**
     * Default routing options
     *
     * @var string[]
     */
    protected $_defaults = array(
        'controller' => 'default',
        'action'     => 'index',
        'id'         => 0,
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
        $matches = false;
        foreach ($this->_urlManager as $mask) {
            if (0 !== preg_match($mask, $requestUri, $matches)) {
                break;
            }
        }
        if (!$matches) {
            throw new Exception("Cannot set request from URI $requestUri", 404);
        }

        $route = array_merge($this->_defaults, $matches);

        $this->_request = array(
            'uri'             => $requestUri,
            'controller'      => $route['controller'],
            'controllerClass' => ucfirst($route['controller']) . 'Controller',
            'action'          => $route['id'] ? self::DEFAULT_ACTION_FOR_ID : $route['action'],
            'actionMethod'    => $route['id'] ? self::DEFAULT_ACTION_FOR_ID . 'Action' : $route['action'] . 'Action',
            'id'              => $route['id'] ? $route['id'] : (!empty($_GET["id"]) ? $_GET["id"] : 0),
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
        $id = intval($request['id']);

        if (!class_exists($controllerClass)) {
            throw new Exception("Cannot find controller \"$controllerClass\"", 404);
        }

        $controllerInstance = new $controllerClass($this);

        if (!method_exists($controllerInstance, $action)) {
            throw new Exception("Cannot find action $controllerClass::$action()", 40);
        }

        $controllerInstance->preDispatch();

        // Call the action
        if ($id) {
            $controllerInstance->$action($id);
        } else {
            $controllerInstance->$action();
        }


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
