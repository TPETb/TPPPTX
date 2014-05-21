<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/14/14
 * Time: 22:00
 */

namespace TPPPTX\Parser;

use \TPPPTX\Parser as Parser;


/**
 * Class Slide
 * @package TPPPTX\Parser
 */
class Slide
{
    /**
     * @var Parser
     */
    protected $parser;

    /**
     * @var string
     */
    protected $filepath;


    protected $shapes = array();


    protected $pictures = array();



    protected $media = array();


    protected $parsed = false;

    /**
     * @param Parser $parser
     * @param string $filepath
     * @todo implement proper lazy loading
     */
    function __construct(Parser $parser, $filepath)
    {
        $this->parser = $parser;
        $this->filepath = $filepath;

        $this->parse();
    }


    protected function parse()
    {
        // Prepare vars
        $slide = new \DOMDocument();
        $slide->loadXML($this->parser->getPptxFileHandler()->read($this->filepath));
        $xpath = new \DOMXPath($slide);

        $relations = $this->parser->parseFileRelations($this->filepath);


        // Get shapes
        $this->shapes = SlideHelper::parseShapes($xpath);
        // Get pictures
        $this->pictures = SlideHelper::parsePictures($xpath, $relations);
        // Get media
        $this->media = SlideHelper::collectMedia($relations);


        // Parsing completed
        $this->parsed = true;
    }


    /**
     * @return bool|mixed
     * @todo move this code to parse() method
     */
    public function getLayoutPath()
    {
        $relations = $this->parser->parseFileRelations($this->filepath);

        foreach ($relations as $rel) {
            if ($rel['type'] == 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/slideLayout') {
                return $rel['target'];
            }
        }

        return null;
    }

    /**
     * @return array
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @return array
     */
    public function getShapes()
    {
        return $this->shapes;
    }

    /**
     * @return array
     */
    public function getPictures()
    {
        return $this->pictures;
    }


}