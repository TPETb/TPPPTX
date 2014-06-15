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
 * Class TextAlignType
 * <xsd:simpleType name="ST_TextAlignType">
 *     <xsd:restriction base="xsd:token">
 *         <xsd:enumeration value="l"/>
 *         <xsd:enumeration value="ctr"/>
 *         <xsd:enumeration value="r"/>
 *         <xsd:enumeration value="just"/>
 *         <xsd:enumeration value="justLow"/>
 *         <xsd:enumeration value="dist"/>
 *         <xsd:enumeration value="thaiDist"/>
 *     </xsd:restriction>
 * </xsd:simpleType>
 * @package TPPPTX\Type\Drawing\Main\Simple
 */
class TextAlignType extends SimpleAbstract
{
    /**
     * @return string
     * @throws \Exception
     */
    public function toCss()
    {
        switch ($this->value) {
            case 'l':
                return 'left';
                break;
            case 'ctr':
                return 'center';
                break;
            case 'r':
                return 'right';
                break;
            case 'just':
            case 'justLow':
            case 'dist':
            case 'thaiDist':
                return 'justify';
                break;
        }
    }

} 