<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/14/14
 * Time: 11:35 AM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


/**
 * Class SolidColorFillProperties
 *
 * !!! In XSD this class doesn't extend color but it completely duplicates it !!!
 *
 * <xsd:complexType name="CT_SolidColorFillProperties">
 *     <xsd:sequence>
 *         <xsd:group ref="EG_ColorChoice" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 * </xsd:complexType>
 *
 * <xsd:group name="EG_ColorChoice">
 *     <xsd:choice>
 *         <xsd:element name="scrgbClr" type="CT_ScRgbColor" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="srgbClr" type="CT_SRgbColor" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="hslClr" type="CT_HslColor" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="sysClr" type="CT_SystemColor" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="schemeClr" type="CT_SchemeColor" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="prstClr" type="CT_PresetColor" minOccurs="1" maxOccurs="1"/>
 *     </xsd:choice>
 * </xsd:group>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class SolidColorFillProperties extends Color //!!! Attention !!!! already picks everything from Color!
{
}