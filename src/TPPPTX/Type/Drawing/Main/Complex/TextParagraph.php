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
        if (!count($this->children('r br'))) {
            return false;
        }

        $container = $dom->createElement('p');

        $lvl = 1;
        if ($tmp = array_shift($this->children('pPr'))) {
            $lvl += $tmp->lvl->get();
        }

        $container->setAttribute('class', 'lvl-' . $lvl);
        /**
         * Compose styles:
         * - Pick from presentation default style
         * - If Master can be picked, pick from there
         * - If parent Shape has parent placeholder - pick from Placeholder->txBody->lstStyle of it
         * - Pick from parent Shape->txBody->lstStyle
         * - Pick from own pPr
         */

        $styleChain = array();

//        // Default styles from presentation
//        if ($tmp = $this->root->getPresentation()->child('defaultTextStyle')) {
//            if ($tmp = $tmp->child('lvl' . $lvl . 'pPr')) {
//                $styleChain[] = clone $tmp;
//            }
//        }
//
//        // Styles from master
//        if ($this->parent->parent->isPlaceholder()) {
//            if (stristr($this->parent->parent->getPlaceholderId(), 'ctrTitle')
//                || stristr($this->parent->parent->getPlaceholderId(), 'title')
//            ) {
//                $pType = 'title';
//            } else {
//                $pType = 'body';
//            }
//        } else {
//            $pType = 'body';
//        }
//        if ($tmp = $this->root->getMaster()->child('txStyles')) {
//            if ($tmp = $tmp->child($pType . 'Style')) {
//                if ($tmp = $tmp->child('lvl' . $lvl . 'pPr')) {
//                    $styleChain[] = clone $tmp;
//                }
//            }
//        }
//
//        // Styles from placeholder lstStyle
//        if ($this->parent->parent->isPlaceholder()) {
//            if ($tmp = $this->parent->parent->getPlaceholder()->child('txBody')) {
//                if ($tmp = $tmp->child('lstStyle')) {
//                    if ($tmp = $tmp->child('lvl' . $lvl . 'pPr')) {
//                        $styleChain[] = clone $tmp;
//                    }
//                }
//            }
//        }
//
//        // Styles from own shape
//        if ($tmp = $this->parent->child('lstStyle')) {
//            if ($tmp = $tmp->child('lvl' . $lvl . 'pPr')) {
//                $styleChain[] = clone $tmp;
//            }
//        }
//
//        // Own styles
//        if ($tmp = $this->child('pPr')) {
//            $styleChain[] = clone $tmp;
//        }

        for ($i = 0; $i < count($styleChain) - 1; $i++) {
            $styleChain[$i]->merge($styleChain[$i + 1]);
        }

        if (count($styleChain)) {
            $container->setAttribute('style', $styleChain[count($styleChain) - 2]->toCssInline('p'));
        }

        unset($styleChain);

        // Add bullet
        if ($tmp = $this->child('pPr')) {
            if ($tmp = $tmp->child('buChar')) {
                $bullet = $dom->createElement('span');
                $bullet->setAttribute('class', 'bullet');
                $buStyle = $this->child('pPr')->toCssInline('bullet');
                // Check if this is correct to set bullet width equal to indent
                $buStyle .= ' display:inline-block; float:left; width:' . (-$this->child('pPr')->indent->toCss()) . 'pt;';
                $bullet->setAttribute('style', $buStyle);
                $bullet->nodeValue = $tmp->char;
                $container->appendChild($bullet);
            }
        }

        // Add text and breaks
        foreach ($this->children('r br') as $child) {
            $container->appendChild($child->toHtmlDom($dom));
        }

        return $container;
    }


} 