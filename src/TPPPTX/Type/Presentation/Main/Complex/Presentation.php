<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/13/14
 * Time: 2:57 PM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;

use TPPPTX\Parser;
use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Presentation\Main\Simple\BookmarkIdSeed;
use TPPPTX\Type\RootAbstract;
use TPPPTX\Type\Shared\CommonSimpleTypes\Simple\ConformanceClass;


/**
 * Class Presentation
 * <xsd:complexType name="CT_Presentation">
 *     <xsd:sequence>
 *         <xsd:element name="sldMasterIdLst" type="CT_SlideMasterIdList" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="notesMasterIdLst" type="CT_NotesMasterIdList" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="handoutMasterIdLst" type="CT_HandoutMasterIdList" minOccurs="0"
 *                      maxOccurs="1"/>
 *         <xsd:element name="sldIdLst" type="CT_SlideIdList" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="sldSz" type="CT_SlideSize" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="notesSz" type="a:CT_PositiveSize2D" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="smartTags" type="CT_SmartTags" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="embeddedFontLst" type="CT_EmbeddedFontList" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="custShowLst" type="CT_CustomShowList" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="photoAlbum" type="CT_PhotoAlbum" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="custDataLst" type="CT_CustomerDataList" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="kinsoku" type="CT_Kinsoku" minOccurs="0"/>
 *         <xsd:element name="defaultTextStyle" type="a:CT_TextListStyle" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="modifyVerifier" type="CT_ModifyVerifier" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_ExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="serverZoom" type="a:ST_Percentage" use="optional" default="50%"/>
 *     <xsd:attribute name="firstSlideNum" type="xsd:int" use="optional" default="1"/>
 *     <xsd:attribute name="showSpecialPlsOnTitleSld" type="xsd:boolean" use="optional" default="true"/>
 *     <xsd:attribute name="rtl" type="xsd:boolean" use="optional" default="false"/>
 *     <xsd:attribute name="removePersonalInfoOnSave" type="xsd:boolean" use="optional" default="false"/>
 *     <xsd:attribute name="compatMode" type="xsd:boolean" use="optional" default="false"/>
 *     <xsd:attribute name="strictFirstAndLastChars" type="xsd:boolean" use="optional" default="true"/>
 *     <xsd:attribute name="embedTrueTypeFonts" type="xsd:boolean" use="optional" default="false"/>
 *     <xsd:attribute name="saveSubsetFonts" type="xsd:boolean" use="optional" default="false"/>
 *     <xsd:attribute name="autoCompressPictures" type="xsd:boolean" use="optional" default="true"/>
 *     <xsd:attribute name="bookmarkIdSeed" type="ST_BookmarkIdSeed" use="optional" default="1"/>
 *     <xsd:attribute name="conformance" type="s:ST_ConformanceClass"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Presentation\Main\Complex
 */
class Presentation extends RootAbstract
{

    /**
     * @var \TPPPTX\Parser\Registry
     */
    protected $registry;


    /**
     * @var Parser
     */
    protected $parser;


    /**
     * @var array
     */
    protected $sequence = array(
        'sldMasterIdLst' => 'Presentation\\Main\\Complex\\SlideMasterIdList',
        'notesMasterIdLst' => 'Presentation\\Main\\Complex\\NotesMasterIdList',
        'handoutMasterIdLst' => 'Presentation\\Main\\Complex\\HandoutMasterIdList',
        'sldIdLst' => 'Presentation\\Main\\Complex\\SlideIdList',
        'sldSz' => 'Presentation\\Main\\Complex\\SlideSize',
        'notesSz' => 'Drawing\\Main\\Complex\\PositiveSize2D',
//        'smartTags' => 'Presentation\\Main\\Complex\\SmartTags',
//        'embeddedFontLst' => 'Presentation\\Main\\Complex\\EmbeddedFontList',
//        'custShowLst' => 'Presentation\\Main\\Complex\\CustomShowList',
//        'photoAlbum' => 'Presentation\\Main\\Complex\\PhotoAlbum',
//        'custDataLst' => 'Presentation\\Main\\Complex\\CustomerDataList',
//        'kinsoku' => 'Presentation\\Main\\Complex\\Kinsoku',
        'defaultTextStyle' => 'Drawing\\Main\\Complex\\TextListStyle',
//        'modifyVerifier' => 'Presentation\\Main\\Complex\\ModifyVerifier',
//        'extLst' => 'Presentation\\Main\\Complex\\ExtensionList',
    );


