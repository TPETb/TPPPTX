<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/13/14
 * Time: 4:23 PM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class SlideIdList
 * <xsd:complexType name="CT_SlideIdList">
 *     <xsd:sequence>
 *         <xsd:element name="sldId" type="CT_SlideIdListEntry" minOccurs="0" maxOccurs="unbounded"/>
 *     </xsd:sequence>
 * </xsd:complexType>
 * @package TPPPTX\Type\Presentation\Main\Complex
 */
class SlideIdList extends ComplexAbstract
{
    protected $sequence = array(
        'sldId' => 'Presentation\\Main\\Complex\\SlideIdListEntry',
    );
} 