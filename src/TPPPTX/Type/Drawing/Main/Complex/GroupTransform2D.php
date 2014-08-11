<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/15/14
 * Time: 3:09 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\Angle;

/**
 * Class GroupTransform2D
 * <xsd:complexType name="CT_GroupTransform2D">
 *     <xsd:sequence>
 *         <xsd:element name="off" type="CT_Point2D" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="ext" type="CT_PositiveSize2D" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="chOff" type="CT_Point2D" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="chExt" type="CT_PositiveSize2D" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="rot" type="ST_Angle" use="optional" default="0"/>
 *     <xsd:attribute name="flipH" type="xsd:boolean" use="optional" default="false"/>
 *     <xsd:attribute name="flipV" type="xsd:boolean" use="optional" default="false"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class GroupTransform2D extends ComplexAbstract
{
    /**
     * @var array
     */
    protected $sequence = array(
        'off' => 'Drawing\\Main\\Complex\\Point2D',
        'ext' => 'Drawing\\Main\\Complex\\PositiveSize2D',
        'chOff' => 'Drawing\\Main\\Complex\\Point2D',
        'chExt' => 'Drawing\\Main\\Complex\\PositiveSize2D',
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

        if ($tmp = $this->getChildren('off')) {
            $style .= ' margin-left:' . $tmp[0]->x->toCss() . ';';
            $style .= ' margin-top:' . $tmp[0]->y->toCss() . ';';
        }

        if ($tmp = $this->getChildren('ext')) {
            $style .= ' width:' . $tmp[0]->cx->toCss() . ';';
            $style .= ' height:' . $tmp[0]->cy->toCss() . ';';
        }

        if ($this->getChildren('chExt') && $this->getChildren('chExt')[0]->cx->get() > 0) {
            $style .= ' -ms-transform-origin: top left;';
            $style .= ' -webkit-transform-origin: top left;';
            $style .= ' transform-origin: top left;';
            $style .= ' -ms-transform: scale('.$this->getChildren('ext')[0]->cx->get() / $this->getChildren('chExt')[0]->cx->get().');';
            $style .= ' -webkit-transform: scale('.$this->getChildren('ext')[0]->cx->get() / $this->getChildren('chExt')[0]->cx->get().');';
            $style .= ' transform: scale('.$this->getChildren('ext')[0]->cx->get() / $this->getChildren('chExt')[0]->cx->get().');';
        }

        if ($this->getChildren('chOff')) {
            if ($this->getChildren('chExt') && $this->getChildren('chExt')[0]->cx->get() > 0) {
                $style .= ' left:-'.$this->getChildren('ext')[0]->cx->get() / $this->getChildren('chExt')[0]->cx->get() * $this->getChildren('chOff')[0]->x->toCss().'pt;';
                $style .= ' top:-'.$this->getChildren('ext')[0]->cy->get() / $this->getChildren('chExt')[0]->cy->get() * $this->getChildren('chOff')[0]->y->toCss().'pt;';
            } else {
                $style .= ' left:-'.$this->getChildren('chOff')[0]->x->toCss().'pt;';
                $style .= ' top:-'.$this->getChildren('chOff')[0]->y->toCss().'pt;';
            }
        }

        if ($this->rot->isPresent()) {
            $style .= ' -ms-transform-origin: center;';
            $style .= ' -webkit-transform-origin: center;';
            $style .= ' transform-origin: center;';
            $style .= ' -ms-transform: rotate(' . $this->rot . ')' . ';';
            $style .= ' -webkit-transform: rotate(' . $this->rot . ')' . ';';
            $style .= ' transform: rotate(' . $this->rot . ')' . ';';
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