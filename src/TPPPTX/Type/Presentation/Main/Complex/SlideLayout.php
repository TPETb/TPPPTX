<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/15/14
 * Time: 6:15 PM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;


use TPPPTX\Type\RootAbstract;

/**
 * Class SlideLayout
 * <xsd:complexType name="CT_SlideLayout">
 *     <xsd:sequence minOccurs="1" maxOccurs="1">
 *         <xsd:element name="cSld" type="CT_CommonSlideData" minOccurs="1" maxOccurs="1"/>
 *         <xsd:group ref="EG_ChildSlide" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="transition" type="CT_SlideTransition" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="timing" type="CT_SlideTiming" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="hf" type="CT_HeaderFooter" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_ExtensionListModify" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attributeGroup ref="AG_ChildSlide"/>
 *     <xsd:attribute name="matchingName" type="xsd:string" use="optional" default=""/>
 *     <xsd:attribute name="type" type="ST_SlideLayoutType" use="optional" default="cust"/>
 *     <xsd:attribute name="preserve" type="xsd:boolean" use="optional" default="false"/>
 *     <xsd:attribute name="userDrawn" type="xsd:boolean" use="optional" default="false"/>
 * </xsd:complexType>
 *
 * <xsd:group name="EG_ChildSlide">
 *     <xsd:sequence>
 *         <xsd:element name="clrMapOvr" type="a:CT_ColorMappingOverride" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 * </xsd:group>
 *
 * <xsd:attributeGroup name="AG_ChildSlide">
 *     <xsd:attribute name="showMasterSp" type="xsd:boolean" use="optional" default="true"/>
 *     <xsd:attribute name="showMasterPhAnim" type="xsd:boolean" use="optional" default="true"/>
 * </xsd:attributeGroup>
 * @package TPPPTX\Type\Presentation\Main\Complex
 */
class SlideLayout extends RootAbstract
{
    /**
     * @param $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'matchingName' => '',
            'type' => 'cust',
            'preserve' => 'false',
            'userDrawn' => 'false',
            'showMasterSp' => 'true',
            'showMasterPhAnim' => 'true',
        );

        parent::__construct($tagName = '', $attributes, $options);
    }


    /**
     * @var array
     */
    protected $sequence = array(
        'cSld' => 'Presentation\\Main\\Complex\\CommonSlideData',
//        'clrMapOvr' => 'Drawing\\Main\\Complex\\ColorMappingOverride',
//         *         <xsd:group ref="EG_ChildSlide" minOccurs="0" maxOccurs="1"/>
//         *         <xsd:element name="transition" type="CT_SlideTransition" minOccurs="0" maxOccurs="1"/>
//         *         <xsd:element name="timing" type="CT_SlideTiming" minOccurs="0" maxOccurs="1"/>
//         *         <xsd:element name="extLst" type="CT_ExtensionListModify" minOccurs="0" maxOccurs="1"/>
    );


    public function toHtmlDom(\DOMDocument $dom)
    {
        $slide = $dom->createElement('div');
        $slide->setAttribute('class', 'slide');
        $slide->setAttribute('style', ' position: relative;' . $this->presentation->getChildren('sldSz')[0]->toCssInline());

        $slide->appendChild($this->getChildren('cSld')[0]->toHtmlDom($dom));

        return $slide;
    }


    public function findPlaceholder($id)
    {
        return $this->getChildren('cSld')[0]->getChildren('spTree')[0]->findPlaceholder($id);
    }
} 