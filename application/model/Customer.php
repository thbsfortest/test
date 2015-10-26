<?php

/**
 * Customer model
 *
 * @category  TechTest
 * @package   TechTest
 * @copyright 2011 Everything Everywhere
 */

/**
 * Customer model
 *
 * This class represents a single customer within the system.
 *
 * @category TechTest
 * @package  TechTest
 * @author   Customer Interactions <tactical.cs@everythingeverywhere.com>
 */
class Customer extends ModelAbstract
{
    /**
     * Get the customer's name
     *
     * @return string
     */
    public function getName()
    {
        return implode(' ', $this->name);
    }

    /**
     * Get the customer's address
     *
     * @return string
     */
    public function getAddress()
    {
        return implode(' ', $this->address);
    }
}