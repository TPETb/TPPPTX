<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/14/14
 * Time: 22:29
 */

namespace TPPPTX;
use Psr\Log\LoggerAwareTrait;


/**
 * Class Converter
 * @package TPPPTX
 */
class Converter
{
    use LoggerAwareTrait;

    /**
     * @param array $options
     */
    function __construct($options = array())
    {
        $this->setOptions($options);
    }


    /**
     * @param mixed $file
     * @param string $outputPath
     */
    public function convert($file, $outputPath)
    {
        if (!$file instanceof FileHandler) {
            $file = new FileHandler($file);
        }

        $parser = new Parser($file);
        $parser->setLogger($this->logger);

        $pageGenerator = new PageGenerator($parser);
        $pageGenerator->setLogger($this->logger);
        $pageGenerator->saveAs($outputPath);
    }


    public function setOptions($options)
    {
        foreach ($options as $property => $value) {
            if (method_exists($this, 'set' . ucfirst($property))) {
                $this->{'set' . ucfirst($property)}($value);
            }
        }
    }
}