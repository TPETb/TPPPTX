<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/16/14
 * Time: 10:25 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class BaseStyles
 * <xsd:complexType name="CT_BaseStyles">
 *     <xsd:sequence>
 *         <xsd:element name="clrScheme" type="CT_ColorScheme" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="fontScheme" type="CT_FontScheme" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="fmtScheme" type="CT_StyleMatrix" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_OfficeArtExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class BaseStyles extends ComplexAbstract
{
    protected $sequence = array(
        'clrScheme' => 'Drawing\\Main\\Complex\\ColorScheme',
        'fontScheme' => 'Drawing\\Main\\Complex\\FontScheme',
//        'fmtScheme' => 'Drawing\\Main\\Complex\\StyleMatrix',
//        'extLst' => 'Drawing\\Main\\Complex\\OfficeArtExtensionList',
    );
} 