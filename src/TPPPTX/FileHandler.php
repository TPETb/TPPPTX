<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/14/14
 * Time: 21:32
 */

namespace TPPPTX;


/**
 * Class FileHandler
 * Can read and update contents of the .pptx file
 * Doesn't work with .pptx logic, just saves and writes
 * @package TPPPTX
 */
class FileHandler
{
    /**
     * @var string
     */
    protected $pptxFilepath = '';
    /**
     * @var \ZipArchive
     */
    protected $pptxFileHandler;


    /**
     * @param string $filepath
     * @throws \Exception
     */
    function __construct($filepath)
    {
        $this->pptxFileHandler = new \ZipArchive();
        if (!$this->pptxFileHandler->open($filepath)) {
            throw new \Exception('Provided file is not zip');
        }

        $this->pptxFilepath = $filepath;
    }


    /**
     * @return mixed
     */
    public function getFilename()
    {
        return array_pop(array_slice(explode('/', $this->pptxFilepath), -1, 1));
    }


    /**
     * @param $filepath
     * @param $content
     */
    public function create($filepath, $content)
    {

    }


    /**
     * Read a file from a zip document
     *
     * @param string $filepath Name of file to read
     * @return string Content of given file or an empty string, if file does not exists.
     */
    public function read($filepath)
    {
        $filepath = $this->reformatFileName($filepath);
        if (!$fp = $this->pptxFileHandler->getStream($filepath)) {
            return false;
        }
        return stream_get_contents($fp);
    }


    /**
     * @param $filepath
     * @param $content
     */
    public function update($filepath, $content)
    {

    }


    /**
     * @param $filepath
     */
    public function delete($filepath)
    {

    }


    public function extract($pathTo, $entries = null)
    {
        $this->pptxFileHandler->extractTo($pathTo, $entries);
    }


    public function extractFolder($pathTo, $folder)
    {
        for ($i = 0; $i < $this->pptxFileHandler->numFiles; $i++) {
            $filename = $this->pptxFileHandler->getNameIndex($i);
            if (preg_match('/' . str_replace('/', '\\/', $folder) . '(\/.+)/', $filename, $matches)) {
                file_put_contents($pathTo . $matches[1], $this->read($matches[0]));
            }
        }
    }


    /**
     * Reformat a file name and remove unnecessary parts.
     *
     * @param string $fileName Name of the file to reformat
     * @return string New filename
     */
    protected function reformatFileName($fileName)
    {
        $pathParts = explode("/", $fileName);
        $resultingPath = array();
        foreach ($pathParts as $part) {
            if ($part == "..") {
                array_pop($resultingPath);
            } else {
                array_push($resultingPath, $part);
            }
        }

        return implode("/", $resultingPath);
    }

}