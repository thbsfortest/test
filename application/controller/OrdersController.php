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

    /**
     * Display action
     *
     * The page needs to include all the attributes of the customer and details of all of the products in their order.
     *
     * @param int $id Order ID
     *
     * @throws Exception
     *
     * @return void
     */
    public function displayAction($id)
    {
        $orders = new Orders();
        $orders->load('orders.xml');
        $order = $orders->getById($id);
        if (!$order) {
            throw new Exception("Model is not found");
        }

        $view = $this->getView();
        $view->order = $order;
        $view->dateFormat = 'd-m-y H:i:s';

        $view->customer = $order->getCustomer();
        if (!$view->customer) {
            throw new Exception("Customer is not found");
        }

        $view->products = $order->getProducts();
        if (!$view->products) {
            throw new Exception("Products is not found");
        }
    }
}
