<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/15/14
 * Time: 3:16 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\Coordinate;

/**
 * Class Point2D
 * <xsd:complexType name="CT_Point2D">
 *     <xsd:attribute name="x" type="ST_Coordinate" use="required"/>
 *     <xsd:attribute name="y" type="ST_Coordinate" use="required"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class Point2D extends ComplexAbstract {
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'x' => new Coordinate(),
            'y' => new Coordinate(),
        );

        parent::__construct($tagName, $attributes, $options);
    }

} 