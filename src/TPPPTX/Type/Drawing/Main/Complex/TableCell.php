<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 11/13/14
 * Time: 1:53 AM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class TableCell
 * <xsd:complexType name="CT_TableCell">
 *     <xsd:sequence>
 *         <xsd:element name="txBody" type="CT_TextBody" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="tcPr" type="CT_TableCellProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_OfficeArtExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="rowSpan" type="xsd:int" use="optional" default="1"/>
 *     <xsd:attribute name="gridSpan" type="xsd:int" use="optional" default="1"/>
 *     <xsd:attribute name="hMerge" type="xsd:boolean" use="optional" default="false"/>
 *     <xsd:attribute name="vMerge" type="xsd:boolean" use="optional" default="false"/>
 *     <xsd:attribute name="id" type="xsd:string" use="optional"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class TableCell extends ComplexAbstract
{
    /**
     * @var array
     */
    protected $sequence = array(
        'txBody' => 'Drawing\\Main\\Complex\\TextBody',
        'tcPr' => 'Drawing\\Main\\Complex\\TableCellProperties',
        'extLst' => 'Drawing\\Main\\Complex\\OfficeArtExtensionList',
    );


    /**
     * @param string $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'rowSpan' => 1,
            'gridSpan' => 1,
            'hMerge' => false,
            'vMerge' => false,
            'id' => '',
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
        return parent::toHtmlDom($dom, array('tagName' => 'td'));
    }


} 