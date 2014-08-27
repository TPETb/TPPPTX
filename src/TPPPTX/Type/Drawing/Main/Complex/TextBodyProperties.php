<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/15/14
 * Time: 5:02 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\Angle;
use TPPPTX\Type\Drawing\Main\Simple\Coordinate32;
use TPPPTX\Type\Drawing\Main\Simple\PositiveCoordinate32;
use TPPPTX\Type\Drawing\Main\Simple\TextAnchoringType;
use TPPPTX\Type\Drawing\Main\Simple\TextColumnCount;
use TPPPTX\Type\Drawing\Main\Simple\TextHorzOverflowType;
use TPPPTX\Type\Drawing\Main\Simple\TextVerticalType;
use TPPPTX\Type\Drawing\Main\Simple\TextVertOverflowType;
use TPPPTX\Type\Drawing\Main\Simple\TextWrappingType;

/**
 * Class TextBodyProperties
 * <xsd:complexType name="CT_TextBodyProperties">
 *     <xsd:sequence>
 *         <xsd:element name="prstTxWarp" type="CT_PresetTextShape" minOccurs="0" maxOccurs="1"/>
 *         <xsd:group ref="EG_TextAutofit" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="scene3d" type="CT_Scene3D" minOccurs="0" maxOccurs="1"/>
 *         <xsd:group ref="EG_Text3D" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_OfficeArtExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="rot" type="ST_Angle" use="optional"/>
 *     <xsd:attribute name="spcFirstLastPara" type="xsd:boolean" use="optional"/>
 *     <xsd:attribute name="vertOverflow" type="ST_TextVertOverflowType" use="optional"/>
 *     <xsd:attribute name="horzOverflow" type="ST_TextHorzOverflowType" use="optional"/>
 *     <xsd:attribute name="vert" type="ST_TextVerticalType" use="optional"/>
 *     <xsd:attribute name="wrap" type="ST_TextWrappingType" use="optional"/>
 *     <xsd:attribute name="lIns" type="ST_Coordinate32" use="optional"/>
 *     <xsd:attribute name="tIns" type="ST_Coordinate32" use="optional"/>
 *     <xsd:attribute name="rIns" type="ST_Coordinate32" use="optional"/>
 *     <xsd:attribute name="bIns" type="ST_Coordinate32" use="optional"/>
 *     <xsd:attribute name="numCol" type="ST_TextColumnCount" use="optional"/>
 *     <xsd:attribute name="spcCol" type="ST_PositiveCoordinate32" use="optional"/>
 *     <xsd:attribute name="rtlCol" type="xsd:boolean" use="optional"/>
 *     <xsd:attribute name="fromWordArt" type="xsd:boolean" use="optional"/>
 *     <xsd:attribute name="anchor" type="ST_TextAnchoringType" use="optional"/>
 *     <xsd:attribute name="anchorCtr" type="xsd:boolean" use="optional"/>
 *     <xsd:attribute name="forceAA" type="xsd:boolean" use="optional"/>
 *     <xsd:attribute name="upright" type="xsd:boolean" use="optional" default="false"/>
 *     <xsd:attribute name="compatLnSpc" type="xsd:boolean" use="optional"/>
 * </xsd:complexType>
 *
 * <xsd:group name="EG_TextAutofit">
 *     <xsd:choice>
 *         <xsd:element name="noAutofit" type="CT_TextNoAutofit"/>
 *         <xsd:element name="normAutofit" type="CT_TextNormalAutofit"/>
 *         <xsd:element name="spAutoFit" type="CT_TextShapeAutofit"/>
 *     </xsd:choice>
 * </xsd:group>
 *
 * <xsd:group name="EG_Text3D">
 *     <xsd:choice>
 *         <xsd:element name="sp3d" type="CT_Shape3D" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="flatTx" type="CT_FlatText" minOccurs="1" maxOccurs="1"/>
 *     </xsd:choice>
 * </xsd:group>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class TextBodyProperties extends ComplexAbstract
{

    protected $sequence = array(
//        'prstTxWarp' => 'Drawing\\Main\\Complex\\PresetTextShape',

//        'noAutofit' => 'Drawing\\Main\\Complex\\TextNoAutofit',
//        'normAutofit' => 'Drawing\\Main\\Complex\\TextNormalAutofit',
//        'spAutoFit' => 'Drawing\\Main\\Complex\\TextShapeAutofit',

//        'scene3d' => 'Drawing\\Main\\Complex\\Scene3D',

//        'sp3d' => 'Drawing\\Main\\Complex\\Shape3D',
//        'flatTx' => 'Drawing\\Main\\Complex\\FlatText',

//        'extLst' => 'Drawing\\Main\\Complex\\OfficeArtExtensionList',
    );


    protected $defaults = array(
        'lIns' => 91440,
        'tIns' => 45720,
        'rIns' => 91440,
        'bIns' => 45720,
    );


    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'rot' => new Angle(),
            'spcFirstLastPara' => '',
            'vertOverflow' => new TextVertOverflowType(),
            'horzOverflow' => new TextHorzOverflowType(),
            'vert' => new TextVerticalType(),
            'wrap' => new TextWrappingType(),
            'lIns' => new Coordinate32(),
            'tIns' => new Coordinate32(),
            'rIns' => new Coordinate32(),
            'bIns' => new Coordinate32(),
            'numCol' => new TextColumnCount(),
            'spcCol' => new PositiveCoordinate32(),
            'rtlCol' => '',
            'fromWordArt' => '',
            'anchor' => new TextAnchoringType(),
            'anchorCtr' => '',
            'forceAA' => '',
            'upright' => 'false',
            'compatLnSpc' => '',
        );

        parent::__construct($tagName, $attributes, $options);
    }


    public function toCssInline()
    {
        $style = '';
        $tmp = $this->lIns->isPresent() ? $this->lIns->toCss() : ($this->defaults['lIns'] / 12700 . 'pt');
        $style .= " margin-left:{$tmp};";
        $tmp = $this->rIns->isPresent() ? $this->rIns->toCss() : ($this->defaults['rIns'] / 12700 . 'pt');
        $style .= " margin-right:{$tmp};";
        $tmp = $this->tIns->isPresent() ? $this->tIns->toCss() : ($this->defaults['tIns'] / 12700 . 'pt');
        $style .= " margin-top:{$tmp};";
        $tmp = $this->bIns->isPresent() ? $this->bIns->toCss() : ($this->defaults['bIns'] / 12700 . 'pt');
        $style .= " margin-bottom:{$tmp};";

        $style .= ' position:relative;';

        return $style;
    }
} 