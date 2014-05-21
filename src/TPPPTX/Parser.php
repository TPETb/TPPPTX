<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/14/14
 * Time: 21:57
 */

namespace TPPPTX;


/**
 * Class Parser
 * Extracts all available data from .pptx file
 * Result is an assoc array
 *
 * @package TPPPTX
 */
class Parser
{

    /**
     * @var FileHandler
     */
    protected $pptxFileHandler;


    /**
     * @var Parser\Registry
     */
    protected $registry;


    protected $fileParsed = false;


    protected $index = array(
        'presentation' => null,
        'handout_master' => null,
        'slides' => array(),
        'slide_layouts' => array(),
        'slide_masters' => array(),
        'notes_slides' => array(),
        'notes_master' => null,
    );


    /**
     * @param $pptxFileHandler
     * @todo implement real lazy loading - move $this->parse() to some getter
     */
    function __construct($pptxFileHandler)
    {
        $this->pptxFileHandler = $pptxFileHandler;
        $this->registry = new Parser\Registry();

        $this->parse();
    }


    /**
     */
    protected function parse()
    {
        // We will need Presentation parser pretty much everywhere
        $presentation = new Parser\Presentation($this);
        $filepath = 'ppt/presentation.xml';
        $this->registry->set($filepath, $presentation);
        $this->index['presentation'] = $filepath;


        // Parse Handout Master


        // Parse Slides
        foreach ($presentation->getSlidesFilepaths() as $filepath) {
            $slide = new Parser\Slide($this, $filepath);
            $this->registry->set($filepath, $slide);
            $this->index['slides'][$filepath] = $filepath;
        }


        // Parse Slide Layouts
        foreach ($this->index['slides'] as $slidePath) {
            $slideLayoutPath = $this->registry[$slidePath]->getLayoutPath();
            if (!isset($this->index['slide_layouts'][$slideLayoutPath])) {
                $slideLayout = new Parser\SlideLayout($this, $slideLayoutPath);
                $this->registry[$slideLayoutPath] = $slideLayout;
                $this->index['slide_layouts'][$slideLayoutPath] = $slideLayoutPath;
            }
        }


        // Parse Slide Masters



        // Parse slide dimensions
        $data['slide_dimensions'] = $presentation->getSlidesDimensions();


        // Parse Notes Master
        $data['notes_master'] = '';


        // Parse Notes Slides
        $data['notes_slides'] = array();


        // Parse Media



        $this->fileParsed = true;
    }

    /**
     * @return \TPPPTX\FileHandler
     */
    public function getPptxFileHandler()
    {
        return $this->pptxFileHandler;
    }


    /**
     * Returns relations of given file as an array
     *
     * @param string $filepath Name of the original file.
     * @return string Relations file content
     */
    public function parseFileRelations($filepath)
    {
        $fileNamePrefix = dirname($filepath);
        $fileNameSuffix = basename($filepath);
        $relsPath = $fileNamePrefix."/_rels/".$fileNameSuffix.".rels";

        if (isset($this->registry[$relsPath])) {
            return $this->registry[$relsPath];
        }

        $rels = new \DOMDocument();
        $rels->loadXML($this->pptxFileHandler->read($relsPath));
        $xpath = new \DOMXPath($rels);
        $xpath->registerNamespace('r', 'http://schemas.openxmlformats.org/package/2006/relationships'); // OFC there is no "r" namespace in file, but DOMXpath need an NS direly

        $result = array();
        foreach ($xpath->query('/r:Relationships/r:Relationship') as $relNode) {
            $relationPath = explode('/', $filepath);
            array_pop($relationPath);
            foreach (explode('/', $relNode->getAttribute('Target')) as $relPathBit) {
                if ($relPathBit == '..') {
                    array_pop($relationPath);
                } else {
                    array_push($relationPath, $relPathBit);
                }
            }
            $relationPath = implode('/', $relationPath);
            $result[$relNode->getAttribute('Id')] = array(
                'type' => $relNode->getAttribute('Type'),
                'target' => $relationPath,
            );
        }

        $this->registry[$relsPath] = $result;

        return $result;
    }

    /**
     * @return \TPPPTX\Parser\Registry
     */
    public function getRegistry()
    {
        return $this->registry;
    }
}