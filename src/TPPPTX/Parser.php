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
     * @param FileHandler $file
     * @return array
     */
    public function parse($file)
    {
        $this->pptxFileHandler = $file;

        $data = array();

        // We will need Presentation parser pretty much everywhere
        $presentation = new Parser\Presentation($this);

        // Parse Handout Master
        $data['handout_master'] = '';


        // Parse Slide Layouts
        $data['slide_layouts'] = array();


        // Parse Slide Masters
        $data['slide_masters'] = array();


        // Parse Slides
        $slideParser = new Parser\Slide($this);
        $data['slides'] = array();
        foreach ($presentation->getSlidesFilepaths() as $filepath) {
            $data['slides'][] = $slideParser->parse($filepath);
        }


        // Parse Notes Master
        $data['notes_master'] = '';


        // Parse Notes Slides
        $data['notes_slides'] = array();


        return $data;
    }

    /**
     * @return \TPPPTX\FileHandler
     */
    public function getPptxFileHandler()
    {
        return $this->pptxFileHandler;
    }


    /**
     * Get the file name of a relation file from pptx documents.
     *
     * @param string $filepath Name of the original file.
     * @return string Relations file content
     */
    public function parseFileRelations($filepath)
    {
        $fileNamePrefix = dirname($filepath);
        $fileNameSuffix = basename($filepath);

        $rels = new \DOMDocument();
        $rels->loadXML($this->pptxFileHandler->read($fileNamePrefix."/_rels/".$fileNameSuffix.".rels"));
        $xpath = new \DOMXPath($rels);
        $xpath->registerNamespace('r', 'http://schemas.openxmlformats.org/package/2006/relationships'); // OFC there is no "r" namespace in file, but DOMXpath need an NS direly

        $result = array();
        foreach ($xpath->query('/r:Relationships/r:Relationship') as $relNode) {
            $result[$relNode->getAttribute('Id')] = array(
                'type' => $relNode->getAttribute('Type'),
                'target' => $relNode->getAttribute('Target'),
            );
        }

        return $result;
    }

}