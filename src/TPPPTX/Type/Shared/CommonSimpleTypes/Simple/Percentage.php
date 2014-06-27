<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/13/14
 * Time: 8:29 PM
 */

namespace TPPPTX\Type\Shared\CommonSimpleTypes\Simple;

use TPPPTX\Type\SimpleAbstract;

/**
 * Class Percentage
 * <xsd:simpleType name="ST_Percentage">
 *     <xsd:restriction base="xsd:string">
 *         <xsd:pattern value="-?[0-9]+(\.[0-9]+)?%"/>
 *     </xsd:restriction>
 * </xsd:simpleType>
 * @package TPPPTX\Type\Drawing\Main\Simple
 */
class Percentage extends SimpleAbstract
{
    /**
     * @return string
     * @throws \Exception
     */
    public function toCss()
    {
        return $this->value / 1000 * 1.275 . '%';
    }
} 