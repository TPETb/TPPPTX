<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 8/27/14
 * Time: 3:43 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class CustomGeometry2D
 * <xsd:complexType name="CT_CustomGeometry2D">
 *     <xsd:sequence>
 *        <xsd:element name="avLst" type="CT_GeomGuideList" minOccurs="0"
 *        <xsd:element name="gdLst" type="CT_GeomGuideList" minOccurs="0"
 *        <xsd:element name="ahLst" type="CT_AdjustHandleList" minOccurs="0" maxOccurs="1"/>
 *        <xsd:element name="cxnLst" type="CT_ConnectionSiteList" minOccurs="0" maxOccurs="1"/>
 *        <xsd:element name="rect" type="CT_GeomRect" minOccurs="0" maxOccurs="1"/>
 *        <xsd:element name="pathLst" type="CT_Path2DList" minOccurs="1" maxOccurs="1"/>
 *     </xsd:sequence>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class CustomGeometry2D extends ComplexAbstract
{
    /**
     * @var array
     */
    protected $sequence = array(
        'avLst' => 'Drawing\\Main\\Complex\\GeomGuideList',
        'gdLst' => 'Drawing\\Main\\Complex\\GeomGuideList',
        'ahLst' => 'Drawing\\Main\\Complex\\AdjustHandleList',
        'cxnLst' => 'Drawing\\Main\\Complex\\ConnectionSiteList',
        'rect' => 'Drawing\\Main\\Complex\\GeomRect',
        'pathLst' => 'Drawing\\Main\\Complex\\Path2DList',
    );


    /**
     * @param string $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
        );

        parent::__construct($tagName, $attributes, $options);
    }
} 