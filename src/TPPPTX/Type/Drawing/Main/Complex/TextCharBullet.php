<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/15/14
 * Time: 5:36 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class TextCharBullet
 * <xsd:complexType name="CT_TextCharBullet">
 *     <xsd:attribute name="char" type="xsd:string" use="required"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class TextCharBullet extends ComplexAbstract {
    /**
     * @param string $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'char' => '',
        );

        parent::__construct($tagName, $attributes, $options);
    }

} 