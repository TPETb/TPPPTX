<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/16/14
 * Time: 10:02 PM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class SlideMasterTextStyles
 * <xsd:complexType name="CT_SlideMasterTextStyles">
 *     <xsd:sequence>
 *         <xsd:element name="titleStyle" type="a:CT_TextListStyle" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="bodyStyle" type="a:CT_TextListStyle" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="otherStyle" type="a:CT_TextListStyle" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_ExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 * </xsd:complexType>
 * @package TPPPTX\Type\Presentation\Main\Complex
 */
class SlideMasterTextStyles extends ComplexAbstract
{
    protected $sequence = array(
        'titleStyle' => 'Drawing\\Main\\Complex\\TextListStyle',
        'bodyStyle' => 'Drawing\\Main\\Complex\\TextListStyle',
        'otherStyle' => 'Drawing\\Main\\Complex\\TextListStyle',
    );
} 