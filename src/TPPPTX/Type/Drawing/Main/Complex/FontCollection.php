<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/16/14
 * Time: 10:34 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class FontCollection
 *  <xsd:complexType name="CT_FontCollection">
 *      <xsd:sequence>
 *          <xsd:element name="latin" type="CT_TextFont" minOccurs="1" maxOccurs="1"/>
 *          <xsd:element name="ea" type="CT_TextFont" minOccurs="1" maxOccurs="1"/>
 *          <xsd:element name="cs" type="CT_TextFont" minOccurs="1" maxOccurs="1"/>
 *          <xsd:element name="font" type="CT_SupplementalFont" minOccurs="0" maxOccurs="unbounded"/>
 *          <xsd:element name="extLst" type="CT_OfficeArtExtensionList" minOccurs="0" maxOccurs="1"/>
 *      </xsd:sequence>
 *  </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class FontCollection extends ComplexAbstract {

    protected $sequence = array(
        'latin' => 'Drawing\\Main\\Complex\\TextFont',
//        'ea' => 'Drawing\\Main\\Complex\\TextFont',
//        'cs' => 'Drawing\\Main\\Complex\\TextFont',
//        'font' => 'Drawing\\Main\\Complex\\SupplementalFont',
//        'extLst' => 'Drawing\\Main\\Complex\\OfficeArtExtensionList',
    );
} 