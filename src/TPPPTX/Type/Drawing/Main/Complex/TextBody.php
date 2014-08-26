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


    public function toHtmlDom(\DOMDocument $dom, $options = array())
    {
        $container = $dom->createElement('div');

        if ($tmp = $this->child('bodyPr'))
            $container->setAttribute('style', $tmp->toCssInline());

        foreach ($this->getChildren('p') as $child) {
            if ($tmp = $child->toHtmlDom($dom))
                $container->appendChild($tmp);
        }

        return $container;
    }


    public function merge(ComplexAbstract $ancestor)
    {
        foreach ($this->getAttributes() as $key => $value) {
            if (($value instanceof SimpleAbstract && !$value->isPresent())
                || $value == null
            ) {
                $this->setAttribute($key, $ancestor->$key);
            }
        }

        // Loop ancestor children
        foreach ($ancestor->getChildren() as $key => $aChild) {
            if ($aChild->tagName == 'p')
                continue; // p's from ancestor should be ignored

            if ($this->child($aChild->tagName)) {
                // Descendant has such child too
                $this->children[$aChild->tagName . '0']->merge($aChild);
            } else {
                // Descendant has no such child yet
                $this->addChild($aChild);
            }
        }
    }


} 