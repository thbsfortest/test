<?php

class OrdersControllerTest extends PHPUnit_Framework_TestCase
{
    protected $_controller;

    protected function setUp()
    {
        $this->_controller = $this->getMock(
            'OrdersController',
            array('getView'),
            array(),
            '',
            false
        );
        $this->_controller->expects($this->any())
                          ->method('getView')
                          ->will($this->returnValue(new View('', '')));
    }

    public function testDateFormat()
    {
        $this->_controller->indexAction();

        $this->assertSame('d-m-y H:i:s', $this->_controller->getView()->dateFormat);
    }

    public function testOrders()
    {
        $this->_controller->indexAction();

        $this->assertInstanceOf('Orders', $this->_controller->getView()->orders);
        $this->assertSame(3, $this->_controller->getView()->orders->count());
    }
}
