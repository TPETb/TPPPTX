<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/13/14
 * Time: 1:06 AM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class ShapeNonVisual
 * <xsd:complexType name="CT_ShapeNonVisual">
 *     <xsd:sequence>
 *         <xsd:element name="cNvPr" type="a:CT_NonVisualDrawingProps" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="cNvSpPr" type="a:CT_NonVisualDrawingShapeProps" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="nvPr" type="CT_ApplicationNonVisualDrawingProps" minOccurs="1" maxOccurs="1"/>
 *     </xsd:sequence>
 * </xsd:complexType>
 * @package TPPPTX\Type\Presentation\Main\Complex
 */
class ShapeNonVisual extends ComplexAbstract
{
    protected $sequence = array(
//        'cNvPr' => 'Drawing\\Main\\Complex\\NonVisualDrawingProps',
//        'cNvSpPr' => 'Drawing\\Main\\Complex\\NonVisualDrawingShapeProps',
        'nvPr' => 'Presentation\\Main\\Complex\\ApplicationNonVisualDrawingProps',
    );


    public function toHtmlDom(\DOMDocument $dom, $options = array())
    {
        return null;
    }


} 