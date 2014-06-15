<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/14/14
 * Time: 11:13 AM
 */

namespace TPPPTX\Type\Drawing\Main\Simple;

use TPPPTX\Type\SimpleAbstract;


/**
 * Class TextFontSize
 * <xsd:simpleType name="ST_TextFontSize">
 *     <xsd:restriction base="xsd:int">
 *         <xsd:minInclusive value="100"/>
 *         <xsd:maxInclusive value="400000"/>
 *     </xsd:restriction>
 * </xsd:simpleType>
 * @package TPPPTX\Type\Drawing\Main\Simple
 */
class TextFontSize extends SimpleAbstract
{
    /**
     * @return float
     */
    public function toCss()
    {
        return $this->value / 100 . 'pt';
    }
}
