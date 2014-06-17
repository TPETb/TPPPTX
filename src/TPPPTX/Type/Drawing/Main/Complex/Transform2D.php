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

/**
 * Class Transform2D
 * <xsd:complexType name="CT_GroupTransform2D">
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
    public function toCss()
    {
        $style = ' position: absolute;';

        if ($tmp = $this->children('off')) {
            $style .= ' left:' . $tmp[0]->x->toCss() . ';';
            $style .= ' top:' . $tmp[0]->y->toCss() . ';';
        }

        if ($tmp = $this->children('ext')) {
            $style .= ' width:' . $tmp[0]->cx->toCss() . ';';
            $style .= ' height:' . $tmp[0]->cy->toCss() . ';';
        }

        if ($this->rot->isPresent()) {
            $style .= ' -ms-transform: rotate(' . $this->rot->toCss() . ')' . ';';
            $style .= ' -webkit-transform: rotate(' . $this->rot->toCss() . ')' . ';';
            $style .= ' transform: rotate(' . $this->rot->toCss() . ')' . ';';
        }

        return $style;
    }
} 