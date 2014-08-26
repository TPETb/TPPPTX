<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 8/26/14
 * Time: 4:32 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\PresetLineDashVal;

/**
 * Class PresetLineDashProperties
 * <xsd:complexType name="CT_PresetLineDashProperties">
 *     <xsd:attribute name="val" type="ST_PresetLineDashVal" use="optional"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class PresetLineDashProperties extends ComplexAbstract
{
    /**
     * @var array
     */
    protected $sequence = array();


    /**
     * @param string $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'val' => new PresetLineDashVal(),
        );

        parent::__construct($tagName, $attributes, $options);
    }


    public function toCssInline()
    {
        $style = '';

        if ($this->child('prstDash')) {
            $style .= ' border-style: ' . $this->val->toCss() . ';';
        } else {
            $style .= ' border-style: solid;';
        }

        return $style;
    }
}