<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/14/14
 * Time: 22:04
 */

namespace TPPPTX\Parser;

use \TPPPTX\Parser as Parser;

/**
 * Class Presentation
 * @package TPPPTX\Parser
 */
class Presentation extends XmlFileBasedEntity
{

    /**
     * @param Parser $parser
     */
    function __construct(Parser $parser)
    {
        parent::__construct($parser, 'ppt/presentation.xml');
    }


    /**
     *
     */
    protected function parse()
    {

    }


    /**
     * @return array
     */
    public function getSlidesFilepaths()
    {
        $paths = array();
        foreach ($this->xpath->query('/p:presentation/p:sldIdLst/p:sldId') as $relNode) {
            $paths[] = $this->relations[$relNode->getAttribute('r:id')]['target'];
        }

        return $paths;
    }


    /**
     * @return array
     */
    public function getSlidesDimensions()
    {
        $node = $this->xpath->query('/p:presentation/p:sldSz')->item(0);

        return array(
            'width' => $node->getAttribute('cx'),
            'height' => $node->getAttribute('cy'),
            'type' => $node->getAttribute('type'),
        );
    }


    /**
     *
     */
    public function getHandoutMasterFilepath()
    {

    }


    /**
     * @return array
     */
    public function getSlideMastersFilepaths()
    {
        $paths = array();
        foreach ($this->xpath->query('/p:presentation/p:sldMasterIdLst/p:sldMasterId') as $relNode) {
            $paths[] = $this->relations[$relNode->getAttribute('r:id')]['target'];
        }

        return $paths;
    }


    /**
     * @return array
     */
    public function getDefaultTextStyles()
    {
        return StyleHelper::parseTextParagraphPropertiesSet($this->xpath, $this->xpath->query('/p:presentation/p:defaultTextStyle')->item(0));
    }
} 