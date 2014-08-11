<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/15/14
 * Time: 4:53 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\Angle;
use TPPPTX\Type\Presentation\Main\Complex\Slide;
use TPPPTX\Type\Presentation\Main\Complex\SlideLayout;
use TPPPTX\Type\Presentation\Main\Complex\SlideMaster;

/**
 * Class Transform2D
 * <xsd:complexType name="CT_Transform2D">
 *     <xsd:sequence>
 *         <xsd:element name="off" type="CT_Point2D" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="ext" type="CT_PositiveSize2D" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="rot" type="ST_Angle" use="optional" default="0"/>
 *     <xsd:attribute name="flipH" type="xsd:boolean" use="optional" default="false"/>
 *     <xsd:attribute name="flipV" type="xsd:boolean" use="optional" default="false"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class Transform2D extends ComplexAbstract
{
    /**
     * @var array
     */
    protected $sequence = array(
        'off' => 'Drawing\\Main\\Complex\\Point2D',
        'ext' => 'Drawing\\Main\\Complex\\PositiveSize2D',
    );


    /**
     * @param string $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'rot' => new Angle(),
            'flipH' => 'false',
            'flipV' => 'false',
        );

        parent::__construct($tagName, $attributes, $options);
    }


    /**
     * @return string
     */
    public function toCssInline()
    {
        $style = ' position: absolute; top:0; left:0;';

//        if ($tmp = $this->parent->parent->parent->child('grpSpPr')) {
//            if ($tmp = $tmp->child('xfrm')) {
//                if ($tmp->child('chExt') && $tmp->child('ext')) {
//                    if ($tmp->child('chExt')->cx->get() > 0 && $tmp->child('ext')->cx->get() > 0) {
//                        $zoom = $tmp->child('ext')->cx->get() / $tmp->child('chExt')->cx->get();
//                    }
//                }
//            }
//        }

        if ($tmp = $this->getChildren('ext')) {
            if (isset($zoom)) {
                $style .= ' width:' . $tmp[0]->cx->toCss() * $zoom . 'pt;';
                $style .= ' height:' . $tmp[0]->cy->toCss() * $zoom. 'pt;';
            } else {
                $style .= ' width:' . $tmp[0]->cx->toCss() . ';';
                $style .= ' height:' . $tmp[0]->cy->toCss() . ';';
            }
        }

        if ($tmp = $this->getChildren('off')) {
            if (isset($zoom)) {
                $style .= ' margin-left:' . $tmp[0]->x->toCss() * $zoom . 'pt;';
                $style .= ' margin-top:' . $tmp[0]->y->toCss() * $zoom . 'pt;';
            } else {
                $style .= ' margin-left:' . $tmp[0]->x->toCss() . ';';
                $style .= ' margin-top:' . $tmp[0]->y->toCss() . ';';
            }
        }

        if ($this->rot->isPresent()) {
            $style .= ' -ms-transform: rotate(' . $this->rot->toCss() . ')' . ';';
            $style .= ' -webkit-transform: rotate(' . $this->rot->toCss() . ')' . ';';
            $style .= ' transform: rotate(' . $this->rot->toCss() . ')' . ';';
        }

        if ($this->root instanceof SlideMaster) {
            $style .= ' z-index: 100;';
        } else if ($this->root instanceof SlideLayout) {
            $style .= ' z-index: 200;';
        } else if ($this->root instanceof Slide) {
            $style .= ' z-index: 300;';
        }

        return $style;
    }
} 