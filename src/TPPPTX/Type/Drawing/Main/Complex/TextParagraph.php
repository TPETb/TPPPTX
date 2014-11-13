<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/15/14
 * Time: 5:02 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Presentation\Main\Complex\SlideLayout;

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


    public function toHtmlDom(\DOMDocument $dom, $options = array())
    {
        $container = $dom->createElement('p');

        $lvl = 1;
        if ($tmp = $this->child('pPr')) {
            $lvl += $tmp->lvl->get();
        }

        $container->setAttribute('class', 'lvl-' . $lvl);


        // Go on properties hunting!
        if (!$this->child('pPr')) {
            $pPr = new TextParagraphProperties('pPr', array(), array(
                'parent' => $this,
                'root' => $this->root,
            ));
            $this->addChild($pPr);
        }
        // Styles from own Shape->lstStyle
        if ($tmp = $this->parent->child('lstStyle')) {
            if ($tmp = $tmp->child('lvl' . $lvl . 'pPr')) {
                $this->children['pPr0']->merge($tmp);
            }
        }
        // Styles from master
        if (method_exists($this->parent->parent, 'isPlaceholder') && $this->parent->parent->isPlaceholder()) {
            if (stristr($this->parent->parent->getPlaceholderType(), 'ctrTitle')
                || stristr($this->parent->parent->getPlaceholderType(), 'title')
            ) {
                $pType = 'title';
            } else {
                $pType = 'body';
            }
        } else {
            // Shapes that originate from Layout and are not placeholder should inherit "other" style
            // @todo check if this is true
            if ($this->root instanceof SlideLayout) {
                $pType = 'other';
            } else {
                $pType = 'other';
            }
        }
        if ($tmp = $this->root->getMaster()->child('txStyles')) {
            if ($tmp = $tmp->child($pType . 'Style')) {
                if ($tmp = $tmp->child('lvl' . $lvl . 'pPr')) {
                    $this->children['pPr0']->merge($tmp);
                }
            }
        }
        // Default styles from presentation
        if ($tmp = $this->root->getPresentation()->child('defaultTextStyle')) {
            if ($tmp = $tmp->child('lvl' . $lvl . 'pPr')) {
                $this->children['pPr0']->merge($tmp);
            }
        }

        // Attach styles
        $container->setAttribute('style', $this->child('pPr')->toCssInline('p'));

        // Add bullet
//        if (count($this->getChildren('r br')) && $tmp = $this->child('pPr')) {
//            if (!$tmp->child('buNone')) {
//                if ($tmp = $tmp->child('buChar')) {
//                    $bullet = $dom->createElement('span');
//                    $bullet->setAttribute('class', 'bullet');
//                    $buStyle = $this->child('pPr')->toCssInline('bullet');
//                    // Check if this is correct to set bullet width equal to indent
//                    $buStyle .= ' display:inline-block; float:left; min-width:' . (-$this->child('pPr')->indent->toCss()) . 'pt;';
//                    $bullet->setAttribute('style', $buStyle);
//                    $bullet->nodeValue = $tmp->char;
//                    $container->appendChild($bullet);
//                }
//            }
//        }

        // Add text and breaks
        $i = 0;
        foreach ($this->getChildren('r br') as $child) {
            $childDom = $child->toHtmlDom($dom);

            if ($i++ == 0 && $tmp = $this->child('pPr')) {
                if (!$tmp->child('buNone')) {
                    if ($tmp = $tmp->child('buChar')) {
                        $bullet = $dom->createElement('span');
                        $bullet->setAttribute('class', 'bullet');
                        $buStyle = $this->child('pPr')->toCssInline('bullet');
                        // Check if this is correct to set bullet width equal to indent
                        $buStyle .= ' display:inline-block; float:left; min-width:' . (-$this->child('pPr')->indent->toCss()) . 'pt;';
                        $bullet->setAttribute('style', $buStyle);
                        $bullet->nodeValue = $tmp->char;
                        $childDom->insertBefore($bullet, $childDom->firstChild);
                    }
                }
            }

            $container->appendChild($childDom);
        }

        if (!count($this->getChildren('r br'))) {
            if ($this->child('endParaRPr')) {
                $span = $dom->createElement('span');

                $style = '';
                if ($tmp = $this->child('pPr')->child('defRPr')) {
                    $style .= $tmp->toCssInline();
                }
                if ($tmp = $this->child('endParaRPr')) {
                    $style .= $tmp->toCssInline();
                }
                $span->setAttribute('style', $style);

                $span->nodeValue = '&nbsp;';
                $container->appendChild($span);
            } else {
                $container->nodeValue = '&nbsp;';
            }
        }

        if (isset($_GET['show_class'])) {
            $container->setAttribute('data-class', get_called_class());
        }

        return $container;
    }

}