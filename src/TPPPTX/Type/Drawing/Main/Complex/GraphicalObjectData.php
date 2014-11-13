<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 11/13/14
 * Time: 1:14 AM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class GraphicalObjectData
 * <xsd:complexType name="CT_GraphicalObjectData">
 *     <xsd:sequence>
 *         <xsd:any minOccurs="0" maxOccurs="unbounded" processContents="strict"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="uri" type="xsd:token" use="required"/>
 * </xsd:complexType>
 *
 * The XSD doesn't strictly define possible elements inside this node
 * One needs to study actual slides for any success
 *
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class GraphicalObjectData extends ComplexAbstract
{
    /**
     * @var array
     */
    protected $sequence = array(
        'tbl' => 'Drawing\\Main\\Complex\\Table',
    );


    /**
     * @param string $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'uri' => '',
        );

        parent::__construct($tagName, $attributes, $options);
    }


} 