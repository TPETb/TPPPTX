<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/14/14
 * Time: 11:39 AM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\PitchFamily;
use TPPPTX\Type\Drawing\Main\Simple\TextTypeface;
use TPPPTX\Type\Shared\CommonSimpleTypes\Simple\Panose;

/**
 * Class TextFont
 * <xsd:complexType name="CT_TextFont">
 *     <xsd:attribute name="typeface" type="ST_TextTypeface" use="required"/>
 *     <xsd:attribute name="panose" type="s:ST_Panose" use="optional"/>
 *     <xsd:attribute name="pitchFamily" type="ST_PitchFamily" use="optional" default="0"/>
 *     <xsd:attribute name="charset" type="xsd:byte" use="optional" default="1"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class TextFont extends ComplexAbstract
{
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'typeface' => new TextTypeface(),
            'panose' => new Panose(),
            'pitchFamily' => new PitchFamily(0),
            'charset' => 1,
        );

        parent::__construct($tagName, $attributes, $options);
    }


    public function toCss()
    {
        if (method_exists($this->root, 'getTheme')) {
            return $this->root->getTheme()->getFont($this->typeface->get());
        } else {
            return $this->typeface->get();
        }
    }
} 