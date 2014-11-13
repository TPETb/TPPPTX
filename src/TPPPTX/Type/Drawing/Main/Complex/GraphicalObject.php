<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 11/13/14
 * Time: 1:11 AM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class GraphicalObject
 * <xsd:complexType name="CT_GraphicalObject">
 *     <xsd:sequence>
 *         <xsd:element name="graphicData" type="CT_GraphicalObjectData"/>
 *     </xsd:sequence>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class GraphicalObject extends ComplexAbstract
{
    protected $sequence = array(
        'graphicData' => 'Drawing\\Main\\Complex\\GraphicalObjectData',
    );
} 