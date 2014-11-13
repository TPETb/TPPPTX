<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 11/13/14
 * Time: 1:17 AM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class Table
 * <xsd:complexType name="CT_Table">
 *     <xsd:sequence>
 *         <xsd:element name="tblPr" type="CT_TableProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="tblGrid" type="CT_TableGrid" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="tr" type="CT_TableRow" minOccurs="0" maxOccurs="unbounded"/>
 *     </xsd:sequence>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class Table extends ComplexAbstract
{
    protected $sequence = array(
        'tblPr' => 'Drawing\\Main\\Complex\\TableProperties',
        'tblGrid' => 'Drawing\\Main\\Complex\\TableGrid',
        'tr' => 'Drawing\\Main\\Complex\\TableRow',
    );


    public function toHtmlDom(\DOMDocument $dom, $options = array())
    {
        $container = parent::toHtmlDom($dom, array('tagName' => 'table'));

        $container->setAttribute('style', $container->getAttribute('style') . 'border-collapse:collapse;');

        return $container;
    }


} 