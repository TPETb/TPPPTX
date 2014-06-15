<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/13/14
 * Time: 7:10 PM
 */

namespace TPPPTX\Type\Drawing\Main\Simple;


use TPPPTX\Type\SimpleAbstract;

/**
 * Class Coordinate32
 * <xsd:simpleType name="ST_Coordinate32">
 *     <xsd:union memberTypes="ST_Coordinate32Unqualified s:ST_UniversalMeasure"/>
 * </xsd:simpleType>
 *
 * <xsd:simpleType name="ST_Coordinate32Unqualified">
 *     <xsd:restriction base="xsd:int"/>
 * </xsd:simpleType>
 *
 * <xsd:simpleType name="ST_UniversalMeasure">
 *     <xsd:restriction base="xsd:string">
 *         <xsd:pattern value="-?[0-9]+(\.[0-9]+)?(mm|cm|in|pt|pc|pi)"/>
 *     </xsd:restriction>
 * </xsd:simpleType>
 * @package TPPPTX\Type\Drawing\Main\Simple
 */
class Coordinate32 extends SimpleAbstract
{
}