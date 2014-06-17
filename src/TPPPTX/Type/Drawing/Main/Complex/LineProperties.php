<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/14/14
 * Time: 11:35 AM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\CompoundLine;
use TPPPTX\Type\Drawing\Main\Simple\LineCap;
use TPPPTX\Type\Drawing\Main\Simple\LineWidth;
use TPPPTX\Type\Drawing\Main\Simple\PenAlignment;

/**
 * Class LineProperties
 * <xsd:complexType name="CT_LineProperties">
 *     <xsd:sequence>
 *         <xsd:group ref="EG_LineFillProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:group ref="EG_LineDashProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:group ref="EG_LineJoinProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="headEnd" type="CT_LineEndProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="tailEnd" type="CT_LineEndProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_OfficeArtExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="w" type="ST_LineWidth" use="optional"/>
 *     <xsd:attribute name="cap" type="ST_LineCap" use="optional"/>
 *     <xsd:attribute name="cmpd" type="ST_CompoundLine" use="optional"/>
 *     <xsd:attribute name="algn" type="ST_PenAlignment" use="optional"/>
 * </xsd:complexType>
 *
 * <xsd:group name="EG_LineFillProperties">
 *     <xsd:choice>
 *         <xsd:element name="noFill" type="CT_NoFillProperties" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="solidFill" type="CT_SolidColorFillProperties" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="gradFill" type="CT_GradientFillProperties" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="pattFill" type="CT_PatternFillProperties" minOccurs="1" maxOccurs="1"/>
 *     </xsd:choice>
 * </xsd:group>
 *
 * <xsd:group name="EG_LineDashProperties">
 *     <xsd:choice>
 *         <xsd:element name="prstDash" type="CT_PresetLineDashProperties" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="custDash" type="CT_DashStopList" minOccurs="1" maxOccurs="1"/>
 *     </xsd:choice>
 * </xsd:group>
 *
 * <xsd:group name="EG_LineJoinProperties">
 *     <xsd:choice>
 *         <xsd:element name="round" type="CT_LineJoinRound" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="bevel" type="CT_LineJoinBevel" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="miter" type="CT_LineJoinMiterProperties" minOccurs="1" maxOccurs="1"/>
 *     </xsd:choice>
 * </xsd:group>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class LineProperties extends ComplexAbstract
{
    protected $sequence = array(
//        'noFill' => 'Drawing\\Main\\Complex\\NoFillProperties',
        'solidFill' => 'Drawing\\Main\\Complex\\SolidColorFillProperties',
//        'gradFill' => 'Drawing\\Main\\Complex\\GradientFillProperties',
//        'pattFill' => 'Drawing\\Main\\Complex\\PatternFillProperties',
//
//        'prstDash' => 'Drawing\\Main\\Complex\\PresetLineDashProperties',
//        'custDash' => 'Drawing\\Main\\Complex\\DashStopList',
//
//        'round' => 'Drawing\\Main\\Complex\\LineJoinRound',
//        'bevel' => 'Drawing\\Main\\Complex\\LineJoinBevel',
//        'miter' => 'Drawing\\Main\\Complex\\LineJoinMiterProperties',
//
//        'headEnd' => 'Drawing\\Main\\Complex\\LineEndProperties',
//        'tailEnd' => 'Drawing\\Main\\Complex\\LineEndProperties',
//        'extLst' => 'Drawing\\Main\\Complex\\OfficeArtExtensionList',
    );


    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'w' => new LineWidth(),
            'cap' => new LineCap(),
            'cmpd' => new CompoundLine(),
            'algn' => new PenAlignment(),
        );

        parent::__construct($tagName, $attributes, $options);
    }


    public function toCssInline()
    {
        $style = '';

        if ($tmp = $this->child('solidFill')) {
            $style .= ' border-color:' . $tmp->toCss() . ';';
        }

        $style .= ' border-style: solid; border-width:' . $this->w->toCss() . ';';

        return $style;
    }
}