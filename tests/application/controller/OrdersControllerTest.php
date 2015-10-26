<?php

class OrdersControllerTest extends PHPUnit_Framework_TestCase
{
    protected $_controller;

    /**
     * Base URL
     *
     * In good practice this variable should be placed in the config
     */
    const BASE_URL = "http://test.300rub.net/";

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

    /**
     * Test for the “display” action created in Stage 1 and the routing changes made in Stage 3.
     */
    public function testActionDisplay()
    {
        $html1 = $this->_getPageHtml(self::BASE_URL . "orders/1/");
        $html2 = $this->_getPageHtml(self::BASE_URL . "orders/display?id=1");
        $this->assertEquals($html1, $html2);
    }

    /**
     * Gets HTML code by URL
     *
     * @param string $url URL
     *
     * @return string
     */
    private function _getPageHtml($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
        return curl_exec($curl);
    }
}
