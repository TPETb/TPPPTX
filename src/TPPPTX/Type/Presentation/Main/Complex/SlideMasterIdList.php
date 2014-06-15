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
 * Class SlideMasterIdList
 * <xsd:complexType name="CT_SlideMasterIdList">
 *     <xsd:sequence>
 *         <xsd:element name="sldMasterId" type="CT_SlideMasterIdListEntry" minOccurs="0" maxOccurs="unbounded"/>
 *     </xsd:sequence>
 * </xsd:complexType>
 * @package TPPPTX\Type\Presentation\Main\Complex
 */
class SlideMasterIdList extends ComplexAbstract
{
    /**
     * @var array
     */
    protected $sequence = array(
        'sldMasterId' => 'Presentation\\Main\\Complex\\SlideMasterIdListEntry',
    );
} 