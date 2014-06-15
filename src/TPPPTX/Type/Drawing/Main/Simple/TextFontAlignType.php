<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/13/14
 * Time: 7:10 PM
 */

namespace TPPPTX\Type\Drawing\Main\Simple;


use TPPPTX\Type\SimpleAbstract;

/**
 * Class TextFontAlignType
 * <xsd:simpleType name="ST_TextFontAlignType">
 *     <xsd:restriction base="xsd:token">
 *         <xsd:enumeration value="auto"/>
 *         <xsd:enumeration value="t"/>
 *         <xsd:enumeration value="ctr"/>
 *         <xsd:enumeration value="base"/>
 *         <xsd:enumeration value="b"/>
 *     </xsd:restriction>
 * </xsd:simpleType>
 * @package TPPPTX\Type\Drawing\Main\Simple
 */
class TextFontAlignType extends SimpleAbstract
{
    /**
     * @return string
     * @throws \Exception
     */
    public function toCss()
    {
        switch ($this->value) {
            case 'auto':
                return 'initial';
                break;
            case 't':
                return 'top';
                break;
            case 'ctr':
                return 'middle';
                break;
            case 'base':
                return 'baseline';
                break;
            case 'b':
                return 'bottom';
                break;
        }
    }
} 