<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/12/14
 * Time: 11:22 PM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class Picture
 * <xsd:complexType name="CT_Picture">
 *     <xsd:sequence>
 *         <xsd:element name="nvPicPr" type="CT_PictureNonVisual" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="blipFill" type="a:CT_BlipFillProperties" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="spPr" type="a:CT_ShapeProperties" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="style" type="a:CT_ShapeStyle" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_ExtensionListModify" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 * </xsd:complexType>
 * @package TPPPTX\Type\Presentation\Main\Complex
 */
class Picture extends ComplexAbstract
{
    /**
     * @var array
     */
    protected $sequence = array(
        'nvPicPr' => 'Presentation\\Main\\Complex\\PictureNonVisual',
        'blipFill' => 'Drawing\\Main\\Complex\\BlipFillProperties',
        'spPr' => 'Drawing\\Main\\Complex\\ShapeProperties',
        'style' => 'Drawing\\Main\\Complex\\ShapeStyle',
//        'extLst' => 'Presentation\\Main\\Complex\\ExtensionListModify',
    );


    public function toHtmlDom(\DOMDocument $dom, $options = array())
    {
        $container = parent::toHtmlDom($dom);
        $container->setAttribute('class', 'picture');

        return $container;
    }


} 