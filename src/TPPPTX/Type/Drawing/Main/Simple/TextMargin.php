<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/13/14
 * Time: 7:05 PM
 */

namespace TPPPTX\Type\Drawing\Main\Simple;


use TPPPTX\Type\SimpleAbstract;

/**
 * Class TextMargin
 * <xsd:simpleType name="ST_TextMargin">
 *     <xsd:restriction base="ST_Coordinate32Unqualified">
 *         <xsd:minInclusive value="0"/>
 *         <xsd:maxInclusive value="51206400"/>
 *     </xsd:restriction>
 * </xsd:simpleType>
 * @package TPPPTX\Type\Drawing\Main\Simple
 */
class TextMargin extends SimpleAbstract
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