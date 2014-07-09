<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 7/9/14
 * Time: 5:42 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class VideoFile
 * <xsd:complexType name="CT_VideoFile">
 *     <xsd:sequence>
 *         <xsd:element name="extLst" type="CT_OfficeArtExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute ref="r:link" use="required"/>
 *     <xsd:attribute name="contentType" type="xsd:string" use="optional"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class VideoFile extends ComplexAbstract
{
    protected $sequence = array(
//        'extLst' => 'Drawing\\Main\\Complex\\OfficeArtExtensionList',
    );


    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'r:link' => '',
            'contentType' => '',
        );

        parent::__construct($tagName, $attributes, $options);
    }


    public function getFilepath()
    {
        return '#base_path#/' . $this->root->getRelations()[$this->getAttribute('r:link')]['target'];
    }
} 