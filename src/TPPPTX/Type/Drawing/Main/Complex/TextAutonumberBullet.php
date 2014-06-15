<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/15/14
 * Time: 11:12 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\TextAutonumberScheme;
use TPPPTX\Type\Drawing\Main\Simple\TextBulletStartAtNum;

/**
 * Class TextAutonumberBullet
 * <xsd:complexType name="CT_TextAutonumberBullet">
 *     <xsd:attribute name="type" type="ST_TextAutonumberScheme" use="required"/>
 *     <xsd:attribute name="startAt" type="ST_TextBulletStartAtNum" use="optional" default="1"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class TextAutonumberBullet extends ComplexAbstract
{
    /**
     * @param string $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'type' => new TextAutonumberScheme(),
            'startAt' => new TextBulletStartAtNum(1),
        );

        parent::__construct($tagName, $attributes, $options);
    }

} 