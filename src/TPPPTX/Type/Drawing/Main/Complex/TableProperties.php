<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 11/13/14
 * Time: 1:31 AM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class TableProperties
 * <xsd:complexType name="CT_TableProperties">
 *     <xsd:sequence>
 *         <xsd:group ref="EG_FillProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:group ref="EG_EffectProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:choice minOccurs="0" maxOccurs="1">
 *             <xsd:element name="tableStyle" type="CT_TableStyle"/>
 *             <xsd:element name="tableStyleId" type="s:ST_Guid"/>
 *         </xsd:choice>
 *         <xsd:element name="extLst" type="CT_OfficeArtExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="rtl" type="xsd:boolean" use="optional" default="false"/>
 *     <xsd:attribute name="firstRow" type="xsd:boolean" use="optional" default="false"/>
 *     <xsd:attribute name="firstCol" type="xsd:boolean" use="optional" default="false"/>
 *     <xsd:attribute name="lastRow" type="xsd:boolean" use="optional" default="false"/>
 *     <xsd:attribute name="lastCol" type="xsd:boolean" use="optional" default="false"/>
 *     <xsd:attribute name="bandRow" type="xsd:boolean" use="optional" default="false"/>
 *     <xsd:attribute name="bandCol" type="xsd:boolean" use="optional" default="false"/>
 * </xsd:complexType>
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
 *
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class TableProperties extends ComplexAbstract
{

    /**
     * @var array
     */
    protected $sequence = array(
        'tableStyle' => 'Drawing\\Main\\Complex\\TableStyle',
        'tableStyleId' => 'ComplexConcrete',

        'noFill' => 'Drawing\\Main\\Complex\\NoFillProperties',
        'solidFill' => 'Drawing\\Main\\Complex\\SolidColorFillProperties',
        'gradFill' => 'Drawing\\Main\\Complex\\GradientFillProperties',
        'blipFill' => 'Drawing\\Main\\Complex\\BlipFillProperties',
        'pattFill' => 'Drawing\\Main\\Complex\\PatternFillProperties',
        'grpFill' => 'Drawing\\Main\\Complex\\GroupFillProperties',

        'effectLst' => 'Drawing\\Main\\Complex\\EffectList',
        'effectDag' => 'Drawing\\Main\\Complex\\EffectContainer',
    );


    /**
     * @param $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'rtl' => false,
            'firstRow' => false,
            'firstCol' => false,
            'lastRow' => false,
            'lastCol' => false,
            'bandRow' => false,
            'bandCol' => false,
        );

        parent::__construct($tagName, $attributes, $options);
    }


    /**
     * @param \DOMDocument $dom
     * @param array $options
     * @return null
     */
    public function toHtmlDom(\DOMDocument $dom, $options = array())
    {
        return null;
    }
} 