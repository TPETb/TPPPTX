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
     * @var string
     */
    protected $outputPath = '';

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
        $this->outputName = array_pop(explode('/', $outputPath));

        foreach ($options as $property => $value) {
            if (method_exists($this, 'set' . ucfirst($property))) {
                $this->{'set' . ucfirst($property)}($value);
            }
        }
    }
} 