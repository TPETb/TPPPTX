<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 11/13/14
 * Time: 1:48 AM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\Drawing\Main\Simple\Coordinate;

/**
 * Class TableRow
 * <xsd:complexType name="CT_TableRow">
 *     <xsd:sequence>
 *         <xsd:element name="tc" type="CT_TableCell" minOccurs="0" maxOccurs="unbounded"/>
 *         <xsd:element name="extLst" type="CT_OfficeArtExtensionList" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="h" type="ST_Coordinate" use="required"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class TableRow extends ComplexAbstract
{
    /**
     * @var array
     */
    protected $sequence = array(
        'tc' => 'Drawing\\Main\\Complex\\TableCell',
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
            'h' => new Coordinate(),
        );

        parent::__construct($tagName, $attributes, $options);
    }


    /**
     * The issue with this exact case of toHtmlDom is that child (TableCell) doesn't know what's its number
     * therefore only this class can address TableGrid with proper $colNum to get width
     *
     * @param \DOMDocument $dom
     * @param array $options
     * @return \DOMElement
     * @todo add extLst children loop
     */
    public function toHtmlDom(\DOMDocument $dom, $options = array())
    {
        $container = $dom->createElement('tr');
        if (isset($options['class'])) {
            $container->setAttribute('class', $options['class']);
        }

        $style = '';
        $i = 0;
        foreach ($this->getChildren('tc') as $child) {
            if (method_exists($child, 'toCssInline')) {
                $style .= $child->toCssInline();
            }
            if (!isset($options['noChildren']) && $tmp = $child->toHtmlDom($dom)) {
                $i++;
                $tmp->setAttribute('style', $tmp->getAttribute('style') . 'width:' . $this->parent->child('tblGrid')->getColWidth($i) . ';');
                $container->appendChild($tmp);
            }
        }

        $container->setAttribute('style', $style);

        if (isset($_GET['show_class'])) {
            $container->setAttribute('data-class', get_called_class());
        }

        return $container;
    }


} 