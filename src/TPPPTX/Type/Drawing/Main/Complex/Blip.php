<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/15/14
 * Time: 11:17 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;

use TPPPTX\Type\ComplexAbstract;

/**
 * Class Blip
 * <xsd:complexType name="CT_Blip">
 *     <xsd:sequence>
 *         <xsd:choice minOccurs="0" maxOccurs="unbounded">
 *             <xsd:element name="alphaBiLevel" type="CT_AlphaBiLevelEffect" minOccurs="1" maxOccurs="1"/>
 *             <xsd:element name="alphaCeiling" type="CT_AlphaCeilingEffect" minOccurs="1" maxOccurs="1"/>
 *             <xsd:element name="alphaFloor" type="CT_AlphaFloorEffect" minOccurs="1" maxOccurs="1"/>
 *             <xsd:element name="alphaInv" type="CT_AlphaInverseEffect" minOccurs="1" maxOccurs="1"/>
 *             <xsd:element name="alphaMod" type="CT_AlphaModulateEffect" minOccurs="1" maxOccurs="1"/>
 *             <xsd:element name="alphaModFix" type="CT_AlphaModulateFixedEffect" minOccurs="1" maxOccurs="1"/>
 *             <xsd:element name="alphaRepl" type="CT_AlphaReplaceEffect" minOccurs="1" maxOccurs="1"/>
 *             <xsd:element name="biLevel" type="CT_BiLevelEffect" minOccurs="1" maxOccurs="1"/>
 *             <xsd:element name="blur" type="CT_BlurEffect" minOccurs="1" maxOccurs="1"/>
 *             <xsd:element name="clrChange" type="CT_ColorChangeEffect" minOccurs="1" maxOccurs="1"/>
 *             <xsd:element name="clrRepl" type="CT_ColorReplaceEffect" minOccurs="1" maxOccurs="1"/>
 *             <xsd:element name="duotone" type="CT_DuotoneEffect" minOccurs="1" maxOccurs="1"/>
 *             <xsd:element name="fillOverlay" type="CT_FillOverlayEffect" minOccurs="1" maxOccurs="1"/>
 *             <xsd:element name="grayscl" type="CT_GrayscaleEffect" minOccurs="1" maxOccurs="1"/>
 *             <xsd:element name="hsl" type="CT_HSLEffect" minOccurs="1" maxOccurs="1"/>
 *             <xsd:element name="lum" type="CT_LuminanceEffect" minOccurs="1" maxOccurs="1"/>
 *             <xsd:element name="tint" type="CT_TintEffect" minOccurs="1" maxOccurs="1"/>
 *         </xsd:choice>
 *         <xsd:element name="extLst" type="CT_OfficeArtExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attributeGroup ref="AG_Blob"/>
 *     <xsd:attribute name="cstate" type="ST_BlipCompression" use="optional" default="none"/>
 * </xsd:complexType>
 *
 * <xsd:attributeGroup name="AG_Blob">
 *     <xsd:attribute ref="r:embed" use="optional" default=""/>
 *     <xsd:attribute ref="r:link" use="optional" default=""/>
 * </xsd:attributeGroup>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class Blip extends ComplexAbstract
{
    /**
     * @param string $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'r:embed' => '',
            'r:link' => '',
            'cstate' => '',
        );

        parent::__construct($tagName, $attributes, $options);
    }


    public function getFilepath()
    {
        return '#base_path#/' . $this->root->getRelations()[$this->getAttribute('r:embed')]['target'];
    }

} 