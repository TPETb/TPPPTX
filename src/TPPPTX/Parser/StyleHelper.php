<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/22/14
 * Time: 7:23 PM
 */

namespace TPPPTX\Parser;


/**
 * Class StyleHelper
 * @package TPPPTX\Parser
 */
class StyleHelper
{
    /**
     * Retrieves textual style from provided Node
     * @param \DOMXPath $xpath
     * @param \DOMNode $stylesNode
     * @return array
     */
    public static function parseTextParagraphPropertiesSet(\DOMXPath $xpath, \DOMNode $stylesNode)
    {
        $styles = array();

        for ($i = 1; ; $i++) {
            if (!$pPr = $xpath->query("a:lvl{$i}pPr", $stylesNode)->item(0)) {
                break;
            }

            $styles[$i] = self::parseTextParagraphProperties($xpath, $pPr);
        }

        return $styles;
    }


    /**
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
     * @param \DOMXPath $xpath
     * @param \DOMNode $pPr
     * @return array
     */
    public static function parseTextParagraphProperties(\DOMXPath $xpath, \DOMNode $pPr)
    {
        $pStyle = array(
            'algn' => $pPr->getAttribute('algn'),
            'fontAlgn' => $pPr->getAttribute('fontAlgn'),
            'marL' => $pPr->getAttribute('marL'),
            'marR' => $pPr->getAttribute('marR'),
            'indent' => $pPr->getAttribute('indent'),
            'defRPr' => $xpath->query('a:defRPr', $pPr)->item(0)
                    ? self::parseTextCharacterProperties($xpath, $xpath->query('a:defRPr', $pPr)->item(0))
                    : null,
            'spcBef' => $xpath->query('a:spcBef/*', $pPr)->item(0)
                    ? ($xpath->query('a:spcBef/a:spcPct', $pPr)->item(0)
                        ? $xpath->query('a:spcBef/a:spcPct', $pPr)->item(0)->getAttribute('val') . '%'
                        : $xpath->query('a:spcBef/a:spcPts', $pPr)->item(0)->getAttribute('val'))
                    : null,
            'spcAft' => $xpath->query('a:spcAft/*', $pPr)->item(0)
                    ? ($xpath->query('a:spcAft/a:spcPct', $pPr)->item(0)
                        ? $xpath->query('a:spcAft/a:spcPct', $pPr)->item(0)->getAttribute('val') . '%'
                        : $xpath->query('a:spcAft/a:spcPts', $pPr)->item(0)->getAttribute('val'))
                    : null,
            'buChar' => $xpath->query('a:buChar', $pPr)->item(0)
                    ? $xpath->query('a:buChar', $pPr)->item(0)->getAttribute('char')
                    : null,
        );

//        $pStyle = array_filter($pStyle, 'strlen');

        return $pStyle;
    }

    /**
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
     * @param \DOMXPath $xpath
     * @param \DOMNode $cPr
     * @return array
     * @todo check booleans work correctly with filter
     */
    public static function parseTextCharacterProperties(\DOMXPath $xpath, \DOMNode $cPr)
    {
        $pStyle = array(
            'sz' => $cPr->getAttribute('sz'),
            'b' => $cPr->getAttribute('b'),
            'i' => $cPr->getAttribute('i'),
            'u' => $cPr->getAttribute('u'),
            'latin' => $xpath->query('a:latin', $cPr)->item(0)
                    ? array(
                        'typeface' => $xpath->query('a:latin', $cPr)->item(0)->getAttribute('typeface'),
                    )
                    : null,
        );

//        $pStyle = array_filter($pStyle, 'strlen');

        return $pStyle;
    }


    /**
     * Merges multiple text style definitions into one
     * e.g. you can merge style from Presentation (default) and Slide Master
     * Accepts any number of arguments
     * Preferred argument is result from self::parseTextParagraphPropertiesSet()
     * Argument order of appearance the same as with array_merge
     * @return array
     */
    public static function mergeTextStyles()
    {
        // Find out max style array length
        $maxLength = 0;
        for ($i = 0; $i < func_num_args(); $i++) {
            $maxLength = max($maxLength, count(func_get_arg($i)));
        }

        $result = array();
        for ($i = 1; $i <= $maxLength; $i++) {
            $pStyle = array();
            foreach (func_get_args() as $arg) {
                $pStyle = array_merge($pStyle, $arg[$i]);
            }

            $result[$i] = $pStyle;
        }

        return $result;
    }
} 