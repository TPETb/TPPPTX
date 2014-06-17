<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/13/14
 * Time: 4:23 PM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Presentation\Main\Simple\SlideSizeCoordinate;
use TPPPTX\Type\Presentation\Main\Simple\SlideSizeType;


/**
 * Class SlideSize
 * <xsd:complexType name="CT_SlideSize">
 *     <xsd:attribute name="cx" type="ST_SlideSizeCoordinate" use="required"/>
 *     <xsd:attribute name="cy" type="ST_SlideSizeCoordinate" use="required"/>
 *     <xsd:attribute name="type" type="ST_SlideSizeType" use="optional" default="custom"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Presentation\Main\Complex
 */
class SlideSize extends ComplexAbstract
{
    /**
     * @param $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'cx' => new SlideSizeCoordinate(0),
            'cy' => new SlideSizeCoordinate(0),
            'type' => new SlideSizeType('custom'),
        );

        parent::__construct($tagName, $attributes, $options);
    }


    public function toCssInline()
    {
        return 'width: ' . $this->cx->toCss() . '; height: ' . $this->cy->toCss() . ';';
    }


} 