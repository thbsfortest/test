<?php

/**
 * Orders controller
 *
 * @category  TechTest
 * @package   TechTest
 * @copyright 2011 Everything Everywhere
 */

/**
 * Orders controller
 *
 * This class is the controller used to display order information in the
 * application.
 *
 * @category TechTest
 * @package  TechTest
 * @author   Customer Interactions <tactical.cs@everythingeverywhere.com>
 */
class OrdersController extends ControllerAbstract
{
    /**
     * Index action
     *
     * This action is shown when visiting /orders or /orders/index and displays
     * a list of the order details to the browser.
     *
     * @return void
     */
    public function indexAction()
    {
        $orders = new Orders();
        $orders->load('orders.xml');

        $view = $this->getView();
        $view->orders = $orders;
        $view->dateFormat = 'd-m-y H:i:s';
    }
}
