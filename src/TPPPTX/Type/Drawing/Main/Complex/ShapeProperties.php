<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/15/14
 * Time: 4:45 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\BlackWhiteMode;

/**
 * Class ShapeProperties
 * <xsd:complexType name="CT_ShapeProperties">
 *     <xsd:sequence>
 *         <xsd:element name="xfrm" type="CT_Transform2D" minOccurs="0" maxOccurs="1"/>
 *         <xsd:group ref="EG_Geometry" minOccurs="0" maxOccurs="1"/>
 *         <xsd:group ref="EG_FillProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="ln" type="CT_LineProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:group ref="EG_EffectProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="scene3d" type="CT_Scene3D" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="sp3d" type="CT_Shape3D" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_OfficeArtExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="bwMode" type="ST_BlackWhiteMode" use="optional"/>
 * </xsd:complexType>
 *
 * <xsd:group name="EG_Geometry">
 *     <xsd:choice>
 *         <xsd:element name="custGeom" type="CT_CustomGeometry2D" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="prstGeom" type="CT_PresetGeometry2D" minOccurs="1" maxOccurs="1"/>
 *     </xsd:choice>
 * </xsd:group>
 *
 * <xsd:group name="EG_FillProperties">
 *     <xsd:choice>
 *         <xsd:element name="noFill" type="CT_NoFillProperties" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="solidFill" type="CT_SolidColorFillProperties" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="gradFill" type="CT_GradientFillProperties" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="blipFill" type="CT_BlipFillProperties" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="pattFill" type="CT_PatternFillProperties" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="grpFill" type="CT_GroupFillProperties" minOccurs="1" maxOccurs="1"/>
 *     </xsd:choice>
 * </xsd:group>
 *
 * <xsd:group name="EG_EffectProperties">
 *     <xsd:choice>
 *         <xsd:element name="effectLst" type="CT_EffectList" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="effectDag" type="CT_EffectContainer" minOccurs="1" maxOccurs="1"/>
 *     </xsd:choice>
 * </xsd:group>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class ShapeProperties extends ComplexAbstract
{

    protected $sequence = array(
        'xfrm' => 'Drawing\\Main\\Complex\\Transform2D',

//        'custGeom' => 'Drawing\\Main\\Complex\\CustomGeometry2D',
//        'prstGeom' => 'Drawing\\Main\\Complex\\PresetGeometry2D',

        'noFill' => 'Drawing\\Main\\Complex\\NoFillProperties',
        'solidFill' => 'Drawing\\Main\\Complex\\SolidColorFillProperties',
        'gradFill' => 'Drawing\\Main\\Complex\\GradientFillProperties',
        'blipFill' => 'Drawing\\Main\\Complex\\BlipFillProperties',
        'pattFill' => 'Drawing\\Main\\Complex\\PatternFillProperties',
        'grpFill' => 'Drawing\\Main\\Complex\\GroupFillProperties',

        'ln' => 'Drawing\\Main\\Complex\\LineProperties',

//        'effectLst' => 'Drawing\\Main\\Complex\\EffectList',
//        'effectDag' => 'Drawing\\Main\\Complex\\EffectContainer',

//        'scene3d' => 'Drawing\\Main\\Complex\\Scene3D',
//        'sp3d' => 'Drawing\\Main\\Complex\\Shape3D',
//        'extLst' => 'Drawing\\Main\\Complex\\OfficeArtExtensionList',
    );


    /**
     * @param string $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'bwMode' => new BlackWhiteMode(),
        );

        parent::__construct($tagName, $attributes, $options);
    }


    /**
     *
     * @todo add support for fills
     */
    public function toCssInline()
    {
        $style = '';

        if ($tmp = $this->child('xfrm')) {
            $style .= $tmp->toCssInline();
        }

        if ($tmp = $this->child('ln')) {
            $style .= $tmp->toCssInline();
        }

        return $style;
    }
} 