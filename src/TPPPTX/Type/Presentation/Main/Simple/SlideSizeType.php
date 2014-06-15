<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/13/14
 * Time: 4:53 PM
 */

namespace TPPPTX\Type\Presentation\Main\Simple;


use TPPPTX\Type\SimpleAbstract;

/**
 * Class SlideSizeType
 * <xsd:simpleType name="ST_SlideSizeType">
 *     <xsd:restriction base="xsd:token">
 *         <xsd:enumeration value="screen4x3"/>
 *         <xsd:enumeration value="letter"/>
 *         <xsd:enumeration value="A4"/>
 *         <xsd:enumeration value="35mm"/>
 *         <xsd:enumeration value="overhead"/>
 *         <xsd:enumeration value="banner"/>
 *         <xsd:enumeration value="custom"/>
 *         <xsd:enumeration value="ledger"/>
 *         <xsd:enumeration value="A3"/>
 *         <xsd:enumeration value="B4ISO"/>
 *         <xsd:enumeration value="B5ISO"/>
 *         <xsd:enumeration value="B4JIS"/>
 *         <xsd:enumeration value="B5JIS"/>
 *         <xsd:enumeration value="hagakiCard"/>
 *         <xsd:enumeration value="screen16x9"/>
 *         <xsd:enumeration value="screen16x10"/>
 *     </xsd:restriction>
 * </xsd:simpleType>
 * @package TPPPTX\Type\Presentation\Main\Simple
 */
class SlideSizeType extends SimpleAbstract{

} 