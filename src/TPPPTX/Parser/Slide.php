<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/14/14
 * Time: 22:00
 */

namespace TPPPTX\Parser;

use \TPPPTX\FileHandler as FileHandler;
use \TPPPTX\Parser as Parser;


class Slide
{
    /**
     * @var FileHandler
     */
    protected $pptxFileHandler;

    /**
     * @var Parser
     */
    protected $parser;

    /**
     * @param Parser $parser
     */
    function __construct(Parser $parser)
    {
        $this->parser = $parser;

        $this->pptxFileHandler = $parser->getPptxFileHandler();
    }


    public function parse($filepath)
    {
        $slide = new \DOMDocument();
        $slide->loadXML($this->pptxFileHandler->read($filepath));
        $xpath = new \DOMXPath($slide);

        $relations = $this->parser->parseFileRelations($filepath);

        $shapes = array();
        // Loop through shapes in slide
        foreach ($xpath->query('/p:sld/p:cSld/p:spTree/p:sp') as $shapeNode) {
            $shape = array();

            // Try to retrieve shape type
            if ($nvPr = $xpath->query('p:nvSpPr/p:nvPr/p:ph', $shapeNode)) {
                foreach ($nvPr as $property) {
                    if ($property->hasAttribute('type')) {
                        $shape['type'] = $property->getAttribute('type');
                    }
                }
            }

            // Try to retrieve offset and size
            if ($xfrm = $xpath->query('p:spPr/a:xfrm', $shapeNode)->item(0)) {
                $shape = array_merge($shape, array(
                    'left' => $xpath->query('p:spPr/a:xfrm/a:off', $shapeNode)->item(0)->getAttribute('x'),
                    'top' => $xpath->query('p:spPr/a:xfrm/a:off', $shapeNode)->item(0)->getAttribute('y'),
                    'width' => $xpath->query('p:spPr/a:xfrm/a:ext', $shapeNode)->item(0)->getAttribute('cx'),
                    'height' => $xpath->query('p:spPr/a:xfrm/a:ext', $shapeNode)->item(0)->getAttribute('cy'),
                ));
            }

            // Try to retrieve textual content
            if ($txBody = $xpath->query('p:txBody', $shapeNode)->item(0)) {
                $shape['text'] = array();
                foreach ($xpath->query('a:p', $txBody) as $paragraph) {
                    $p = array();
                    foreach ($xpath->query('a:r/a:t', $paragraph) as $textNode) {
                        $p[] = array(
                            'value' => $textNode->nodeValue,
                        );
                    }
                    $shape['text'][] = $p;
                }
            }

            // Append the shape to array
            $shapes[] = $shape;
        }

        return array(
            'shapes' => $shapes,
            'pictures' => array(),
        );
    }
}