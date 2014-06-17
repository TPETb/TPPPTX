<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/15/14
 * Time: 5:31 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class TextLineBreak
 * <xsd:complexType name="CT_TextLineBreak">
 *     <xsd:sequence>
 *         <xsd:element name="rPr" type="CT_TextCharacterProperties" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class TextLineBreak extends ComplexAbstract
{
    protected $sequence = array(
        'rPr' => 'Drawing\\Main\\Complex\\TextCharacterProperties',
    );


    public function toHtmlDom(\DOMDocument $dom)
    {
        $container = $dom->createElement('br');

        if ($tmp = array_shift($this->getChildren('rPr'))) {
            $container->setAttribute('style', $tmp->toCssInline());
        }

        return $container;
    }
} 