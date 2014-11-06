<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 11/4/14
 * Time: 6:16 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\Percentage;

/**
 * class RelativeRect
 * <xsd:complexType name="CT_RelativeRect">
 *     <xsd:attribute name="l" type="ST_Percentage" use="optional" default="0%"/>
 *     <xsd:attribute name="t" type="ST_Percentage" use="optional" default="0%"/>
 *     <xsd:attribute name="r" type="ST_Percentage" use="optional" default="0%"/>
 *     <xsd:attribute name="b" type="ST_Percentage" use="optional" default="0%"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class RelativeRect extends ComplexAbstract
{
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'l' => new Percentage(0),
            't' => new Percentage(0),
            'r' => new Percentage(0),
            'b' => new Percentage(0),
        );

        parent::__construct($tagName, $attributes, $options);
    }


    public function toCssInline()
    {
        $rW = 100 / (100 - $this->attributes['l']->get() / 1000 - $this->attributes['r']->get() / 1000);
        $rH = 100 / (100 - $this->attributes['t']->get() / 1000 - $this->attributes['b']->get() / 1000);
        $dX = -(1 - $this->attributes['r']->get() / 1000 / 100 - 1 / $rW);
        $dY = -(1 - $this->attributes['b']->get() / 1000 / 100 - 1 / $rH);

        return ''
        . 'width: ' . ($rW * 100) . '%;'
        . 'height: ' . ($rH * 100) . '%;'
        . 'margin-left: ' . ($dX * 100) . '%;'
        . 'margin-top: ' . ($dY * 100) . '%;';
    }
} 