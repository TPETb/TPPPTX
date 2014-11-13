<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 11/13/14
 * Time: 1:45 AM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class TableGrid
 * <xsd:complexType name="CT_TableGrid">
 *     <xsd:sequence>
 *         <xsd:element name="gridCol" type="CT_TableCol" minOccurs="0" maxOccurs="unbounded"/>
 *     </xsd:sequence>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class TableGrid extends ComplexAbstract
{
    protected $sequence = array(
        'gridCol' => 'Drawing\\Main\\Complex\\TableCol',
    );

    /**
     * @param \DOMDocument $dom
     * @param array $options
     * @return null
     */
    public function toHtmlDom(\DOMDocument $dom, $options = array())
    {
        return null;
    }


    public function getColWidth($colNum)
    {
        if ($colNum > $this->getChildren('gridCol')) {
            throw new \Exception('Referencing unknown col');
        }

        return $this->getChildren('gridCol')[$colNum - 1]->w->toCss();
    }
} 