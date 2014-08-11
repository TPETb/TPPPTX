<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 8/11/14
 * Time: 5:34 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\Percentage;

/**
 * Class PositivePercentage
 * <xsd:complexType name="CT_PositivePercentage">
 *     <xsd:attribute name="val" type="ST_Percentage" use="required"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class PositivePercentage extends ComplexAbstract {
    /**
     * @param $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'val' => new Percentage()
        );

        parent::__construct($tagName, $attributes, $options);
    }
} 