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

        $style = '';
        if ($tmp = $this->parent->child('pPr')->child('defRPr')) {
            $style .= $tmp->toCssInline();
        }
        if ($tmp = $this->child('rPr')) {
            $style .= $tmp->toCssInline();
        }
        $container->setAttribute('style', $style);

        $container->nodeValue = htmlspecialchars($this->child('t')->nodeValue);

        if (isset($_GET['show_class'])) {
            $container->setAttribute('data-class', get_called_class());
        }

        return $container;
    }


} 