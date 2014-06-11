<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/21/14
 * Time: 4:13 PM
 */

namespace TPPPTX\Parser;


/**
 * Class Registry
 * @package TPPPTX\Parser
 */
class Registry implements \ArrayAccess
{

    /**
     * @var array
     */
    protected $registry = array();

    /**
     * @param $filepath
     * @param $value
     * @return mixed
     */
    public function set($filepath, $value)
    {
        return $this->registry[$filepath] = $value;
    }


    /**
     * @param $filepath
     * @return mixed
     */
    public function get($filepath)
    {
        return $this->registry[$filepath];
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->registry[$offset]);
    }

    /**
     * @param mixed $offset
     * @return null
     */
    public function offsetGet($offset)
    {
        return isset($this->registry[$offset]) ? $this->registry[$offset] : null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @return mixed
     */
    public function offsetSet($offset, $value)
    {
        return $this->registry[$offset] = $value;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetUnset($offset)
    {
        unset($this->registry[$offset]);

        return true;
    }
}