<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/14/14
 * Time: 11:38 AM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class Color
 * <xsd:complexType name="CT_Color">
 *     <xsd:sequence>
 *         <xsd:group ref="EG_ColorChoice"/>
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
class Color extends ComplexAbstract
{
    protected $sequence = array(
        'scrgbClr' => 'Drawing\\Main\\Complex\\ScRgbColor',
        'srgbClr' => 'Drawing\\Main\\Complex\\SRgbColor',
        'hslClr' => 'Drawing\\Main\\Complex\\HslColor',
        'sysClr' => 'Drawing\\Main\\Complex\\SystemColor',
        'schemeClr' => 'Drawing\\Main\\Complex\\SchemeColor',
        'prstClr' => 'Drawing\\Main\\Complex\\PresetColor',
    );

    public function toCss()
    {
        return $this->children()[0]->toCss();
    }
} 