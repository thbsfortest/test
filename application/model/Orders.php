<?php

/**
 * Order collection model
 *
 * @category  TechTest
 * @package   TechTest
 * @copyright 2011 Everything Everywhere
 */

/**
 * Order collection model
 *
 * This class represents a collection of orders within the system. It should
 * contain an array of {@link Order} objects.
 *
 * @category TechTest
 * @package  TechTest
 * @author   Customer Interactions <tactical.cs@everythingeverywhere.com>
 */
class Orders extends ModelAbstract
{
    /**
     * Get order by a given ID
     *
     * This function retrieves an {@link Order} with a given ID.
     *
     * @param int $id The ID of the order.
     * @return Order Returns the order with the matching ID, or null if not found.
     */
    public function getById($id)
    {
        foreach ($this as $order) {
            if (intval($order->id) === $id) {
                return $order;
            }
        }

        return null;
    }
}
