<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 8/26/14
 * Time: 4:34 PM
 */

namespace TPPPTX\Type\Drawing\Main\Simple;


use TPPPTX\Type\SimpleAbstract;

/**
 * Class PresetLineDashVal
 * <xsd:simpleType name="ST_PresetLineDashVal">
 *       <xsd:restriction base="xsd:token">
 *           <xsd:enumeration value="solid"/>
 *           <xsd:enumeration value="dot"/>
 *           <xsd:enumeration value="dash"/>
 *           <xsd:enumeration value="lgDash"/>
 *           <xsd:enumeration value="dashDot"/>
 *           <xsd:enumeration value="lgDashDot"/>
 *           <xsd:enumeration value="lgDashDotDot"/>
 *           <xsd:enumeration value="sysDash"/>
 *           <xsd:enumeration value="sysDot"/>
 *           <xsd:enumeration value="sysDashDot"/>
 *           <xsd:enumeration value="sysDashDotDot"/>
 *       </xsd:restriction>
 *   </xsd:simpleType>
 * @package TPPPTX\Type\Drawing\Main\Simple
 */
class PresetLineDashVal extends SimpleAbstract
{

    public function getStrokeDasharray($w)
    {
        switch ($this->value) {
            case 'solid':
                return '1pt';
                break;
            case 'dot':
                return '1pt, ' . $w * 1.5.'pt';
                break;
            case 'dash':
                return $w * 1.5 .'pt' . ', ' . $w * 1.5.'pt';
                break;
            case 'lgDash':
                return $w * 3 .'pt' . ', ' . $w * 1.5.'pt';
                break;
            case 'dashDot':
                return $w * 1.5 .'pt' . ', ' . $w * 1.5 .'pt'. ', 1, ' . $w * 1.5.'pt';
                break;
            case 'lgDashDot':
                return $w * 3 .'pt' . ', ' . $w * 1.5 .'pt'. ', 1, ' . $w * 1.5.'pt';
                break;
            case 'lgDashDotDot':
                return $w * 3 .'pt' . ', ' . $w * 1.5 .'pt'. ', 1, ' . $w * 1.5 .'pt'. ', 1, ' . $w * 1.5.'pt';
                break;
            case 'sysDash':
                return $w * 1.5 .'pt' . ', ' . $w * 1.5 .'pt';
                break;
            case 'sysDot':
                return $w * 1.5 .'pt' . ', ' . $w * 1.5 .'pt';
                break;
            case 'sysDashDot':
                return $w * 1.5 .'pt' . ', ' . $w * 1.5 .'pt'. ', 1, ' . $w * 1.5.'pt';
                break;
            case 'sysDashDotDot':
                return $w * 3 .'pt' . ', ' . $w * 1.5 .'pt'. ', 1, ' . $w * 1.5 .'pt'. ', 1, ' . $w * 1.5.'pt';
                break;
        }
    }
} 