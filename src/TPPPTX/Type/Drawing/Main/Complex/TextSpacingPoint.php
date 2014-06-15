<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/13/14
 * Time: 8:15 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;

use TPPPTX\Type\ComplexAbstract;

/**
 * Class TextSpacingPoint
 * <xsd:complexType name="CT_TextSpacingPoint">
 *     <xsd:attribute name="val" type="ST_TextSpacingPoint" use="required"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class TextSpacingPoint extends ComplexAbstract {

    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'val' => new \TPPPTX\Type\Drawing\Main\Simple\TextSpacingPoint()
        );

        parent::__construct($tagName = '', $attributes, $options);
    }
}