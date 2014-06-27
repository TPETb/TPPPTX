<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/13/14
 * Time: 8:33 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\Percentage;
use TPPPTX\Type\Drawing\Main\Simple\TextCapsType;
use TPPPTX\Type\Drawing\Main\Simple\TextFontSize;
use TPPPTX\Type\Drawing\Main\Simple\TextNonNegativePoint;
use TPPPTX\Type\Drawing\Main\Simple\TextPoint;
use TPPPTX\Type\Drawing\Main\Simple\TextStrikeType;
use TPPPTX\Type\Drawing\Main\Simple\TextUnderlineType;
use TPPPTX\Type\Shared\CommonSimpleTypes\Simple\Lang;

/**
 * Class TextCharacterProperties
 * <xsd:complexType name="CT_TextCharacterProperties">
 *     <xsd:sequence>
 *         <xsd:element name="ln" type="CT_LineProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:group ref="EG_FillProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:group ref="EG_EffectProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="highlight" type="CT_Color" minOccurs="0" maxOccurs="1"/>
 *         <xsd:group ref="EG_TextUnderlineLine" minOccurs="0" maxOccurs="1"/>
 *         <xsd:group ref="EG_TextUnderlineFill" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="latin" type="CT_TextFont" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="ea" type="CT_TextFont" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="cs" type="CT_TextFont" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="sym" type="CT_TextFont" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="hlinkClick" type="CT_Hyperlink" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="hlinkMouseOver" type="CT_Hyperlink" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="rtl" type="CT_Boolean" minOccurs="0"/>
 *         <xsd:element name="extLst" type="CT_OfficeArtExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="kumimoji" type="xsd:boolean" use="optional"/>
 *     <xsd:attribute name="lang" type="s:ST_Lang" use="optional"/>
 *     <xsd:attribute name="altLang" type="s:ST_Lang" use="optional"/>
 *     <xsd:attribute name="sz" type="ST_TextFontSize" use="optional"/>
 *     <xsd:attribute name="b" type="xsd:boolean" use="optional"/>
 *     <xsd:attribute name="i" type="xsd:boolean" use="optional"/>
 *     <xsd:attribute name="u" type="ST_TextUnderlineType" use="optional"/>
 *     <xsd:attribute name="strike" type="ST_TextStrikeType" use="optional"/>
 *     <xsd:attribute name="kern" type="ST_TextNonNegativePoint" use="optional"/>
 *     <xsd:attribute name="cap" type="ST_TextCapsType" use="optional"/>
 *     <xsd:attribute name="spc" type="ST_TextPoint" use="optional"/>
 *     <xsd:attribute name="normalizeH" type="xsd:boolean" use="optional"/>
 *     <xsd:attribute name="baseline" type="ST_Percentage" use="optional"/>
 *     <xsd:attribute name="noProof" type="xsd:boolean" use="optional"/>
 *     <xsd:attribute name="dirty" type="xsd:boolean" use="optional" default="true"/>
 *     <xsd:attribute name="err" type="xsd:boolean" use="optional" default="false"/>
 *     <xsd:attribute name="smtClean" type="xsd:boolean" use="optional" default="true"/>
 *     <xsd:attribute name="smtId" type="xsd:unsignedInt" use="optional" default="0"/>
 *     <xsd:attribute name="bmk" type="xsd:string" use="optional"/>
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
 * <xsd:group name="EG_TextUnderlineLine">
 *     <xsd:choice>
 *         <xsd:element name="uLnTx" type="CT_TextUnderlineLineFollowText"/>
 *         <xsd:element name="uLn" type="CT_LineProperties" minOccurs="0" maxOccurs="1"/>
 *     </xsd:choice>
 * </xsd:group>
 *
 * <xsd:group name="EG_TextUnderlineFill">
 *     <xsd:choice>
 *         <xsd:element name="uFillTx" type="CT_TextUnderlineFillFollowText"/>
 *         <xsd:element name="uFill" type="CT_TextUnderlineFillGroupWrapper"/>
 *     </xsd:choice>
 * </xsd:group>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class TextCharacterProperties extends ComplexAbstract
{


    protected $sequence = array(
//        'ln' => 'Drawing\\Main\\Complex\\LineProperties', // Not sure there is any properties that can be converted to CSS

//        'noFill' => 'Drawing\\Main\\Complex\\NoFillProperties', // Completely ignorable for HTML
        'solidFill' => 'Drawing\\Main\\Complex\\SolidColorFillProperties',
//        'gradFill' => 'Drawing\\Main\\Complex\\GradientFillProperties',
//        'blipFill' => 'Drawing\\Main\\Complex\\BlipFillProperties',
//        'pattFill' => 'Drawing\\Main\\Complex\\PatternFillProperties',
//        'grpFill' => 'Drawing\\Main\\Complex\\GroupFillProperties',

//        'effectLst' => 'Drawing\\Main\\Complex\\EffectList',
//        'effectDag' => 'Drawing\\Main\\Complex\\EffectContainer',

        'highlight' => 'Drawing\\Main\\Complex\\Color',

//        'uLnTx' => 'Drawing\\Main\\Complex\\TextUnderlineLineFollowText"',
//        'uLn' => 'Drawing\\Main\\Complex\\LineProperties',
//
//        'uFillTx' => 'Drawing\\Main\\Complex\\TextUnderlineFillFollowText',
//        'uFill' => 'Drawing\\Main\\Complex\\TextUnderlineFillGroupWrapper',

        'latin' => 'Drawing\\Main\\Complex\\TextFont',
//        'ea' => 'Drawing\\Main\\Complex\\TextFont',
//        'cs' => 'Drawing\\Main\\Complex\\TextFont',
//        'sym' => 'Drawing\\Main\\Complex\\TextFont',
//        'hlinkClick' => 'Drawing\\Main\\Complex\\Hyperlink',
//        'hlinkMouseOver' => 'Drawing\\Main\\Complex\\Hyperlink',
        'rtl' => 'Drawing\\Main\\Complex\\Boolean',
//        'extLst' => 'Drawing\\Main\\Complex\\OfficeArtExtensionList',
    );


    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'kumimoji' => null,
            'lang' => new Lang(),
            'altLang' => new Lang(),
            'sz' => new TextFontSize(),
            'b' => null,
            'i' => null,
            'u' => new TextUnderlineType(),
            'strike' => new TextStrikeType(),
            'kern' => new TextNonNegativePoint(),
            'cap' => new TextCapsType(),
            'spc' => new TextPoint(),
            'normalizeH' => null,
            'baseline' => new Percentage(),
            'noProof' => 'false',
            'dirty' => 'true',
            'err' => 'false',
            'smtClean' => 'true',
            'smtId' => '0',
            'bmk' => '',
        );

        parent::__construct($tagName, $attributes, $options);
    }


    public function toCssBlock($selectorPrefix)
    {
        $result = '';

        if ($style = $this->toCssInline())
            $result .= "\n" . $selectorPrefix . ' {' . $style . '}';

        return $result;
    }


    public function toCssInline()
    {
        $style = '';
        if ($this->sz->isPresent())
            $style .= ' font-size:' . $this->sz->toCss() . ';';
        if ($this->b)
            $style .= ' font-weight:bold;';
        if ($this->i)
            $style .= ' font-style:italic;';
        if ($this->u->isPresent() && $this->u->get())
            $style .= ' text-decoration:underline;';

        if (count($tmp = $this->getChildren('latin')))
            $style .= ' font-family:' . $tmp[0]->toCss() . ';';
        if (count($tmp = $this->getChildren('solidFill')))
            $style .= ' color:' . $tmp[0]->toCss() . ';';

        return $style;
    }
} 