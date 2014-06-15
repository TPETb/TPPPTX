<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/15/14
 * Time: 1:53 PM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class SlideIdListEntry
 * <xsd:complexType name="CT_SlideIdListEntry">
 *     <xsd:sequence>
 *         <xsd:element name="extLst" type="CT_ExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="id" type="ST_SlideId" use="required"/>
 *     <xsd:attribute ref="r:id" use="required"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Presentation\Main\Complex
 */
class SlideIdListEntry extends ComplexAbstract
{
    /**
     * @param $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'id' => '', // This should be simple type but well, who cares
            'r:id' => null,
        );

        parent::__construct($tagName = '', $attributes, $options);
    }


    /**
     * @var array
     */
    protected $sequence = array(
//        'extLst' => 'Presentation\\Main\\Complex\\ExtensionList',
    );

} 