<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/15/14
 * Time: 4:46 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\SimpleAbstract;

/**
 * Class TextBody
 * <xsd:complexType name="CT_TextBody">
 *     <xsd:sequence>
 *         <xsd:element name="bodyPr" type="CT_TextBodyProperties" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="lstStyle" type="CT_TextListStyle" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="p" type="CT_TextParagraph" minOccurs="1" maxOccurs="unbounded"/>
 *     </xsd:sequence>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class TextBody extends ComplexAbstract
{
    protected $sequence = array(
        'bodyPr' => 'Drawing\\Main\\Complex\\TextBodyProperties',
        'lstStyle' => 'Drawing\\Main\\Complex\\TextListStyle',
        'p' => 'Drawing\\Main\\Complex\\TextParagraph',
    );


    public function toHtmlDom(\DOMDocument $dom)
    {
        $container = $dom->createElement('div');

        if ($tmp = array_shift($this->children('bodyPr')))
            $container->setAttribute('style', $tmp->toCssInline());

        foreach ($this->children('p') as $child) {
            if ($tmp = $child->toHtmlDom($dom))
                $container->appendChild($tmp);
        }

        return $container;
    }


    public function merge(ComplexAbstract $successor)
    {
        // To merge text body we only need to remove p's from ancestor and then proceed normally
        foreach ($this->children as $key => $child) {
            if ($child->tagName == 'p') {
                unset ($this->children[$key]);
            }
        }

        $this->nodeValue = $successor->nodeValue;
        $this->root =& $successor->root;
        $this->parent =& $successor->parent;

        foreach ($successor->getAttributes() as $key => $value) {
            if (($value instanceof SimpleAbstract && $value->isPresent())
                || $value !== null
            ) {
                $this->setAttribute($key, $value);
            }
        }

        foreach ($successor->children() as $sChild) {
            $matched = false;
            // If there is only one, it replaces the parental
            if (count($successor->children($sChild->tagName)) == 1) {
                foreach ($this->children as &$pChild) {
                    if ($pChild->tagName == $sChild->tagName) {
                        $pChild->merge($sChild);
                        $matched = true;
                        break;
                    }
                }
            } else {
            }

            if (!$matched) {
                $this->addChild($sChild);
            }
        }
    }


} 