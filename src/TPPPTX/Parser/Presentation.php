<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/14/14
 * Time: 22:04
 */

namespace TPPPTX\Parser;

use \TPPPTX\FileHandler as FileHandler;
use \TPPPTX\Parser as Parser;

/**
 * Class Presentation
 * @package TPPPTX\Parser
 */
class Presentation
{

    /**
     * @var FileHandler
     */
    protected $pptxFileHandler;

    /**
     * @var Parser
     */
    protected $parser;

    /**
     * @var \DOMDocument
     */
    protected $presentation;

    /**
     * @var \DOMXpath
     */
    protected $xpath;


    protected $relations = array();

    /**
     * @param Parser $parser
     */
    function __construct(Parser $parser)
    {
        $this->parser = $parser;

        $this->pptxFileHandler = $parser->getPptxFileHandler();

        $this->presentation = new \DOMDocument();
        $this->presentation->loadXML($this->pptxFileHandler->read('ppt/presentation.xml'));
        $this->xpath = new \DOMXPath($this->presentation);

        $this->relations = $this->parser->parseFileRelations('ppt/presentation.xml');
    }


    public function getSlidesFilepaths()
    {
        $paths = array();
        foreach ($this->xpath->query('/p:presentation/p:sldIdLst/p:sldId') as $relNode) {
            $paths[] = "ppt/{$this->relations[$relNode->getAttribute('r:id')]['target']}"; // Don't forget that in relations paths are given relatively
        }

        return $paths;
    }


    public function getHandoutMasterFilepath()
    {

    }


    public function getSlideMastersFilepaths()
    {

    }
} 