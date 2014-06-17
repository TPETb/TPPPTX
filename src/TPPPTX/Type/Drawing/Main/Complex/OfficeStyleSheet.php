<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/16/14
 * Time: 10:21 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\RootAbstract;

/**
 * Class OfficeStyleSheet
 * <xsd:complexType name="CT_OfficeStyleSheet">
 *     <xsd:sequence>
 *         <xsd:element name="themeElements" type="CT_BaseStyles" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="objectDefaults" type="CT_ObjectStyleDefaults" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="extraClrSchemeLst" type="CT_ColorSchemeList" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="custClrLst" type="CT_CustomColorList" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_OfficeArtExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="name" type="xsd:string" use="optional" default=""/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class OfficeStyleSheet extends RootAbstract
{
    protected $sequence = array(
        'themeElements' => 'Drawing\\Main\\Complex\\BaseStyles',
//        'objectDefaults' => 'Drawing\\Main\\Complex\\ObjectStyleDefaults',
//        'extraClrSchemeLst' => 'Drawing\\Main\\Complex\\ColorSchemeList',
//        'custClrLst' => 'Drawing\\Main\\Complex\\CustomColorList',
//        'extLst' => 'Drawing\\Main\\Complex\\OfficeArtExtensionList',
    );


    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'name' => '',
        );

        parent::__construct($tagName, $attributes, $options);
    }


    function getFont($name)
    {
        switch ($name) {
            case '+mj-lt':
                $name = 'majorFont';
                break;
            case '+mn-lt':
                $name = 'minorFont';
                break;
            default:
                return $name;
                break;
        }

        return $this->children('themeElements')[0]->children('fontScheme')[0]->children($name)[0]->children('latin')[0]->toCss();
    }


    function getColor($name)
    {
        return $this->children('themeElements')[0]->children('clrScheme')[0]->children($name)[0]->toCss();
    }
} 