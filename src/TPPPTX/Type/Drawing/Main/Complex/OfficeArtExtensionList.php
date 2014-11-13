<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/13/14
 * Time: 6:47 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class OfficeArtExtensionList
 * <xsd:complexType name="CT_OfficeArtExtensionList">
 *     <xsd:sequence>
 *         <xsd:group ref="EG_OfficeArtExtensionList" minOccurs="1" maxOccurs="1"/>
 *     </xsd:sequence>
 * </xsd:complexType>
 *
 * <xsd:group name="EG_OfficeArtExtensionList">
 *     <xsd:sequence>
 *         <xsd:element name="ext" type="CT_OfficeArtExtension" minOccurs="0" maxOccurs="unbounded"/>
 *     </xsd:sequence>
 * </xsd:group>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class OfficeArtExtensionList extends ComplexAbstract {

} 