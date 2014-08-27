<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/15/14
 * Time: 4:46 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

class ShapeStyle extends ComplexAbstract {



    /**
     * Do not generate html elements
     * @param \DOMDocument $dom
     * @param array $options
     * @return null
     */
    public function toHtmlDom(\DOMDocument $dom, $options = array())
    {
        return null;
    }
} 