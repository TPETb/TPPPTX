<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/14/14
 * Time: 22:00
 */

namespace TPPPTX\Parser;


class SlideLayout extends SlideAbstract
{


    /**
     * Returns actual shapes, not placeholders
     * @return array
     */
    public function getShapes()
    {
        $shapes = array();
        foreach ($this->shapes as $shape) {
            if (!$shape['placeholder']) {
                $shapes[] = $shape;
            }
        }

        return $shapes;
    }


    /**
     * Returns a placeholder by given type and/or idx
     * @param array $placeholder
     * @return null|array
     */
    public function getPlaceholder($placeholder = array())
    {
        foreach ($this->shapes as $shape) {
            if ($shape['placeholder'] && ($shape['placeholder']['idx'] && $shape['placeholder']['idx'] == $placeholder['idx'])
                || (!$shape['placeholder']['idx'] && $shape['placeholder']['type'] == $placeholder['type'])
            ) {
                return $shape;
            }
        }

        return null;
    }


    /**
     * @return null
     */
    public function getMasterPath()
    {
        foreach ($this->relations as $rel) {
            if ($rel['type'] == 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/slideMaster') {
                return $rel['target'];
            }
        }

        return null;
    }


    /**
     * @return SlideMaster
     * @throws \Exception
     */
    public function getMaster()
    {
        return $this->parser->getSlideMaster($this->getMasterPath());
    }
}