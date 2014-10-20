<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/14/14
 * Time: 21:57
 */

namespace TPPPTX;

use TPPPTX\Type\Presentation\Main\Complex\Presentation;


/**
 * Class Parser
 * Extracts all available data from .pptx file
 * Result is an assoc array
 * @package TPPPTX
 * @todo add default values instead of omitted in text styles
 * @todo implement XSD based type detection
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


    /**
     * @param $pptxFileHandler
     * @todo implement real lazy loading - move $this->parse() to some getter
     */
    function __construct($pptxFileHandler)
    {
        $this->pptxFileHandler = $pptxFileHandler;
        $this->registry = new Parser\Registry();
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
     * @return array Relations file content
     */
    public function parseFileRelations($filepath)
    {
        $fileNamePrefix = dirname($filepath);
        $fileNameSuffix = basename($filepath);
        $relsPath = $fileNamePrefix . "/_rels/" . $fileNameSuffix . ".rels";

        if (isset($this->registry[$relsPath])) {
            return $this->registry[$relsPath];
        }

        if (!$this->pptxFileHandler->read($relsPath)) {
            return null;
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


    public function getByFilepath($filepath)
    {
        if (!$this->pptxFileHandler->read($filepath)) {
            throw new \Exception('Non-existing file requested');
        }

        return array(
            'content' => $this->pptxFileHandler->read($filepath),
            'relations' => $this->parseFileRelations($filepath),
        );
    }


    /**
     * @return Presentation
     * @todo add static storage
     */
    public function getPresentation()
    {
        $presentation = new Presentation('presentation');
        $presentation->load($this);

        return $presentation;
    }
}