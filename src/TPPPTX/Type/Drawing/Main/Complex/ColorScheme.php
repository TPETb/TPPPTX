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
 * Class ColorScheme
 * <xsd:complexType name="CT_ColorScheme">
 *     <xsd:sequence>
 *         <xsd:element name="dk1" type="CT_Color" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="lt1" type="CT_Color" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="dk2" type="CT_Color" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="lt2" type="CT_Color" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="accent1" type="CT_Color" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="accent2" type="CT_Color" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="accent3" type="CT_Color" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="accent4" type="CT_Color" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="accent5" type="CT_Color" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="accent6" type="CT_Color" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="hlink" type="CT_Color" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="folHlink" type="CT_Color" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_OfficeArtExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="name" type="xsd:string" use="required"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class ColorScheme extends ComplexAbstract
{

    protected $sequence = array(
        'dk1' => 'Drawing\\Main\\Complex\\Color',
        'lt1' => 'Drawing\\Main\\Complex\\Color',
        'dk2' => 'Drawing\\Main\\Complex\\Color',
        'lt2' => 'Drawing\\Main\\Complex\\Color',
        'accent1' => 'Drawing\\Main\\Complex\\Color',
        'accent2' => 'Drawing\\Main\\Complex\\Color',
        'accent3' => 'Drawing\\Main\\Complex\\Color',
        'accent4' => 'Drawing\\Main\\Complex\\Color',
        'accent5' => 'Drawing\\Main\\Complex\\Color',
        'accent6' => 'Drawing\\Main\\Complex\\Color',
        'hlink' => 'Drawing\\Main\\Complex\\Color',
        'folHlink' => 'Drawing\\Main\\Complex\\Color',
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