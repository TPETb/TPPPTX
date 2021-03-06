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
        // Do not allow html engine to cut text runs containing only whitespace (people use them for paragraph spacing)
        $style .= 'white-space:pre-wrap;';
        $container->setAttribute('style', $style);

        // filter text
        $text = $this->child('t')->nodeValue;
        $text = str_replace("\t", '∆', $text);
        $text = ltrim($text);
        $text = htmlentities($text);
        if (!$text) $text = '&nbsp;';
        $text = str_replace("∆", '&#9;', $text);

        $container->nodeValue = $text;

//        if (trim($this->child('t')->nodeValue)) {
//            $container->nodeValue = htmlspecialchars(trim($this->child('t')->nodeValue));
//        } else {
//            $container->nodeValue = '&nbsp;';
//        }

        if (isset($_GET['show_class'])) {
            $container->setAttribute('data-class', get_called_class());
        }

        return $container;
    }


} 