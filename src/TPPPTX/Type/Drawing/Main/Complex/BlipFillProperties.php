<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/14/14
 * Time: 11:37 AM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class BlipFillProperties
 * <xsd:complexType name="CT_BlipFillProperties">
 *     <xsd:sequence>
 *         <xsd:element name="blip" type="CT_Blip" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="srcRect" type="CT_RelativeRect" minOccurs="0" maxOccurs="1"/>
 *         <xsd:group ref="EG_FillModeProperties" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="dpi" type="xsd:unsignedInt" use="optional"/>
 *     <xsd:attribute name="rotWithShape" type="xsd:boolean" use="optional"/>
 * </xsd:complexType>
 *
 * <xsd:group name="EG_FillModeProperties">
 *     <xsd:choice>
 *         <xsd:element name="tile" type="CT_TileInfoProperties" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="stretch" type="CT_StretchInfoProperties" minOccurs="1" maxOccurs="1"/>
 *     </xsd:choice>
 * </xsd:group>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class BlipFillProperties extends ComplexAbstract
{
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'dpi' => '',
            'rotWithShape' => '',
        );

        parent::__construct($tagName, $attributes, $options);
    }


    protected $sequence = array(
        'blip' => 'Drawing\\Main\\Complex\\Blip',
//        'srcRect' => 'Drawing\\Main\\Complex\\RelativeRect',
//
//        'tile' => 'Drawing\\Main\\Complex\\TileInfoProperties',
//        'stretch' => 'Drawing\\Main\\Complex\\StretchInfoProperties',
    );
} 