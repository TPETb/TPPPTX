<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/13/14
 * Time: 8:19 PM
 */

namespace TPPPTX\Type\Drawing\Main\Simple;


use TPPPTX\Type\SimpleAbstract;

/**
 * Class TextSpacingPoint
 * <xsd:simpleType name="ST_TextSpacingPoint">
 *     <xsd:restriction base="xsd:int">
 *         <xsd:minInclusive value="0"/>
 *         <xsd:maxInclusive value="158400"/>
 *     </xsd:restriction>
 * </xsd:simpleType>
 * @package TPPPTX\Type\Drawing\Main\Simple
 */
class TextSpacingPoint extends SimpleAbstract
{
    /**
     * @return string
     * @throws \Exception
     */
    public function toCss()
    {
        return round($this->value / 12700) . 'pt';
    }
} 