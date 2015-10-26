<?php

/**
 * Order model
 *
 * @category  TechTest
 * @package   TechTest
 * @copyright 2011 Everything Everywhere
 */

/**
 * Order model
 *
 * This class represents a single order within the system.
 *
 * @category TechTest
 * @package  TechTest
 * @author   Customer Interactions <tactical.cs@everythingeverywhere.com>
 */
class Order extends ModelAbstract
{
    /**
     * Associated customer object
     *
     * @var Customer
     */
    protected $_customer;

    /**
     * Get the associated customer object
     *
     * This function loads the customer data and finds the matching customer
     * for this order.
     *
     * @return Customer Returns the customer object.
     */
    public function getCustomer()
    {
        if (null === $this->_customer && isset($this->customer)) {
            $customers = new Customers();
            $customers->load('customers.xml');

            foreach ($customers as $customer) {
                if ($this->customer == $customer->id) {
                    $this->_customer = $customer;
                    break;
                }
            }
        }

        return $this->_customer;
    }

    /**
     * Get the order date in a given format
     *
     * @param string $format Format of the outputted date string.
     * @return string Returns the formatted date string.
     * @see date()
     */
    public function getDate($format)
    {
        return date($format, strtotime($this->date));
    }
}