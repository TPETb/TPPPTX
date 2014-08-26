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

    /**
     * @var null
     */
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

        parent::__construct($tagName, $attributes, $options);
    }


    /**
     * @param \DOMNode $node
     * @param array $options
     * @return $this
     */
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


    /**
     * @param \DOMDocument $dom
     * @param array $options
     * @return \DOMElement
     */
    public function toHtmlDom(\DOMDocument $dom, $options = array())
    {
        $slide = $dom->createElement('div');
        $slide->setAttribute('class', 'slide');
        $slide->setAttribute('style', ' position: relative;' . $this->presentation->getChildren('sldSz')[0]->toCssInline());

        if ($this->layout) {
            // If there is Layout, merge Common data from it to slide
            $this->child('cSld')->merge($this->layout->child('cSld'));

            if ($this->layout->getMaster()) {
                $this->child('cSld')->merge($this->layout->getMaster()->child('cSld'));
            }
        }

        $slide->appendChild($this->child('cSld')->toHtmlDom($dom));

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


    /**
     * @return SlideMaster
     */
    public function getMaster()
    {
        return $this->getLayout()->getMaster();
    }


    /**
     * @return \TPPPTX\Type\Drawing\Main\Complex\OfficeStyleSheet
     */
    public function  getTheme()
    {
        return $this->getMaster()->getTheme();
    }
}