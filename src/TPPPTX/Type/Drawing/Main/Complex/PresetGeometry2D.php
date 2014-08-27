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
     */
    public function toHtmlDom(\DOMDocument $dom, $options = array())
    {
        if (!$this->parent->child('ln') || !$this->parent->child('ln')->w) {
            // There are no line properties specified or line has zero width, meaning it cannot be visible anyway
            return null;
        }

        if (!$this->parent->child('xfrm') || !$this->parent->child('xfrm')->getChildren('ext')) {
            // Shape has no xfrm or no extent meaning it should not be visible
            return null;
        }

        $container = $dom->createElement('svg');

        $svgStyles = array(
            'position' => 'absolute',
            'top' => '0',
            'left' => '0',
        );

        /**
         * Calculate width and height of the SVG and coordinate delta
         * The issue is that SVG doesn't support overflow:visible in most browsers
         * Because of that we need to assure that SVG line is visible in full even with zero coordinate
         */
        $lineWidth = floatval($this->parent->child('ln')->w->toCss());
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

        if ($this->parent->child('ln')) {
            $content->setAttribute('style', $this->parent->child('ln')->toCssInline());
        }

        $style = '';
        foreach ($svgStyles as $attr => $value) {
            $style .= ' ' . $attr . ':' . $value . ';';
        }
        $container->setAttribute('style', $style);

        $container->appendChild($content);

        return $container;
    }


} 