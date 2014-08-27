<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 8/27/14
 * Time: 11:38 AM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\PositivePercentage;

class LineJoinMiterProperties extends ComplexAbstract
{
    /**
     * @param string $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'lim' => new PositivePercentage(),
        );

        parent::__construct($tagName, $attributes, $options);
    }


    public function toCss()
    {
        return 'round';
    }
}