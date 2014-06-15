<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/14/14
 * Time: 9:56 PM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Presentation\Main\Simple\SlideMasterId;

/**
 * Class SlideMasterIdListEntry
 * <xsd:complexType name="CT_SlideMasterIdListEntry">
 *     <xsd:sequence>
 *         <xsd:element name="extLst" type="CT_ExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="id" type="ST_SlideMasterId" use="optional"/>
 *     <xsd:attribute ref="r:id" use="required"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Presentation\Main\Complex
 */
class SlideMasterIdListEntry extends ComplexAbstract
{
    /**
     * @param $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'id' => new SlideMasterId(),
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