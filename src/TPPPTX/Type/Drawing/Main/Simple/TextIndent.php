<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/13/14
 * Time: 7:09 PM
 */

namespace TPPPTX\Type\Drawing\Main\Simple;


use TPPPTX\Type\SimpleAbstract;

/**
 * Class TextIndent
 * <xsd:simpleType name="ST_TextIndent">
 *     <xsd:restriction base="ST_Coordinate32Unqualified">
 *         <xsd:minInclusive value="-51206400"/>
 *         <xsd:maxInclusive value="51206400"/>
 *     </xsd:restriction>
 * </xsd:simpleType>
 * @package TPPPTX\Type\Drawing\Main\Simple
 */
class TextIndent extends SimpleAbstract
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