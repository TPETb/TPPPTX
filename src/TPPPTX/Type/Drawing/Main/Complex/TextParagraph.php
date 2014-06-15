<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/15/14
 * Time: 5:02 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class TextParagraph
 * <xsd:complexType name="CT_TextParagraph">
 *     <xsd:sequence>
 *         <xsd:element name="pPr" type="CT_TextParagraphProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:group ref="EG_TextRun" minOccurs="0" maxOccurs="unbounded"/>
 *         <xsd:element name="endParaRPr" type="CT_TextCharacterProperties" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 * </xsd:complexType>
 *
 * <xsd:group name="EG_TextRun">
 *     <xsd:choice>
 *         <xsd:element name="r" type="CT_RegularTextRun"/>
 *         <xsd:element name="br" type="CT_TextLineBreak"/>
 *         <xsd:element name="fld" type="CT_TextField"/>
 *     </xsd:choice>
 * </xsd:group>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class TextParagraph extends ComplexAbstract
{
    protected $sequence = array(
        'pPr' => 'Drawing\\Main\\Complex\\TextParagraphProperties',

        'r' => 'Drawing\\Main\\Complex\\RegularTextRun',
        'br' => 'Drawing\\Main\\Complex\\TextLineBreak',
//        'fld' => 'Drawing\\Main\\Complex\\TextField',

        'endParaRPr' => 'Drawing\\Main\\Complex\\TextCharacterProperties',
    );


    public function toHtmlDom(\DOMDocument $dom)
    {
        $container = $dom->createElement('p');

        $lvl = 1;
        if ($tmp = array_shift($this->getChildren('pPr'))) {
            $lvl += $tmp->lvl->get();
        }
        /**
         * Compose styles:
         * 1. If parent Shape has parent placeholder - pick from Placeholder->txBody->lstStyle of it
         * 2. Pick from parent Shape->txBody->lstStyle
         * 3. Pick from own pPr
         */

        $pStyle = '';
        if ($this->parent->parent->isPlaceholder()) {
            if ($tmp = array_shift($this->parent->parent->getPlaceholder()->getChildren('txBody'))) {
                if ($tmp = array_shift($tmp->getChildren('lstStyle'))) {
                    if ($tmp = array_shift($tmp->getChildren('lvl'.$lvl.'pPr'))) {
                        $pStyle .= $tmp->toCssInline('p');
                    }
                }
            }
        }

        if ($tmp = array_shift($this->parent->getChildren('lstStyle'))) {
            if ($tmp = array_shift($tmp->getChildren('lvl'.$lvl.'pPr'))) {
                $pStyle .= $tmp->toCssInline('p');
            }
        }

        if ($tmp = array_shift($this->getChildren('pPr'))) {
            $pStyle .= $tmp->toCssInline('p');
        }

        $container->setAttribute('style', $pStyle);

        // todo add bullet here

        foreach ($this->getChildren('r br') as $child) {
            $container->appendChild($child->toHtmlDom($dom));
        }

        return $container;
    }


} 