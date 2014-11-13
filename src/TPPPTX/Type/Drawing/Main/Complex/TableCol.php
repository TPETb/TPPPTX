<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 11/13/14
 * Time: 1:46 AM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\Coordinate;

/**
 * Class TableCol
<xsd:complexType name="CT_TableCol">
    <xsd:sequence>
        <xsd:element name="extLst" type="CT_OfficeArtExtensionList" minOccurs="0" maxOccurs="1"/>
    </xsd:sequence>
    <xsd:attribute name="w" type="ST_Coordinate" use="required"/>
</xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class TableCol extends ComplexAbstract{
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'w' => new Coordinate()
        );

        parent::__construct($tagName, $attributes, $options);
    }

} 