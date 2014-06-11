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
class Slide extends SlideAbstract
{

    protected $aggregatedShapes = array();


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
     * @return SlideLayout
     */
    public function getLayout()
    {
        return $this->parser->getSlideLayout($this->getLayoutPath());
    }


    /**
     * @return SlideMaster
     */
    public function getMaster()
    {
        return $this->getLayout()->getMaster();
    }

}