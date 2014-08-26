<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/13/14
 * Time: 8:17 PM
 */

namespace TPPPTX\Type\Drawing\Main\Simple;


/**
 * Class TextSpacingPercentOrPercentString
 * <xsd:simpleType name="ST_TextSpacingPercentOrPercentString">
 *     <xsd:union memberTypes="s:ST_Percentage"/>
 * </xsd:simpleType>
 *
 * <xsd:simpleType name="ST_Percentage">
 *     <xsd:restriction base="xsd:string">
 *         <xsd:pattern value="-?[0-9]+(\.[0-9]+)?%"/>
 *     </xsd:restriction>
 * </xsd:simpleType>
 * @package TPPPTX\Type\Drawing\Main\Simple
 */
class TextSpacingPercentOrPercentString extends \TPPPTX\Type\Shared\CommonSimpleTypes\Simple\Percentage
{
    /**
     * @return string
     * @throws \Exception
     */
    public function toCss()
    {
        return $this->value / 100000 . 'em';
    }
} 