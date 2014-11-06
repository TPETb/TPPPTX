<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 11/4/14
 * Time: 6:32 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * <xsd:complexType name="CT_StretchInfoProperties">
 *     <xsd:sequence>
 *         <xsd:element name="fillRect" type="CT_RelativeRect" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 * </xsd:complexType>
 * Class StretchInfoProperties
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class StretchInfoProperties extends ComplexAbstract
{

    protected $sequence = array(
        'fillRect' => 'Drawing\\Main\\Complex\\RelativeRect',
    );

    /**
     * This is a hack from some point of view. According to spec, the presence of fillRect
     * element already means blip will be stretched to container. Probably this needs another check.
     * todo do the mentioned above check
     * @return string
     */
    public function toCssInline()
    {
        /**
         * todo this hack relates to BlipFillProperties class too
         */
        return '';
        return $this->child('fillRect') ? 'width:100%; height: 100%;' : '';
    }


    public function toHtmlDom(\DOMDocument $dom, $options = array())
    {
        return null;
    }
}