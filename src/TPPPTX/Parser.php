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

        return array();
    }


    /**
     * Get the file name of a relation file from pptx documents.
     *
     * @param string $filepath Name of the original file.
     * @return string Relations file content
     */
    public function getFileRelations($filepath)
    {
        $fileNamePrefix = dirname($filepath);
        $fileNameSuffix = basename($filepath);

        return $this->pptxFileHandler->read($fileNamePrefix."/_rels/".$fileNameSuffix.".rels");
    }

}