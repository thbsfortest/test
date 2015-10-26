<?php

/**
 * Abstract model
 *
 * @category  TechTest
 * @package   TechTest
 * @copyright 2011 Everything Everywhere
 */

/**
 * Abstract model
 *
 * This class is the generic representation of a data structure. It can load
 * its data structure from an XML file and variables can be accessed using
 * array notation or using object-orientated accessors.
 *
 * @category TechTest
 * @package  TechTest
 * @author   Customer Interactions <tactical.cs@everythingeverywhere.com>
 */
abstract class ModelAbstract extends ArrayObject
{
    /**
     * Get a key as a member variable
     *
     * @param scalar $key Name of the variable.
     * @return mixed Returns the value at the specified index or false.
     */
    public function __get($key)
    {
        return $this->offsetGet($key);
    }

    /**
     * Set a key via a member variable
     *
     * @param scalar $key   Name of the variable.
     * @param mixed  $value Value to set.
     * @return void
     */
    public function __set($key, $value)
    {
        $this->offsetSet($key, $value);
    }

    /**
     * Get whether a key is set
     *
     * @param scalar $key Name of the variable.
     * @return bool Returns whether the specified index exists.
     */
    public function __isset($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * Unset a key
     *
     * @param scalar $key Name of the variable.
     * @return void
     */
    public function __unset($key)
    {
        $this->offsetUnset($key);
    }

    /**
     * Convert a SimpleXMLElement object to an array
     *
     * Recursively converts. Will instantiate a relevant model if one exists.
     * Does not handle XML attributes.
     *
     * @param SimpleXMLElement $element Element to convert.
     * @return array Returns an array representation of the XML element.
     */
    protected function _toArray(SimpleXMLElement $element)
    {
        $keys = $array = array();

        foreach ($element as $key => $child) {
            $parsed = $this->_toArray($child);
            $class = ucfirst($key);

            // use string representation if no child elements
            if (empty($parsed)) {
                $parsed = (string) $child;
            } elseif (class_exists($class)) {
                $parsed = new $class($parsed);
            }

            // check if there are multiple child elements with the same name
            if (in_array($key, $keys)) {
                if (array_key_exists($key, $array)) {
                    $array[] = $array[$key];
                    unset($array[$key]);
                }

                $array[] = $parsed;
            } else {
                $keys[] = $key;
                $array[$key] = $parsed;
            }
        }

        return $array;
    }

    /**
     * Load model data from an XML file
     *
     * @param string $file Name of the file to load.
     * @return void
     * @throws Exception Thrown if the file cannot be accessed.
     */
    public function load($file)
    {
        $file = DATA_PATH . DIRECTORY_SEPARATOR . $file;

        if (!file_exists($file) || !is_readable($file)) {
            throw new Exception("Cannot access data file $file", 500);
        }

        $array = $this->_toArray(new SimpleXMLElement($file, 0, true));
        $this->exchangeArray($array);
    }
}
