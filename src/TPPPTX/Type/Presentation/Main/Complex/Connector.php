<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/17/14
 * Time: 5:40 AM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class Connector
 * <xsd:complexType name="CT_Connector">
 *     <xsd:sequence>
 *         <xsd:element name="nvCxnSpPr" type="CT_ConnectorNonVisual" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="spPr" type="a:CT_ShapeProperties" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="style" type="a:CT_ShapeStyle" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_ExtensionListModify" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 * </xsd:complexType>
 * @package TPPPTX\Type\Presentation\Main\Complex
 */
class Connector extends ComplexAbstract{
    /**
     * @var array
     */
    protected $sequence = array(
        'nvCxnSpPr' => 'Presentation\\Main\\Complex\\ConnectorNonVisual',
        'spPr' => 'Drawing\\Main\\Complex\\ShapeProperties',
        'style' => 'Drawing\\Main\\Complex\\ShapeStyle',
//        'extLst' => 'Presentation\\Main\\Complex\\ExtensionListModify',
    );


    public function toHtmlDom(\DOMDocument $dom)
    {
        $container = parent::toHtmlDom($dom);
        $container->setAttribute('class', 'connector');

        return $container;
    }
}