<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/13/14
 * Time: 3:07 PM
 */

namespace TPPPTX\Type;
/**
 * Class SimpleAbstract
 * @package TPPPTX\Type
 */
abstract class SimpleAbstract
{

    /**
     * @var
     */
    protected $value = null;


    /**
     * @param $value
     */
    function __construct($value = null)
    {
        if ($value !== null)
            $this->value = $value;
    }


    /**
     * @return mixed
     */
    public function get()
    {
        if ($this->value === 'true') {
            return true;
        } else if ($this->value === 'false') {
            return false;
        }

        return $this->value;
    }


    /**
     * @param mixed $value
     */
    public function set($value)
    {
        $this->value = $value;
    }


    /**
     * @return bool
     */
    public function isPresent()
    {
        return $this->value === null ? false : true;
    }


    /**
     * @return mixed
     */
    function __toString()
    {
        return $this->value;
    }
}