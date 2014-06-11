<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/22/14
 * Time: 4:46 PM
 */

namespace TPPPTX\Parser;

use \TPPPTX\Parser as Parser;

/**
 * Class SlideAbstract
 * @package TPPPTX\Parser
 * @todo check whether Shape name is unique
 */
abstract class SlideAbstract extends XmlFileBasedEntity
{

    /**
     * @var array
     */
    protected $shapes = array();

    /**
     * @var array
     */
    protected $pictures = array();

    /**
     * @var array
     */
    protected $media = array();

    /**
     * Parses Slide, SlideLayout or NotesSlide
     */
    protected function parse()
    {
        // Get shapes
        $this->shapes = self::parseShapes($this->xpath);
        // Get pictures
        $this->pictures = self::parsePictures($this->xpath, $this->relations);
        // Get media
        $this->media = self::collectMedia($this->relations);


        // Parsing completed
        $this->parsed = true;
    }

    /**
     * @return array
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @return array
     */
    public function getShapes()
    {
        return $this->shapes;
    }

    /**
     * @return array
     */
    public function getPictures()
    {
        return $this->pictures;
    }


    /**
     * @param \DOMXPath $xpath
     * @return array
     * @todo parse bullets
     * @todo parse font modifications (b, u, i)
     */
    protected static function parseShapes(\DOMXPath $xpath)
    {
        // Loop through shapes in slide
        $shapes = array();
        foreach ($xpath->query('p:cSld/p:spTree/p:sp') as $shapeNode) {
            $shape = array();

            // Check if this is a placeholder
            if ($ph = $xpath->query('p:nvSpPr/p:nvPr/p:ph', $shapeNode)->item(0)) {
                $shape['placeholder'] = array(
                    'type' => $ph->getAttribute('type'),
                    'orient' => $ph->getAttribute('orient'),
                    'sz' => $ph->getAttribute('sz'),
                    'idx' => $ph->getAttribute('idx'),
                );
            } else {
                $shape['placeholder'] = null;
            }

            // Try to retrieve form
            if ($xfrm = $xpath->query('p:spPr/a:xfrm', $shapeNode)->item(0)) {
                $shape['form'] = array(
                    'x' => $xpath->query('a:off', $xfrm)->item(0)->getAttribute('x'),
                    'y' => $xpath->query('a:off', $xfrm)->item(0)->getAttribute('y'),
                    'cx' => $xpath->query('a:ext', $xfrm)->item(0)->getAttribute('cx'),
                    'cy' => $xpath->query('a:ext', $xfrm)->item(0)->getAttribute('cy'),
                    'rot' => $xfrm->getAttribute('rot'),
                );
            } else {
                $shape['form'] = null;
            }

            // Try to retrieve textual content
            if ($txBody = $xpath->query('p:txBody', $shapeNode)->item(0)) {
                // Prepare container
                $shape['txBody'] = array(
                    'styles' => null,
                    'content' => array()
                );
                // Get styles if present
                if ($xpath->query('p:txBody/a:lstStyle/*', $shapeNode)->item(0)) {
                    $shape['txBody']['styles'] = StyleHelper::parseTextParagraphPropertiesSet($xpath, $xpath->query('p:txBody/a:lstStyle', $shapeNode)->item(0));
                }
                // Get text
                foreach ($xpath->query('a:p', $txBody) as $paragraph) {
                    $p = array(
                        'lvl' => $xpath->query('a:pPr', $paragraph)->item(0) && $xpath->query('a:pPr', $paragraph)->item(0)->getAttribute('lvl')
                                ? $xpath->query('a:pPr', $paragraph)->item(0)->getAttribute('lvl') + 1
                                : 1,
                        'content' => array(),
                        'pPr' => $xpath->query('a:pPr', $paragraph)->item(0)
                                ? StyleHelper::parseTextParagraphProperties($xpath, $xpath->query('a:pPr', $paragraph)->item(0))
                                : null,
                        'r' => array(),
                    );
                    foreach ($xpath->query('a:r | a:br', $paragraph) as $r) {
                        if ($r->nodeName == 'a:br') {
                            $p['r'][] = array(
                                'rPr' => $xpath->query('a:rPr', $r)->item(0)
                                        ? StyleHelper::parseTextCharacterProperties($xpath, $xpath->query('a:rPr', $r)->item(0))
                                        : null,
                                't' => 'br'
                            );
                        } else {
                            $p['r'][] = array(
                                'rPr' => $xpath->query('a:rPr', $r)->item(0)
                                        ? StyleHelper::parseTextCharacterProperties($xpath, $xpath->query('a:rPr', $r)->item(0))
                                        : null,
                                't' => $xpath->query('a:t', $r)->item(0)->nodeValue
                            );
                        }
                    }
                    $shape['txBody']['content'][] = $p;
                }
            } else {
                $shape['txBody'] = null;
            }

            // Append the shape to array
            $shapes[] = $shape;
        }

        return $shapes;
    }


