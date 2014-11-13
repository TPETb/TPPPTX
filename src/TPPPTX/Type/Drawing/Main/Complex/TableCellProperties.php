<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 11/13/14
 * Time: 1:55 AM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\Coordinate32;
use TPPPTX\Type\Drawing\Main\Simple\TextAnchoringType;
use TPPPTX\Type\Drawing\Main\Simple\TextHorzOverflowType;
use TPPPTX\Type\Drawing\Main\Simple\TextVerticalType;

/**
 * Class TableCellProperties
 * <xsd:complexType name="CT_TableCellProperties">
 *     <xsd:sequence>
 *         <xsd:element name="lnL" type="CT_LineProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="lnR" type="CT_LineProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="lnT" type="CT_LineProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="lnB" type="CT_LineProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="lnTlToBr" type="CT_LineProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="lnBlToTr" type="CT_LineProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="cell3D" type="CT_Cell3D" minOccurs="0" maxOccurs="1"/>
 *         <xsd:group ref="EG_FillProperties" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="headers" type="CT_Headers" minOccurs="0"/>
 *         <xsd:element name="extLst" type="CT_OfficeArtExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="marL" type="ST_Coordinate32" use="optional" default="91440"/>
 *     <xsd:attribute name="marR" type="ST_Coordinate32" use="optional" default="91440"/>
 *     <xsd:attribute name="marT" type="ST_Coordinate32" use="optional" default="45720"/>
 *     <xsd:attribute name="marB" type="ST_Coordinate32" use="optional" default="45720"/>
 *     <xsd:attribute name="vert" type="ST_TextVerticalType" use="optional" default="horz"/>
 *     <xsd:attribute name="anchor" type="ST_TextAnchoringType" use="optional" default="t"/>
 *     <xsd:attribute name="anchorCtr" type="xsd:boolean" use="optional" default="false"/>
 *     <xsd:attribute name="horzOverflow" type="ST_TextHorzOverflowType" use="optional" default="clip"
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class TableCellProperties extends ComplexAbstract
{

    /**
     * @var array
     */
    protected $sequence = array(
        'lnL' => 'Drawing\\Main\\Complex\\LineProperties',
        'lnR' => 'Drawing\\Main\\Complex\\LineProperties',
        'lnT' => 'Drawing\\Main\\Complex\\LineProperties',
        'lnB' => 'Drawing\\Main\\Complex\\LineProperties',
        'lnTlToBr' => 'Drawing\\Main\\Complex\\LineProperties',
        'lnBlToTr' => 'Drawing\\Main\\Complex\\LineProperties',

//        'cell3D' => 'Drawing\\Main\\Complex\\Cell3D',

//        'headers' => 'Drawing\\Main\\Complex\\Headers',
        'extLst' => 'Drawing\\Main\\Complex\\OfficeArtExtensionList',
    );


    /**
     * @param string $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'marL' => new Coordinate32(),
            'marR' => new Coordinate32(),
            'marT' => new Coordinate32(),
            'marB' => new Coordinate32(),
            'vert' => new TextVerticalType(),
            'anchor' => new TextAnchoringType(),
            'anchorCtr' => false,
            'horzOverflow' => new TextHorzOverflowType(),
        );

        parent::__construct($tagName, $attributes, $options);
    }


    public function toHtmlDom(\DOMDocument $dom, $options = array())
    {
        return null;
    }


    public function toCssInline()
    {
        return 'border:1pt solid black;';
    }
}