<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/14/14
 * Time: 11:35 AM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class LineProperties
 * <xsd:complexType name="CT_LineProperties">
 *     <xsd:sequence>
 *         <xsd:group ref="EG_LineFillProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:group ref="EG_LineDashProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:group ref="EG_LineJoinProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="headEnd" type="CT_LineEndProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="tailEnd" type="CT_LineEndProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_OfficeArtExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="w" type="ST_LineWidth" use="optional"/>
 *     <xsd:attribute name="cap" type="ST_LineCap" use="optional"/>
 *     <xsd:attribute name="cmpd" type="ST_CompoundLine" use="optional"/>
 *     <xsd:attribute name="algn" type="ST_PenAlignment" use="optional"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class LineProperties extends ComplexAbstract {

} 