    /**
     * @param \DOMXPath $xpath
     * @param $relations
     * @return array
     */
    protected static function parsePictures(\DOMXPath $xpath, $relations)
    {
        $pictures = array();
        // Loop through images
        foreach ($xpath->query('p:cSld/p:spTree/p:pic') as $picNode) {
            $pic = array();

            $pic['image'] = array(
                'src' => '',
                'alt' => '',
            );

            // Get actual image
            if ($srcNode = $xpath->query('p:blipFill/a:blip', $picNode)->item(0)) {
                $pic['image']['src'] = $relations[$srcNode->getAttribute('r:embed')]['target'];
            }

            // Try to retrieve offset and size
            if ($xfrm = $xpath->query('p:spPr/a:xfrm', $picNode)->item(0)) {
                $pic['form'] = array(
                    'x' => $xpath->query('a:off', $xfrm)->item(0)->getAttribute('x'),
                    'y' => $xpath->query('a:off', $xfrm)->item(0)->getAttribute('y'),
                    'cx' => $xpath->query('a:ext', $xfrm)->item(0)->getAttribute('cx'),
                    'cy' => $xpath->query('a:ext', $xfrm)->item(0)->getAttribute('cy'),
                    'rot' => $xfrm->getAttribute('rot'),
                );
            }

            $pictures[] = $pic;
        }

        return $pictures;
    }


    /**
     * @param $relations
     * @return array
     */
    protected static function collectMedia($relations)
    {
        $media = array();
        // Collect media from relations
        foreach ($relations as $relation) {
            switch ($relation['type']) {
                case 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/image':
                    $media[] = $relation['target'];
                    break;
            }
        }

        return $media;
    }


    /**
     * Looks like it is an all-wrong method... Too sad, but will be removed
     * @return array
     */
    protected static function mergeShapes()
    {
        $shapes = array();
        $shapeSets = func_get_args();
        $placeholders = array();

        for ($i = 0; $i < count($shapeSets); $i++) {
            $placeholders[$i] = array();
            foreach ($shapeSets[$i] as $shape) {
                if (!$shape['placeholder']) {
                    // This is simple shape which will always appear and cannot be overridden
                    $shapes[] = $shape;
                } else {
                    // This placeholder shape which will need to be overridden before appending to results
                    $placeholders[$i][] = $shape;
                }
            }
        }

        for ($i = 0; $i < count($placeholders); $i++) {
            foreach ($placeholders[$i] as $lowPlaceholder) {
                $resultShape = $lowPlaceholder;
                for ($j = $i + 1; $j < count($placeholders); $j++) {
                    foreach ($placeholders[$j] as $key => $highPlaceholder) {
                        if (($resultShape['placeholder']['idx'] && $resultShape['placeholder']['idx'] == $highPlaceholder['placeholder']['idx'])
                            || (!$resultShape['placeholder']['idx'] && $resultShape['placeholder']['type'] == $highPlaceholder['placeholder']['type'])
                        ) {
                            // This is shapes of same placeholder. "Higher" shapes overrides the "lower"
//                            $mergedStyles = StyleHelper::mergeTextStyles($resultShape['txBody']['styles'], $highPlaceholder['txBody']['styles']);
                            $resultShape = $highPlaceholder;
                            unset($placeholders[$j][$key]);
                        }
                    }
                }
                $shapes[] = $resultShape;
            }
        }

        return $shapes;
    }
}