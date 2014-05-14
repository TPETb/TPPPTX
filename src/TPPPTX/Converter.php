<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/14/14
 * Time: 22:29
 */

namespace TPPPTX;


class Converter
{

    /**
     * @var FileHandler
     */
    protected $pptxFileHandler;

    /**
     * @var string
     */
    protected $outputName = '';

    /**
     * @var int
     */
    protected $pointPixelRatio = 12700;


    /**
     * @param mixed $file
     * @param string $outputPath
     * @param array $options
     */
    public function convert($file, $outputPath, array $options)
    {
        if (!$file instanceof FileHandler) {
            $file = new FileHandler($file);
        }

        $this->pptxFileHandler = $file;

        $this->outputPath = $outputPath;
        $this->outputName = array_slice(explode('/', $outputPath), -1, 1);

        foreach ($options as $property => $value) {
            if (method_exists($this, 'set' . ucfirst($property))) {
                $this->{'set' . ucfirst($property)}($value);
            }
        }

        $parser = new Parser();
        $data = $parser->parse($this->pptxFileHandler);
        echo '<pre>';
        print_r($data);
        echo '</pre>';

        $pageGenerator = new PageGenerator();
        $pageGenerator->saveToDisk($this->outputPath, $this->pptxFileHandler, $data, array(
            'outputName' => $this->outputName,
        ));
    }

    /**
     * @param string $outputName
     * @return Converter
     */
    public function setOutputName($outputName)
    {
        $this->outputName = $outputName;
        return $this;
    }

    /**
     * @return string
     */
    public function getOutputName()
    {
        return $this->outputName;
    }

    /**
     * @param int $pointPixelRatio
     * @return Converter
     */
    public function setPointPixelRatio($pointPixelRatio)
    {
        $this->pointPixelRatio = $pointPixelRatio;
        return $this;
    }

    /**
     * @return int
     */
    public function getPointPixelRatio()
    {
        return $this->pointPixelRatio;
    }
}