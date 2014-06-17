<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/16/14
 * Time: 10:03 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\ColorSchemeIndex;

/**
 * Class ColorMapping
 * <xsd:complexType name="CT_ColorMapping">
 *     <xsd:sequence>
 *         <xsd:element name="extLst" type="CT_OfficeArtExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="bg1" type="ST_ColorSchemeIndex" use="required"/>
 *     <xsd:attribute name="tx1" type="ST_ColorSchemeIndex" use="required"/>
 *     <xsd:attribute name="bg2" type="ST_ColorSchemeIndex" use="required"/>
 *     <xsd:attribute name="tx2" type="ST_ColorSchemeIndex" use="required"/>
 *     <xsd:attribute name="accent1" type="ST_ColorSchemeIndex" use="required"/>
 *     <xsd:attribute name="accent2" type="ST_ColorSchemeIndex" use="required"/>
 *     <xsd:attribute name="accent3" type="ST_ColorSchemeIndex" use="required"/>
 *     <xsd:attribute name="accent4" type="ST_ColorSchemeIndex" use="required"/>
 *     <xsd:attribute name="accent5" type="ST_ColorSchemeIndex" use="required"/>
 *     <xsd:attribute name="accent6" type="ST_ColorSchemeIndex" use="required"/>
 *     <xsd:attribute name="hlink" type="ST_ColorSchemeIndex" use="required"/>
 *     <xsd:attribute name="folHlink" type="ST_ColorSchemeIndex" use="required"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class ColorMapping extends ComplexAbstract
{

    protected $sequence = array(
//        'extLst' => 'Drawing\\Main\\Complex\\OfficeArtExtensionList',
    );


    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'bg1' => new ColorSchemeIndex(),
            'tx1' => new ColorSchemeIndex(),
            'bg2' => new ColorSchemeIndex(),
            'tx2' => new ColorSchemeIndex(),
            'accent1' => new ColorSchemeIndex(),
            'accent2' => new ColorSchemeIndex(),
            'accent3' => new ColorSchemeIndex(),
            'accent4' => new ColorSchemeIndex(),
            'accent5' => new ColorSchemeIndex(),
            'accent6' => new ColorSchemeIndex(),
            'hlink' => new ColorSchemeIndex(),
            'folHlink' => new ColorSchemeIndex(),
        );

        parent::__construct($tagName, $attributes, $options);
    }
}