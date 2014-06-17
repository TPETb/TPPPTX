<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/13/14
 * Time: 6:46 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\Coordinate32;
use TPPPTX\Type\Drawing\Main\Simple\TextAlignType;
use TPPPTX\Type\Drawing\Main\Simple\TextFontAlignType;
use TPPPTX\Type\Drawing\Main\Simple\TextIndent;
use TPPPTX\Type\Drawing\Main\Simple\TextIndentLevelType;
use TPPPTX\Type\Drawing\Main\Simple\TextMargin;

/**
 * Class TextParagraphProperties
 * <xsd:complexType name="CT_TextParagraphProperties">
 *     <xsd:sequence>
 *         <xsd:element name="lnSpc" type="CT_TextSpacing" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="spcBef" type="CT_TextSpacing" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="spcAft" type="CT_TextSpacing" minOccurs="0" maxOccurs="1"/>
 *         <xsd:group ref="EG_TextBulletColor" minOccurs="0" maxOccurs="1"/>
 *         <xsd:group ref="EG_TextBulletSize" minOccurs="0" maxOccurs="1"/>
 *         <xsd:group ref="EG_TextBulletTypeface" minOccurs="0" maxOccurs="1"/>
 *         <xsd:group ref="EG_TextBullet" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="tabLst" type="CT_TextTabStopList" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="defRPr" type="CT_TextCharacterProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_OfficeArtExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="marL" type="ST_TextMargin" use="optional"/>
 *     <xsd:attribute name="marR" type="ST_TextMargin" use="optional"/>
 *     <xsd:attribute name="lvl" type="ST_TextIndentLevelType" use="optional"/>
 *     <xsd:attribute name="indent" type="ST_TextIndent" use="optional"/>
 *     <xsd:attribute name="algn" type="ST_TextAlignType" use="optional"/>
 *     <xsd:attribute name="defTabSz" type="ST_Coordinate32" use="optional"/>
 *     <xsd:attribute name="rtl" type="xsd:boolean" use="optional"/>
 *     <xsd:attribute name="eaLnBrk" type="xsd:boolean" use="optional"/>
 *     <xsd:attribute name="fontAlgn" type="ST_TextFontAlignType" use="optional"/>
 *     <xsd:attribute name="latinLnBrk" type="xsd:boolean" use="optional"/>
 *     <xsd:attribute name="hangingPunct" type="xsd:boolean" use="optional"/>
 * </xsd:complexType>
 *
 * <xsd:group name="EG_TextBulletColor">
 *     <xsd:choice>
 *         <xsd:element name="buClrTx" type="CT_TextBulletColorFollowText" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="buClr" type="CT_Color" minOccurs="1" maxOccurs="1"/>
 *     </xsd:choice>
 * </xsd:group>
 *
 * <xsd:group name="EG_TextBulletSize">
 *     <xsd:choice>
 *         <xsd:element name="buSzTx" type="CT_TextBulletSizeFollowText"/>
 *         <xsd:element name="buSzPct" type="CT_TextBulletSizePercent"/>
 *         <xsd:element name="buSzPts" type="CT_TextBulletSizePoint"/>
 *     </xsd:choice>
 * </xsd:group>
 *
 * <xsd:group name="EG_TextBulletTypeface">
 *     <xsd:choice>
 *         <xsd:element name="buFontTx" type="CT_TextBulletTypefaceFollowText"/>
 *         <xsd:element name="buFont" type="CT_TextFont"/>
 *     </xsd:choice>
 * </xsd:group>
 *
 * <xsd:group name="EG_TextBullet">
 *     <xsd:choice>
 *         <xsd:element name="buNone" type="CT_TextNoBullet"/>
 *         <xsd:element name="buAutoNum" type="CT_TextAutonumberBullet"/>
 *         <xsd:element name="buChar" type="CT_TextCharBullet"/>
 *         <xsd:element name="buBlip" type="CT_TextBlipBullet"/>
 *     </xsd:choice>
 * </xsd:group>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class TextParagraphProperties extends ComplexAbstract
{
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'marL' => new TextMargin(),
            'marR' => new TextMargin(),
            'lvl' => new TextIndentLevelType(),
            'indent' => new TextIndent(),
            'algn' => new TextAlignType(),
            'defTabSz' => new Coordinate32(),
            'rtl' => null,
            'eaLnBrk' => null,
            'fontAlgn' => new TextFontAlignType(),
            'latinLnBrk' => null,
            'hangingPunct' => null,
        );

        parent::__construct($tagName = '', $attributes, $options);

//        d($this);
    }


    protected $sequence = array(
        'lnSpc' => 'Drawing\\Main\\Complex\\TextSpacing',
        'spcBef' => 'Drawing\\Main\\Complex\\TextSpacing',
        'spcAft' => 'Drawing\\Main\\Complex\\TextSpacing',

//        'buClrTx' => 'Drawing\\Main\\Complex\\TextBulletColorFollowText', // This is either ignorable or extremely complex to implement
        'buClr' => 'Drawing\\Main\\Complex\\Color',

//        'buSzTx' => 'Drawing\\Main\\Complex\\TextBulletSizeFollowText', // This is either ignorable or extremely complex to implement
        'buSzPct' => 'Drawing\\Main\\Complex\\TextBulletSizePercent',
        'buSzPts' => 'Drawing\\Main\\Complex\\TextBulletSizePoint',

//        'buFontTx' => 'Drawing\\Main\\Complex\\TextBulletTypefaceFollowText', // This is either ignorable or extremely complex to implement
        'buFont' => 'Drawing\\Main\\Complex\\TextFont',

        'buNone' => 'Drawing\\Main\\Complex\\TextNoBullet',
        'buAutoNum' => 'Drawing\\Main\\Complex\\TextAutonumberBullet',
        'buChar' => 'Drawing\\Main\\Complex\\TextCharBullet',
        'buBlip' => 'Drawing\\Main\\Complex\\TextBlipBullet',

//        'tabLst' => 'Drawing\\Main\\Complex\\TextTabStopList',
        'defRPr' => 'Drawing\\Main\\Complex\\TextCharacterProperties',
//        'extLst' => 'Drawing\\Main\\Complex\\OfficeArtExtensionList',
    );


    public function toCssBlock($selectorPrefix = '')
    {
        $result = '';

        if ($style = $this->toCssInline('p'))
            $result .= "\n" . $selectorPrefix . ' {' . $style . '}';

        if ($style = $this->toCssInline('bullet'))
            $result .= "\n" . $selectorPrefix . ' .bullet {' . $style . '}';

        return $result;
    }


    public function toCssInline($section)
    {
        $style = '';

        if ($section == 'p') {
            // Style for paragraph itself
            if ($this->marL->isPresent())
                $style .= ' margin-left:' . $this->marL->toCss() . ';';
            if ($this->marR->isPresent())
                $style .= ' margin-right:' . $this->marR->toCss() . ';';
            if ($this->indent->isPresent())
                $style .= ' text-indent:' . $this->indent->toCss() . ';';
            if ($this->algn->isPresent())
                $style .= ' text-align:' . $this->algn->toCss() . ';';
            if ($this->fontAlgn->isPresent())
                $style .= ' vertical-align:' . $this->fontAlgn->toCss() . ';';
            if (count($tmp = $this->children('lnSpc')))
                $style .= ' line-height:' . $tmp[0]->toCss() . ';';
            if (count($tmp = $this->children('spcBef')))
                $style .= ' margin-top:' . $tmp[0]->toCss() . ';';
            if (count($tmp = $this->children('spcAft')))
                $style .= ' margin-bottom:' . $tmp[0]->toCss() . ';';
            if (count($tmp = $this->children('defRPr')))
                $style .= $tmp[0]->toCssInline();
        } else if ($section == 'bullet') {
            // Styles of bullet for this paragraph
            if (count($tmp = $this->children('buClr')))
                $style .= ' color:' . $tmp[0]->toCss() . ';';
            if (count($tmp = $this->children('buSzPct buSzPts')))
                $style .= ' font-size:' . $tmp[0]->toCss() . ';';
        }

        return $style;
    }
} 