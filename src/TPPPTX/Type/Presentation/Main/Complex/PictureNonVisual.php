<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/17/14
 * Time: 6:36 AM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class PictureNonVisual
 * <xsd:complexType name="CT_PictureNonVisual">
 *     <xsd:sequence>
 *         <xsd:element name="cNvPr" type="a:CT_NonVisualDrawingProps" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="cNvPicPr" type="a:CT_NonVisualPictureProperties" minOccurs="1" maxOccurs = "1" />
 *         <xsd:element name="nvPr" type="CT_ApplicationNonVisualDrawingProps" minOccurs="1" maxOccurs = "1" />
 *     </xsd:sequence>
 * </xsd:complexType>
 * @package TPPPTX\Type\Presentation\Main\Complex
 */
class PictureNonVisual extends ComplexAbstract
{
    protected $sequence = array(
//        'cNvPr' => 'Drawing\\Main\\Complex\\NonVisualDrawingProps',
//        'cNvSpPr' => 'Drawing\\Main\\Complex\\NonVisualDrawingShapeProps',
        'nvPr' => 'Presentation\\Main\\Complex\\ApplicationNonVisualDrawingProps',
    );
}
