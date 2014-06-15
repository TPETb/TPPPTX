<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/13/14
 * Time: 4:53 PM
 */

namespace TPPPTX\Type\Presentation\Main\Simple;


use TPPPTX\Type\SimpleAbstract;

/**
 * Class SlideSizeCoordinate
 * <xsd:simpleType name="ST_SlideSizeCoordinate">
 *     <xsd:restriction base="a:ST_PositiveCoordinate32">
 *         <xsd:minInclusive value="914400"/>
 *         <xsd:maxInclusive value="51206400"/>
 *     </xsd:restriction>
 * </xsd:simpleType>
 * @package TPPPTX\Type\Presentation\Main\Simple
 */
class SlideSizeCoordinate extends SimpleAbstract
{
    public function toCss()
    {
        return $this->value / 12700 . 'pt';
    }
} 