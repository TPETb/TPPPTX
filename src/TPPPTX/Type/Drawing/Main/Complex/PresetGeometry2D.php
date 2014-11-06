<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 8/27/14
 * Time: 3:43 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\ShapeType;

/**
 * Class PresetGeometry2D
 * <xsd:complexType name="CT_PresetGeometry2D">
 *     <xsd:sequence>
 *         <xsd:element name="avLst" type="CT_GeomGuideList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="prst" type="ST_ShapeType" use="required"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class PresetGeometry2D extends ComplexAbstract
{
    protected $sequence = array(//        'avLst' => 'Drawing\\Main\\Complex\\GeomGuideList',
    );


    /**
     * @param string $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'prst' => new ShapeType(),
        );

        parent::__construct($tagName, $attributes, $options);
    }


    /**
     *
     * To fix browsers not supporting overflow:visible on svg, we need to handle svg style the hard way
     *
     * @param \DOMDocument $dom
     * @param array $options
     * @return \DOMElement
     * todo add check not to
     */
    public function toHtmlDom(\DOMDocument $dom, $options = array())
    {
//        if (!$this->parent->child('ln') || !$this->parent->child('ln')->w) {
//            // There are no line properties specified or line has zero width, meaning it cannot be visible anyway
//            return null;
//        }

        if (!$this->parent->child('xfrm') || !$this->parent->child('xfrm')->getChildren('ext')) {
            // Shape has no xfrm or no extent meaning it should not be visible
            return null;
        }

        $container = $dom->createElement('svg');

        /**
         * Calculate width and height of the SVG and coordinate delta
         * The issue is that SVG doesn't support overflow:visible in most browsers
         * Because of that we need to assure that SVG line is visible in full even with zero coordinate
         */
        $lineWidth = floatval($this->parent->child('ln') ? $this->parent->child('ln')->w->toCss() : 0);
//        $delta = $lineWidth / 2; // Wasn't it simple =)
        $delta = $lineWidth; // Generally, division by 2 should be correct, but somehow it produces bad layout
        $ext = $this->parent->child('xfrm')->child('ext'); // Shortcut
        $svgStyles = array(
            'position' => 'absolute',
            'top' => '-' . $delta . 'pt',
            'left' => '-' . $delta . 'pt',
            'width' => floatval($ext->cx->toCss()) + $delta * 2 . 'pt',
            'height' => floatval($ext->cy->toCss()) + $delta * 2 . 'pt',
        );
        $container->setAttribute('viewBox', (-$delta . ' ' . -$delta . ' ' . (floatval($ext->cx->toCss()) + $delta * 2) . ' ' . (floatval($ext->cy->toCss()) + $delta * 2)));
        $style = '';
        foreach ($svgStyles as $attr => $value) {
            $style .= ' ' . $attr . ':' . $value . ';';
        }
        $container->setAttribute('style', $style);

        // Create content for SVG depending on prst
        switch ($this->prst) {
            case 'line':
                $content = $dom->createElement('line');
                if ($this->parent->child('xfrm')->flipH || $this->parent->child('xfrm')->flipV) {
                    $content->setAttribute('x1', 0);
                    $content->setAttribute('x2', floatval($ext->cx->toCss()));
                    $content->setAttribute('y1', floatval($ext->cy->toCss()));
                    $content->setAttribute('y2', 0);
                } else {
                    $content->setAttribute('x1', 0);
                    $content->setAttribute('x2', floatval($ext->cx->toCss()));
                    $content->setAttribute('y1', 0);
                    $content->setAttribute('y2', floatval($ext->cy->toCss()));
                }
                break;

            case 'upArrow':
            case 'rightArrow':
            case 'downArrow':
            case 'leftArrow':
                $content = $dom->createElement('path');
                $path = $this->buildArrowPath($this->prst, [
                    'w' => floatval($ext->cx->toCss()),
                    'h' => floatval($ext->cy->toCss())
                ]);
                $content->setAttribute('d', $path);
                break;

            case 'ellipse':
                $content = $dom->createElement('ellipse');
                $content->setAttribute('cx', $ext->cx->toCss() / 2);
                $content->setAttribute('cy', $ext->cy->toCss() / 2);
                $content->setAttribute('rx', $ext->cx->toCss() / 2);
                $content->setAttribute('ry', $ext->cy->toCss() / 2);
                break;

            case 'rect':
                $content = $dom->createElement('rect');
                $content->setAttribute('x', 0);
                $content->setAttribute('y', 0);
                $content->setAttribute('width', floatval($ext->cx->toCss()));
                $content->setAttribute('height', floatval($ext->cy->toCss()));
                break;

            default:
                return null;
                break;
        }

        $style = '';
        if ($tmp = $this->parent->child('ln')) {
            $style .= $tmp->toCssInline();
        }
        if ($tmp = $this->parent->child('solidFill')) {
            $style .= 'fill:' . $tmp->toCss() . ';';
        } else {
            $style .= 'fill:transparent;';
        }
        $content->setAttribute('style', $style);

        $container->appendChild($content);

//        // Add assets to SVG canvas
//        $defs = $dom->createElement('defs');
//        // Add arrowhead marker
//        $asset = $dom->createElement('marker');
//        $asset->setAttribute('id', 'arrowHead');
//        $asset->setAttribute('markerWidth', 4);
//        $asset->setAttribute('markerHeight', 4);
//        $asset->setAttribute('refx', 4);
//        $asset->setAttribute('refy', 4);
//        $asset->setAttribute('markerUnits', "strokeWidth");
//        $asset->setAttribute('orient', "auto");
//        $path = $dom->createElement('path');
//        $path->setAttribute('d', 'M2,2 L2,13 L8,7 L2,2');
//        if ($this->parent->child('ln')) {
//            $path->setAttribute('style', $this->parent->child('ln')->toCssInline());
//        }
//
//        $defs->appendChild($asset);
//        $container->appendChild($defs);

        return $container;
    }


    /**
     * Creates a path for plain arrow
     * todo add support for bent arrows
     * todo move canvas inversion to coordinate converter
     * @param string $type
     * @param array $canvas
     * @return string
     */
    protected function buildArrowPath($type, $canvas)
    {
        // One can change the values below to change the arrow layout (e.g. make it pointier)
        switch ($type) {
            case 'rightArrow':
                $h = $canvas['h'];
                $w = $canvas['w'];
                $a = 0;
                break;
            case 'downArrow':
                $h = $canvas['w'];
                $w = $canvas['h'];
                $a = 90;
                break;
            case 'leftArrow':
                $h = $canvas['h'];
                $w = $canvas['w'];
                $a = 180;
                break;
            case 'upArrow':
                $h = $canvas['w'];
                $w = $canvas['h'];
                $a = 270;
                break;
            default:
                $this->logger->error('Provided ' . $type . ' for arrow generator');
                $a = 0;
                break;
        }

        $y1 = 0.25 * $h;
        $x1 = 0.5 * $h; // 0.5 gives 90 angle, more — pointier
        $x1 = min($x1, $w / 2); // limit to half of arrow length

        $path =
            ' M' . implode(',', $this->r($a, ['x' => 0, 'y' => $y1], $canvas))
            . ' L' . implode(',', $this->r($a, ['x' => $w - $x1, 'y' => $y1], $canvas))
            . ' L' . implode(',', $this->r($a, ['x' => $w - $x1, 'y' => 0], $canvas))
            . ' L' . implode(',', $this->r($a, ['x' => $w, 'y' => $h / 2], $canvas))
            . ' L' . implode(',', $this->r($a, ['x' => $w - $x1, 'y' => $h], $canvas))
            . ' L' . implode(',', $this->r($a, ['x' => $w - $x1, 'y' => $h - $y1], $canvas))
            . ' L' . implode(',', $this->r($a, ['x' => 0, 'y' => $h - $y1], $canvas))
            . ' Z';

        return $path;
    }


    /**
     * Calculates a coordinate in rotated coordinate system
     * todo add some Linear algebra here instead of manual calculations
     * @param $angle
     * @param $coordinate
     * @param $canvas
     * @return array
     */
    protected function rotateCoordinateSystem($angle, $coordinate, $canvas)
    {
        switch ($angle) {
            case 0:
                return $coordinate;
                break;
            case 90:
                return [
                    'x' => $canvas['w'] - $coordinate['y'],
                    'y' => $coordinate['x'],
                ];
                break;
            case 180:
                return [
                    'x' => $canvas['w'] - $coordinate['x'],
                    'y' => $canvas['h'] - $coordinate['y'],
                ];
                break;
            case 270:
                return [
                    'x' => $coordinate['y'],
                    'y' => $canvas['h'] - $coordinate['x'],
                ];
                break;
            default:
                return $coordinate;
                break;
        }
    }


    /**
     * @param $angle
     * @param $coordinate
     * @param $canvas
     * @return array
     */
    protected function r($angle, $coordinate, $canvas)
    {
        return $this->rotateCoordinateSystem($angle, $coordinate, $canvas);
    }
} 