<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/23/14
 * Time: 6:06 PM
 */

namespace TPPPTX\PageGenerator;


/**
 * Class UnitConverter
 * @package TPPPTX\PageGenerator
 * @todo "unstatic" this class
 */
class UnitConverter
{

    /**
     * @var int
     */
    protected static $scale = 1;


    /**
     * @param array $options
     */
    function __construct(array $options = array())
    {
        $this->setOptions($options);
    }


    /**
     * @param $emus
     * @return float
     */
    public static function convertEmu($emus)
    {
        return $emus / 12700 * self::$scale;
    }


    /**
     * @param $percent
     * @return float
     */
    public static function convertPercent($percent)
    {
        return $percent / 10000 * self::$scale;
    }


    /**
     * @param $points
     * @return float
     */
    public static function convertFontPoints($points)
    {
        return $points / 100 * self::$scale;
    }


    public static function convertDegree($degree)
    {
        return $degree / 60000;
    }


    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        foreach ($options as $property => $value) {
            if (method_exists($this, 'set' . ucfirst($property))) {
                $this->{'set' . ucfirst($property)}($value);
            }
        }
    }

    /**
     * @param int $scale
     */
    public static function setScale($scale)
    {
        self::$scale = $scale;
    }

    /**
     * @return int
     */
    public static function getScale()
    {
        return self::$scale;
    }

}