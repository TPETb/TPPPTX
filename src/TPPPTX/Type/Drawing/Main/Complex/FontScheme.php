<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/16/14
 * Time: 10:29 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class FontScheme
 * <xsd:complexType name="CT_FontScheme">
 *     <xsd:sequence>
 *         <xsd:element name="majorFont" type="CT_FontCollection" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="minorFont" type="CT_FontCollection" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_OfficeArtExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="name" type="xsd:string" use="required"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class FontScheme extends ComplexAbstract
{
    protected $sequence = array(
        'majorFont' => 'Drawing\\Main\\Complex\\FontCollection',
        'minorFont' => 'Drawing\\Main\\Complex\\FontCollection',
//        'extLst' => 'Drawing\\Main\\Complex\\OfficeArtExtensionList',
    );


    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'name' => '',
        );

        parent::__construct($tagName, $attributes, $options);
    }
} 