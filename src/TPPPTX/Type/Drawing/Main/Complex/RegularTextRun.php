<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/15/14
 * Time: 5:25 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class RegularTextRun
 * <xsd:complexType name="CT_RegularTextRun">
 *     <xsd:sequence>
 *         <xsd:element name="rPr" type="CT_TextCharacterProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="t" type="xsd:string" minOccurs="1" maxOccurs="1"/>
 *     </xsd:sequence>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class RegularTextRun extends ComplexAbstract
{
    /**
     * @var array
     */
    protected $sequence = array(
        'rPr' => 'Drawing\\Main\\Complex\\TextCharacterProperties',
        't' => 'ComplexConcrete',
    );


    /**
     * @param \DOMDocument $dom
     * @param array $options
     * @return \DOMElement
     */
    public function toHtmlDom(\DOMDocument $dom, $options = array())
    {
        $container = $dom->createElement('span');
        if ($tmp = $this->child('rPr')) {
            $container->setAttribute('style', $tmp->toCssInline());
        }

        $container->nodeValue = htmlspecialchars($this->child('t')->nodeValue);

        return $container;
    }


} 