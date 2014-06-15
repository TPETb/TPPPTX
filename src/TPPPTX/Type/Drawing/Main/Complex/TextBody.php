<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/15/14
 * Time: 4:46 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

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

        foreach ($this->getChildren('p') as $child) {
            $container->appendChild($child->toHtmlDom($dom));
        }

        return $container;
    }


} 