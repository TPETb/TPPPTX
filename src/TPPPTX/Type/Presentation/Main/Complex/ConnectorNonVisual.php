<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/17/14
 * Time: 5:43 AM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class ConnectorNonVisual
 * <xsd:complexType name="CT_ConnectorNonVisual">
 *     <xsd:sequence>
 *         <xsd:element name="cNvPr" type="a:CT_NonVisualDrawingProps" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="cNvCxnSpPr" type="a:CT_NonVisualConnectorProperties" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="nvPr" type="CT_ApplicationNonVisualDrawingProps" minOccurs="1" maxOccurs="1"/>
 *     </xsd:sequence>
 * </xsd:complexType>
 * @package TPPPTX\Type\Presentation\Main\Complex
 */
class ConnectorNonVisual extends ComplexAbstract
{
    protected $sequence = array(
//        'cNvPr' => 'Drawing\\Main\\Complex\\NonVisualDrawingProps',
//        'cNvCxnSpPr' => 'Drawing\\Main\\Complex\\NonVisualConnectorProperties',
//        'nvPr' => 'Presentation\\Main\\Complex\\ApplicationNonVisualDrawingProps',
    );


    /**
     * Do not generate html elements
     * @param \DOMDocument $dom
     * @param array $options
     * @return null
     */
    public function toHtmlDom(\DOMDocument $dom, $options = array())
    {
        return null;
    }
} 