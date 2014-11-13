<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 11/12/14
 * Time: 10:17 PM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\BlackWhiteMode;

/**
 * Class GraphicalObjectFrame
 * <xsd:complexType name="CT_GraphicalObjectFrame">
 *     <xsd:sequence>
 *         <xsd:element name="nvGraphicFramePr" type="CT_GraphicalObjectFrameNonVisual" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="xfrm" type="a:CT_Transform2D" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element ref="a:graphic" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_ExtensionListModify" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="bwMode" type="a:ST_BlackWhiteMode" use="optional"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Presentation\Main\Complex
 */
class GraphicalObjectFrame extends ComplexAbstract{

    protected $sequence = array(
        'nvGraphicFramePr' => 'Presentation\\Main\\Complex\\GraphicalObjectFrameNonVisual',
        'xfrm' => 'Drawing\\Main\\Complex\\Transform2D',
        'graphic' => 'Drawing\\Main\\Complex\\GraphicalObject',

//        'extLst' => 'Presentation\\Main\\Complex\\ExtensionListModify',
    );

    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'bwMode' => new BlackWhiteMode(),
        );

        parent::__construct($tagName, $attributes, $options);
    }


} 