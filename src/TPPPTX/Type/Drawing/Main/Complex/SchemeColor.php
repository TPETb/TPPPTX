<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/14/14
 * Time: 12:39 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ModifiableColor;
use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\SchemeColorVal;

/**
 * Class SchemeColor
 * <xsd:complexType name="CT_SchemeColor">
 *     <xsd:sequence>
 *         <xsd:group ref="EG_ColorTransform" minOccurs="0" maxOccurs="unbounded"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="val" type="ST_SchemeColorVal" use="required"/>
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
class SchemeColor extends ComplexAbstract {
    use ModifiableColor;


    protected $sequence = array(
        'tint' => 'Drawing\\Main\\Complex\\PositiveFixedPercentage',
        'shade' => 'Drawing\\Main\\Complex\\PositiveFixedPercentage',
        'comp' => 'Drawing\\Main\\Complex\\ComplementTransform',
        'inv' => 'Drawing\\Main\\Complex\\InverseTransform',
        'gray' => 'Drawing\\Main\\Complex\\GrayscaleTransform',
        'alpha' => 'Drawing\\Main\\Complex\\PositiveFixedPercentage',
        'alphaOff' => 'Drawing\\Main\\Complex\\FixedPercentage',
        'alphaMod' => 'Drawing\\Main\\Complex\\PositivePercentage',
        'hue' => 'Drawing\\Main\\Complex\\PositiveFixedAngle',
        'hueOff' => 'Drawing\\Main\\Complex\\Angle',
        'hueMod' => 'Drawing\\Main\\Complex\\PositivePercentage',
        'sat' => 'Drawing\\Main\\Complex\\Percentage',
        'satOff' => 'Drawing\\Main\\Complex\\Percentage',
        'satMod' => 'Drawing\\Main\\Complex\\Percentage',
        'lum' => 'Drawing\\Main\\Complex\\Percentage',
        'lumOff' => 'Drawing\\Main\\Complex\\Percentage',
        'lumMod' => 'Drawing\\Main\\Complex\\Percentage',
        'red' => 'Drawing\\Main\\Complex\\Percentage',
        'redOff' => 'Drawing\\Main\\Complex\\Percentage',
        'redMod' => 'Drawing\\Main\\Complex\\Percentage',
        'green' => 'Drawing\\Main\\Complex\\Percentage',
        'greenOff' => 'Drawing\\Main\\Complex\\Percentage',
        'greenMod' => 'Drawing\\Main\\Complex\\Percentage',
        'blue' => 'Drawing\\Main\\Complex\\Percentage',
        'blueOff' => 'Drawing\\Main\\Complex\\Percentage',
        'blueMod' => 'Drawing\\Main\\Complex\\Percentage',
        'gamma' => 'Drawing\\Main\\Complex\\GammaTransform',
        'invGamma' => 'Drawing\\Main\\Complex\\InverseGammaTransform',
    );

    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'val' => new SchemeColorVal()
        );

        parent::__construct($tagName, $attributes, $options);
    }


    public function toCss()
    {
        return $this->applyModifications($this->root->getMaster()->getSchemeColor($this->val->get()));
    }

} 