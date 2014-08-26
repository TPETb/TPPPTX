<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/13/14
 * Time: 3:40 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class TextListStyle
 * <xsd:complexType name="CT_TextListStyle">
 *     <xsd:sequence>
 *         <xsd:element name="defPPr" type="CT_TextParagraphProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="lvl1pPr" type="CT_TextParagraphProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="lvl2pPr" type="CT_TextParagraphProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="lvl3pPr" type="CT_TextParagraphProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="lvl4pPr" type="CT_TextParagraphProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="lvl5pPr" type="CT_TextParagraphProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="lvl6pPr" type="CT_TextParagraphProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="lvl7pPr" type="CT_TextParagraphProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="lvl8pPr" type="CT_TextParagraphProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="lvl9pPr" type="CT_TextParagraphProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_OfficeArtExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class TextListStyle extends ComplexAbstract
{
    protected $sequence = array(
        'defPPr' => 'Drawing\\Main\\Complex\\TextParagraphProperties',
        'lvl1pPr' => 'Drawing\\Main\\Complex\\TextParagraphProperties',
        'lvl2pPr' => 'Drawing\\Main\\Complex\\TextParagraphProperties',
        'lvl3pPr' => 'Drawing\\Main\\Complex\\TextParagraphProperties',
        'lvl4pPr' => 'Drawing\\Main\\Complex\\TextParagraphProperties',
        'lvl5pPr' => 'Drawing\\Main\\Complex\\TextParagraphProperties',
        'lvl6pPr' => 'Drawing\\Main\\Complex\\TextParagraphProperties',
        'lvl7pPr' => 'Drawing\\Main\\Complex\\TextParagraphProperties',
        'lvl8pPr' => 'Drawing\\Main\\Complex\\TextParagraphProperties',
        'lvl9pPr' => 'Drawing\\Main\\Complex\\TextParagraphProperties',
//        'extLst' => 'Drawing\\Main\\Complex\\OfficeArtExtensionList',
    );


    /**
     * @param \DOMDocument $dom
     * @param array $options
     * @return \DOMElement
     */
    public function toHtmlDom(\DOMDocument $dom, $options = array())
    {
        $style = $dom->createElement('style');

        foreach ($this->getChildren() as $child) {
            if ($child->tagName == 'defPPr') {
                $style->nodeValue .= $child->toCssBlock('p');
            } else if (preg_match('/lvl([1-9])pPr/', $child->tagName, $matches)) {
                $style->nodeValue .= $child->toCssBlock('p.lvl-' . $matches[1]);
            }
        }

        return $style;
    }

}