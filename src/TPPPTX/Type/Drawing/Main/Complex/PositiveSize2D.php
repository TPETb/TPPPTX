<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/13/14
 * Time: 3:35 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\PositiveCoordinate;

/**
 * Class PositiveSize2D
 * <xsd:complexType name="CT_PositiveSize2D">
 *     <xsd:attribute name="cx" type="ST_PositiveCoordinate" use="required"/>
 *     <xsd:attribute name="cy" type="ST_PositiveCoordinate" use="required"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class PositiveSize2D extends ComplexAbstract
{
    /**
     * @param $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'cx' => new PositiveCoordinate(0),
            'cy' => new PositiveCoordinate(0),
        );

        parent::__construct($tagName = '', $attributes, $options);
    }

} 