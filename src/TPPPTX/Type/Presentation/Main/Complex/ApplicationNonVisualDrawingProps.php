<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/15/14
 * Time: 5:59 PM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;

use TPPPTX\Type\ComplexAbstract;

/**
 * Class ApplicationNonVisualDrawingProps
 * <xsd:complexType name="CT_ApplicationNonVisualDrawingProps">
 *     <xsd:sequence>
 *         <xsd:element name="ph" type="CT_Placeholder" minOccurs="0" maxOccurs="1"/>
 *         <xsd:group ref="a:EG_Media" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="custDataLst" type="CT_CustomerDataList" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_ExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="isPhoto" type="xsd:boolean" use="optional" default="false"/>
 *     <xsd:attribute name="userDrawn" type="xsd:boolean" use="optional" default="false"/>
 * </xsd:complexType>
 *
 * <xsd:group name="EG_Media">
 *     <xsd:choice>
 *         <xsd:element name="audioCd" type="CT_AudioCD"/>
 *         <xsd:element name="wavAudioFile" type="CT_EmbeddedWAVAudioFile"/>
 *         <xsd:element name="audioFile" type="CT_AudioFile"/>
 *         <xsd:element name="videoFile" type="CT_VideoFile"/>
 *         <xsd:element name="quickTimeFile" type="CT_QuickTimeFile"/>
 *     </xsd:choice>
 * </xsd:group>
 * @package TPPPTX\Type\Presentation\Main\Complex
 */
class ApplicationNonVisualDrawingProps extends ComplexAbstract
{
    /**
     * @var array
     */
    protected $sequence = array(
        'ph' => 'Presentation\\Main\\Complex\\Placeholder',

//        'audioCd' => 'Presentation\\Main\\Complex\\AudioCD',
//        'wavAudioFile' => 'Presentation\\Main\\Complex\\EmbeddedWAVAudioFile',
//        'audioFile' => 'Presentation\\Main\\Complex\\AudioFile',
//        'videoFile' => 'Presentation\\Main\\Complex\\VideoFile',
//        'quickTimeFile' => 'Presentation\\Main\\Complex\\QuickTimeFile',
//
//        'custDataLst' => 'Presentation\\Main\\Complex\\CustomerDataList',
//        'extLst' => 'Presentation\\Main\\Complex\\ExtensionList',
    );


    /**
     * @param string $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'isPhoto' => 'false',
            'userDrawn' => 'false',
        );

        parent::__construct($tagName, $attributes, $options);
    }


} 