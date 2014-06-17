<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/16/14
 * Time: 10:10 PM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class ExtensionList
 * <xsd:complexType name="CT_ExtensionList">
 *     <xsd:sequence>
 *         <xsd:group ref="EG_ExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 * </xsd:complexType>
 *
 * <xsd:group name="EG_ExtensionList">
 *     <xsd:sequence>
 *         <xsd:element name="ext" type="CT_Extension" minOccurs="0" maxOccurs="unbounded"/>
 *     </xsd:sequence>
 * </xsd:group>
 * @package TPPPTX\Type\Presentation\Main\Complex
 */
class ExtensionList extends ComplexAbstract {

} 