<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/14/14
 * Time: 12:38 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Shared\CommonSimpleTypes\Simple\HexColorRGB;

/**
 * Class SRgbColor
 * <xsd:complexType name="CT_SRgbColor">
 *     <xsd:sequence>
 *         <xsd:group ref="EG_ColorTransform" minOccurs="0" maxOccurs="unbounded"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="val" type="s:ST_HexColorRGB" use="required"/>
 * </xsd:complexType>
 *
 * <xsd:group name="EG_ColorTransform">
 *     <xsd:choice>
 *         <xsd:element name="tint" type="CT_PositiveFixedPercentage" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="shade" type="CT_PositiveFixedPercentage" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="comp" type="CT_ComplementTransform" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="inv" type="CT_InverseTransform" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="gray" type="CT_GrayscaleTransform" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="alpha" type="CT_PositiveFixedPercentage" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="alphaOff" type="CT_FixedPercentage" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="alphaMod" type="CT_PositivePercentage" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="hue" type="CT_PositiveFixedAngle" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="hueOff" type="CT_Angle" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="hueMod" type="CT_PositivePercentage" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="sat" type="CT_Percentage" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="satOff" type="CT_Percentage" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="satMod" type="CT_Percentage" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="lum" type="CT_Percentage" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="lumOff" type="CT_Percentage" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="lumMod" type="CT_Percentage" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="red" type="CT_Percentage" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="redOff" type="CT_Percentage" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="redMod" type="CT_Percentage" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="green" type="CT_Percentage" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="greenOff" type="CT_Percentage" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="greenMod" type="CT_Percentage" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="blue" type="CT_Percentage" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="blueOff" type="CT_Percentage" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="blueMod" type="CT_Percentage" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="gamma" type="CT_GammaTransform" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="invGamma" type="CT_InverseGammaTransform" minOccurs="1" maxOccurs="1"/>
 *     </xsd:choice>
 * </xsd:group>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class SRgbColor extends ComplexAbstract
{
    /**
     * @param $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'val' => new HexColorRGB()
        );

        parent::__construct($tagName = '', $attributes, $options);
    }


    /**
     * @return string
     */
    public function toCss()
    {
        return
            '#' . $this->val;
    }
} 