<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/12/14
 * Time: 11:03 PM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\SimpleAbstract;

/**
 * Class Shape
 * <xsd:complexType name="CT_Shape">
 *     <xsd:sequence>
 *         <xsd:element name="nvSpPr" type="CT_ShapeNonVisual" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="spPr" type="a:CT_ShapeProperties" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="style" type="a:CT_ShapeStyle" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="txBody" type="a:CT_TextBody" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_ExtensionListModify" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="useBgFill" type="xsd:boolean" use="optional" default="false"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Complex
 */
class Shape extends ComplexAbstract
{
    /**
     * @var array
     */
    protected $sequence = array(
        'nvSpPr' => 'Presentation\\Main\\Complex\\ShapeNonVisual',
        'spPr' => 'Drawing\\Main\\Complex\\ShapeProperties',
        'style' => 'Drawing\\Main\\Complex\\ShapeStyle',
        'txBody' => 'Drawing\\Main\\Complex\\TextBody',
//        'extLst' => 'Presentation\\Main\\Complex\\ExtensionListModify',
    );


    /**
     * @param $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'useBgFill' => false,
        );

        parent::__construct($tagName, $attributes, $options);
    }


    /**
     * @param \DOMDocument $dom
     * @param array $options
     * @return \DOMElement
     */
    public function toHtmlDom(\DOMDocument $dom, $options = array())
    {
        $container = parent::toHtmlDom($dom);
        $container->setAttribute('class', 'shape');

        return $container;
    }


    /**
     * Will also load the placeholder to var
     * @return bool
     * @todo move placeholder loading from layout somewhere else
     */
    public function isPlaceholder()
    {
        if ($tmp = $this->child('nvSpPr')) {
            if ($tmp = $tmp->child('nvPr')) {
                if ($tmp = $tmp->child('ph')) {
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * @return string
     */
    public function getPlaceholderType()
    {
        if ($tmp = $this->child('nvSpPr')) {
            if ($tmp = $tmp->child('nvPr')) {
                if ($tmp = $tmp->child('ph')) {
                    // This is a placeholder =)
                    return $tmp->type->get();
                }
            }
        }

        return false;
    }

}