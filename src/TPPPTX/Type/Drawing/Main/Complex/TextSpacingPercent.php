<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/13/14
 * Time: 8:14 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;

use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\TextSpacingPercentOrPercentString;

/**
 * Class TextSpacingPercent
 * <xsd:complexType name="CT_TextSpacingPercent">
 *     <xsd:attribute name="val" type="ST_TextSpacingPercentOrPercentString" use="required"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class TextSpacingPercent extends ComplexAbstract {

    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'val' => new TextSpacingPercentOrPercentString()
        );

        parent::__construct($tagName, $attributes, $options);
    }
}