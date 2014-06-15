<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/15/14
 * Time: 6:02 PM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Presentation\Main\Simple\Direction;
use TPPPTX\Type\Presentation\Main\Simple\PlaceholderSize;
use TPPPTX\Type\Presentation\Main\Simple\PlaceholderType;

/**
 * Class Placeholder
 * <xsd:complexType name="CT_Placeholder">
 *     <xsd:sequence>
 *         <xsd:element name="extLst" type="CT_ExtensionListModify" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="type" type="ST_PlaceholderType" use="optional" default="obj"/>
 *     <xsd:attribute name="orient" type="ST_Direction" use="optional" default="horz"/>
 *     <xsd:attribute name="sz" type="ST_PlaceholderSize" use="optional" default="full"/>
 *     <xsd:attribute name="idx" type="xsd:unsignedInt" use="optional" default="0"/>
 *     <xsd:attribute name="hasCustomPrompt" type="xsd:boolean" use="optional" default="false"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Presentation\Main\Complex
 */
class Placeholder extends ComplexAbstract
{
    /**
     * @var array
     */
    protected $sequence = array( //        'extLst' => 'Presentation\\Main\\Complex\\ExtensionListModify',
    );


    /**
     * @param string $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'type' => new PlaceholderType('obj'),
            'orient' => new Direction('horz'),
            'sz' => new PlaceholderSize('full'),
            'idx' => 0,
            'hasCustomPrompt' => 'false',
        );

        parent::__construct($tagName, $attributes, $options);
    }

} 