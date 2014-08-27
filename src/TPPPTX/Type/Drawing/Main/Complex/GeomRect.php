<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 8/27/14
 * Time: 5:47 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\AdjCoordinate;

/**
 * Class GeomRect
 * <xsd:complexType name="CT_GeomRect">
 *     <xsd:attribute name="l" type="ST_AdjCoordinate" use="required"/>
 *     <xsd:attribute name="t" type="ST_AdjCoordinate" use="required"/>
 *     <xsd:attribute name="r" type="ST_AdjCoordinate" use="required"/>
 *     <xsd:attribute name="b" type="ST_AdjCoordinate" use="required"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class GeomRect extends ComplexAbstract
{
    /**
     * @param $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'l' => new AdjCoordinate(),
            't' => new AdjCoordinate(),
            'r' => new AdjCoordinate(),
            'b' => new AdjCoordinate(),
        );

        parent::__construct($tagName, $attributes, $options);
    }
} 