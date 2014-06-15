<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/12/14
 * Time: 11:20 PM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\RootAbstract;

/**
 * Class Slide
 * <xsd:complexType name="CT_Slide">
 *     <xsd:sequence minOccurs="1" maxOccurs="1">
 *         <xsd:element name="cSld" type="CT_CommonSlideData" minOccurs="1" maxOccurs="1"/>
 *         <xsd:group ref="EG_ChildSlide" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="transition" type="CT_SlideTransition" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="timing" type="CT_SlideTiming" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_ExtensionListModify" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attributeGroup ref="AG_ChildSlide"/>
 *     <xsd:attribute name="show" type="xsd:boolean" use="optional" default="true"/>
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
class Slide extends RootAbstract
{

    protected $layout = null;


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


    /**
     * @param $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'show' => 'true',
            'showMasterSp' => 'true',
            'showMasterPhAnim' => 'true',
        );

        parent::__construct($tagName = '', $attributes, $options);
    }


    public function fromDom(\DOMNode $node, $options = array())
    {
        parent::fromDom($node, $options);

        // Find layout in relations and load it
        foreach ($this->relations as $rel) {
            if ($rel['type'] == 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/slideLayout') {
                $this->layout = $this->presentation->getByFilepath($rel['target']);
            }
        }

        return $this;
    }


    public function toHtmlDom(\DOMDocument $dom)
    {
        $slide = $dom->createElement('div');
        $slide->setAttribute('class', 'slide');
        $slide->setAttribute('style', ' position: relative;' . $this->presentation->getChildren('sldSz')[0]->toCssInline());

        // Slide layout shapes
        if ($this->layout) {
            $slide->appendChild($this->layout->getChildren('cSld')[0]->toHtmlDom($dom));
        }

        // Slide shapes
        $slide->appendChild($this->getChildren('cSld')[0]->toHtmlDom($dom));

        return $slide;
    }


    /**
     * @param SlideLayout $layout
     */
    public function setLayout(SlideLayout $layout)
    {
        $this->layout = $layout;
    }


    /**
     * @return SlideLayout
     */
    public function getLayout()
    {
        return $this->layout;
    }
}