    /**
     * @param $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->registry = new Parser\Registry();

        if (isset($options['parser']))
            $this->parser = $options['parser'];

        $this->attributes = array(
            'serverZoom' => '50%',
            'firstSlideNum' => '1',
            'showSpecialPlsOnTitleSld' => true,
            'rtl' => false,
            'removePersonalInfoOnSave' => false,
            'compatMode' => false,
            'strictFirstAndLastChars' => true,
            'embedTrueTypeFonts' => false,
            'saveSubsetFonts' => false,
            'autoCompressPictures' => true,
            'bookmarkIdSeed' => new BookmarkIdSeed(1),
            'conformance' => new ConformanceClass(),
        );

        parent::__construct($tagName, $attributes, $options);
    }


    /**
     * @param \DOMDocument $dom
     * @param array $options
     * @return \DOMElement
     */
    public function toHtmlDom(\DOMDocument $dom, $options = array())
    {
        $result = $dom->createElement('div');
        $result->setAttribute('class', 'presentation-container');

        // Get default styles
//        if ($defaultTextStyle = array_shift($this->getChildren('defaultTextStyle'))) {
//            /** @var \TPPPTX\Type\Drawing\Main\Complex\TextListStyle $defaultTextStyle */
//            if ($contents = $defaultTextStyle->toHtmlDom($dom)) {
//                $result->appendChild($contents);
//            }
//        }

        // Slides!
        foreach ($this->getChildren('sldIdLst')[0]->getChildren() as $key => $slideId) {
//            if ($key != 1) continue;
            // Create a clone of presentation for every slide so that it can be changed and then erased to clean memory
            // @todo rework this to actual cloning instead of file reparsing
            $presentation = new Presentation();
            $presentation->setLogger($this->logger);
            $presentation->load($this->parser);
            $slide = $presentation->getByFilepath($this->relations[$slideId->getAttribute('r:id')]['target']);
            $result->appendChild($slide->toHtmlDom($dom));
            // Clean the dust
            $presentation->__destruct();
            unset($presentation);
        }

        return $result;
    }


    /**
     * @param Parser $parser
     * @return ComplexAbstract
     */
    public function load(Parser $parser)
    {
        $data = $parser->getByFilepath('ppt/presentation.xml');
        // Start procession from main file - presentation.xml
        $dom = new \DOMDocument();
        $dom->loadXML($data['content']);
        $xpath = new \DOMXPath($dom);

        $rootNode = $xpath->query('/*')->item(0);

        // Parse file as it is
        $this->fromDom($rootNode, array(
            'relations' => $data['relations'],
        ));
        $this->parser = $parser;

        return $this;
    }


    /**
     * @param $filepath
     * @return mixed
     * @todo probably getting rid of registry and creating new object every time might fix the issue.
     * @todo On the other hand the application will become completely bound to xml
     * @todo but this method is already fully file dependent =) think of it
     */
    public function getByFilepath($filepath)
    {
        if (isset($this->registry[$filepath])) {
            return $this->registry[$filepath];
        }

        $data = $this->parser->getByFilepath($filepath);
        $dom = new \DOMDocument();
        $dom->loadXML($data['content']);
        $xpath = new \DOMXPath($dom);

        $rootNode = $xpath->query('/*')->item(0);

        // Parse file as it is
        $className = $this->resolveRootClassName($rootNode);
        $element = new $className();
        $element->setLogger($this->logger);
        $element->fromDom($rootNode, array(
            'relations' => $data['relations'],
            'presentation' => &$this,
        ));

        $this->registry[$filepath] = $element;

        return $this->registry[$filepath];
    }


    protected function resolveRootClassName(\DOMNode $node)
    {
        $roots = array(
            'http://schemas.openxmlformats.org/presentationml/2006/main' => array(
                'sld' => 'TPPPTX\\Type\\Presentation\\Main\\Complex\\Slide',
                'sldLayout' => 'TPPPTX\\Type\\Presentation\\Main\\Complex\\SlideLayout',
                'sldMaster' => 'TPPPTX\\Type\\Presentation\\Main\\Complex\\SlideMaster',
                'presentation' => 'TPPPTX\\Type\\Presentation\\Main\\Complex\\Presentation',
            ),
            'http://schemas.openxmlformats.org/drawingml/2006/main' => array(
                'theme' => 'TPPPTX\\Type\\Drawing\\Main\\Complex\\OfficeStyleSheet',
            ),
        );

        return $roots[$node->namespaceURI][$node->localName];
    }
}