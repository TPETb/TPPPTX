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
     * @var int
     */
    protected $pointPixelRatio = 12700;


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

        echo '<pre>';
        $parser = new Parser($file);
        if (isset($_GET['debug'])) print_r($parser);
        echo '</pre>';

//        $pageGenerator = new PageGenerator(array(
//            'pointPixelRatio' => $this->pointPixelRatio,
//        ));

//        $pageGenerator->saveToDisk($file, $data, $outputPath);
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