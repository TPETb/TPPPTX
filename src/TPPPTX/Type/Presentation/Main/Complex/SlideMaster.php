<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/16/14
 * Time: 9:54 PM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Complex\OfficeStyleSheet;
use TPPPTX\Type\RootAbstract;

/**
 * Class SlideMaster
 * <xsd:sequence minOccurs="1" maxOccurs="1">
 *         <xsd:element name="cSld" type="CT_CommonSlideData" minOccurs="1" maxOccurs="1"/>
 *         <xsd:group ref="EG_TopLevelSlide" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="sldLayoutIdLst" type="CT_SlideLayoutIdList" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="transition" type="CT_SlideTransition" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="timing" type="CT_SlideTiming" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="hf" type="CT_HeaderFooter" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="txStyles" type="CT_SlideMasterTextStyles" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_ExtensionListModify" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="preserve" type="xsd:boolean" use="optional" default="false"/>
 * </xsd:complexType>
 *
 * <xsd:group name="EG_TopLevelSlide">
 *     <xsd:sequence>
 *         <xsd:element name="clrMap" type="a:CT_ColorMapping" minOccurs="1" maxOccurs="1"/>
 *     </xsd:sequence>
 * </xsd:group>
 * @package TPPPTX\Type\Presentation\Main\Complex
 */
class SlideMaster extends RootAbstract
{

    /**
     * @var OfficeStyleSheet
     */
    protected $theme = '';

    /**
     * @var array
     */
    protected $sequence = array(
        'cSld' => 'Presentation\\Main\\Complex\\CommonSlideData',

        'clrMap' => 'Drawing\\Main\\Complex\\ColorMapping',

//        'sldLayoutIdLst' => 'Presentation\\Main\\Complex\\SlideLayoutIdList',
//        'transition' => 'Presentation\\Main\\Complex\\SlideTransition',
//        'timing' => 'Presentation\\Main\\Complex\\SlideTiming',
//        'hf' => 'Presentation\\Main\\Complex\\HeaderFooter',
        'txStyles' => 'Presentation\\Main\\Complex\\SlideMasterTextStyles',
//        'extLst' => 'Presentation\\Main\\Complex\\ExtensionListModify',
    );


    /**
     * @param string $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'preserve' => 'false',
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
            if ($rel['type'] == 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/theme') {
                $this->theme = $this->presentation->getByFilepath($rel['target']);
            }
        }

        return $this;
    }


    /**
     * @param OfficeStyleSheet $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }


    /**
     * @return OfficeStyleSheet
     */
    public function getTheme()
    {
        return $this->theme;
    }


    public function getSchemeColor($name)
    {
        return $this->theme->getColor($this->children('clrMap')[0]->getAttribute($name));
    }


    /**
     * This method is used for case when color are defined inside Master — SchemeColor attempts to get master for mapping
     * @return $this
     */
    public function getMaster()
    {
        return $this;
    }
}