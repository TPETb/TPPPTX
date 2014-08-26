<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/12/14
 * Time: 11:21 PM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class CommonSlideData
 * <xsd:complexType name="CT_CommonSlideData">
 *     <xsd:sequence>
 *         <xsd:element name="bg" type="CT_Background" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="spTree" type="CT_GroupShape" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="custDataLst" type="CT_CustomerDataList" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="controls" type="CT_ControlList" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_ExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="name" type="xsd:string" use="optional" default=""/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Presentation\Main\Complex
 */
class CommonSlideData extends ComplexAbstract
{
    /**
     * @param $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'name' => '',
        );

        parent::__construct($tagName, $attributes, $options);
    }


    /**
     * @var array
     */
    protected $sequence = array(
        'spTree' => 'Presentation\\Main\\Complex\\GroupShape',
    );


    /**
     * @param \DOMDocument $dom
     * @param array $options
     * @return mixed
     */
    public function toHtmlDom(\DOMDocument $dom, $options = array())
    {
        return $this->child('spTree')->toHtmlDom($dom);
    }
}