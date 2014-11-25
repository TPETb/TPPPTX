<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 11/26/14
 * Time: 12:49 AM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class SlideTransition
 * <xsd:complexType name="CT_SlideTransition">
 *     <xsd:sequence>
 *         <xsd:choice minOccurs="0" maxOccurs="1">
 *             <xsd:element name="blinds" type="CT_OrientationTransition"/>
 *             <xsd:element name="checker" type="CT_OrientationTransition"/>
 *             <xsd:element name="circle" type="CT_Empty"/>
 *             <xsd:element name="dissolve" type="CT_Empty"/>
 *             <xsd:element name="comb" type="CT_OrientationTransition"/>
 *             <xsd:element name="cover" type="CT_EightDirectionTransition"/>
 *             <xsd:element name="cut" type="CT_OptionalBlackTransition"/>
 *             <xsd:element name="diamond" type="CT_Empty"/>
 *             <xsd:element name="fade" type="CT_OptionalBlackTransition"/>
 *             <xsd:element name="newsflash" type="CT_Empty"/>
 *             <xsd:element name="plus" type="CT_Empty"/>
 *             <xsd:element name="pull" type="CT_EightDirectionTransition"/>
 *             <xsd:element name="push" type="CT_SideDirectionTransition"/>
 *             <xsd:element name="random" type="CT_Empty"/>
 *             <xsd:element name="randomBar" type="CT_OrientationTransition"/>
 *             <xsd:element name="split" type="CT_SplitTransition"/>
 *             <xsd:element name="strips" type="CT_CornerDirectionTransition"/>
 *             <xsd:element name="wedge" type="CT_Empty"/>
 *             <xsd:element name="wheel" type="CT_WheelTransition"/>
 *             <xsd:element name="wipe" type="CT_SideDirectionTransition"/>
 *             <xsd:element name="zoom" type="CT_InOutTransition"/>
 *         </xsd:choice>
 *         <xsd:element name="sndAc" minOccurs="0" maxOccurs="1" type="CT_TransitionSoundAction"/>
 *         <xsd:element name="extLst" type="CT_ExtensionListModify" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="spd" type="ST_TransitionSpeed" use="optional" default="fast"/>
 *     <xsd:attribute name="advClick" type="xsd:boolean" use="optional" default="true"/>
 *     <xsd:attribute name="advTm" type="xsd:unsignedInt" use="optional"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Presentation\Main\Complex
 */
class SlideTransition extends ComplexAbstract
{

    protected $animation = '';

    /**
     * @var array
     */
    protected $sequence = array();


    /**
     * @param $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'spd' => '',
            'advClick' => '',
            'advTm' => '',
        );

        parent::__construct($tagName, $attributes, $options);
    }


    public function fromDom(\DOMNode $node, $options = array())
    {
        foreach ($node->childNodes as $childNode) {
            $this->animation = $childNode->localName;
        }

        return parent::fromDom($node, $options);
    }


    public function toDataAttribute()
    {
        return ['slide-animation', $this->animation];
    }

} 