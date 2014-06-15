<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/14/14
 * Time: 2:56 PM
 */

namespace TPPPTX\Type\Shared\CommonSimpleTypes\Simple;

use TPPPTX\Type\SimpleAbstract;

/**
 * Class HexColorRGB
 * <xsd:simpleType name="ST_HexColorRGB">
 *     <xsd:restriction base="xsd:hexBinary">
 *         <xsd:length value="3" fixed="true"/>
 *     </xsd:restriction>
 * </xsd:simpleType>
 * @package TPPPTX\Type\Shared\CommonSimpleTypes\Simple
 */
class HexColorRGB extends SimpleAbstract {

} 