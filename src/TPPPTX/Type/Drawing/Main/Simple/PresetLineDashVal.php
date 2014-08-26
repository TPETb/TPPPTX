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
    /**
     *
     */
    public function toCss()
    {
        switch ($this->value) {
            case 'solid':
                return 'solid';
                break;
            case 'dot':
                return 'dotted';
                break;
            case 'dash':
                return 'dashed';
                break;
            case 'lgDash':
                return 'dashed';
                break;
            case 'dashDot':
                return 'dotted';
                break;
            case 'lgDashDot':
                return 'dashed';
                break;
            case 'lgDashDotDot':
                return 'dotted';
                break;
            case 'sysDash':
                return 'dashed';
                break;
            case 'sysDot':
                return 'dotted';
                break;
            case 'sysDashDot':
                return 'dashed';
                break;
            case 'sysDashDotDot':
                return 'dotted';
                break;
        }
    }
} 