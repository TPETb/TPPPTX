<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/12/14
 * Time: 11:22 PM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;


use TPPPTX\Type\ComplexAbstract;
use TPPPTX\Type\SimpleAbstract;

/**
 * Class GroupShape
 * <xsd:complexType name="CT_GroupShape">
 *     <xsd:sequence>
 *         <xsd:element name="nvGrpSpPr" type="CT_GroupShapeNonVisual" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="grpSpPr" type="a:CT_GroupShapeProperties" minOccurs="1" maxOccurs="1"/>
 *         <xsd:choice minOccurs="0" maxOccurs="unbounded">
 *             <xsd:element name="sp" type="CT_Shape"/>
 *             <xsd:element name="grpSp" type="CT_GroupShape"/>
 *             <xsd:element name="graphicFrame" type="CT_GraphicalObjectFrame"/>
 *             <xsd:element name="cxnSp" type="CT_Connector"/>
 *             <xsd:element name="pic" type="CT_Picture"/>
 *             <xsd:element name="contentPart" type="CT_Rel"/>
 *         </xsd:choice>
 *         <xsd:element name="extLst" type="CT_ExtensionListModify" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 * </xsd:complexType>
 * @package TPPPTX\Type\Presentation\Main\Complex
 */
class GroupShape extends ComplexAbstract
{

    /**
     * @var array
     */
    protected $sequence = array(
//        'nvGrpSpPr' => 'Presentation\\Main\\Complex\\GroupShapeNonVisual',
        'grpSpPr' => 'Drawing\\Main\\Complex\\GroupShapeProperties',

        'grpSp' => 'Presentation\\Main\\Complex\\GroupShape',
        'sp' => 'Presentation\\Main\\Complex\\Shape',
        'pic' => 'Presentation\\Main\\Complex\\Picture',
//        'graphicFrame' => 'Presentation\\Main\\Complex\\GraphicalObjectFrame',
//        'pic' => 'Presentation\\Main\\Complex\\Picture',
//        'contentPart' => 'Presentation\\Main\\Complex\\Rel',

        'extLst' => 'Presentation\\Main\\Complex\\ExtensionListModify',
    );


    /**
     * @param \DOMDocument $dom
     * @return \DOMElement
     */
    public function toHtmlDom(\DOMDocument $dom)
    {
        $container = $dom->createElement('div');
        $container->setAttribute('class', 'shape-group');

        if ($tmp = $this->children('grpSpPr'))
            $container->setAttribute('style', $tmp[0]->toCss());

        foreach ($this->children('grpSp sp pic') as $shape) {
            if ($tmp = $shape->toHtmlDom($dom))
                $container->appendChild($tmp);
        }

        return $container;
    }


    /**
     * @return bool
     */
    public function isPlaceholder()
    {
        if ($tmp = array_shift($this->children('nvSpPr'))) {
            if ($tmp = array_shift($tmp->children('nvPr'))) {
                if ($tmp = array_shift($tmp->children('ph'))) {
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * @return string
     */
    public function getPlaceholderId()
    {
        if ($tmp = array_shift($this->children('nvSpPr'))) {
            if ($tmp = array_shift($tmp->children('nvPr'))) {
                if ($tmp = array_shift($tmp->children('ph'))) {
                    // This is a placeholder =)
                    return $tmp->type->get() . $tmp->idx;
                }
            }
        }
    }


    /**
     * @param $id
     * @return $this|bool
     */
    public function findPlaceholder($id)
    {
        if ($this->isPlaceholder() && $this->getPlaceholderId() == $id) {
            return $this;
        }


        foreach ($this->children('grpSp') as $group) {
            if ($ph = $group->findPlaceholder($id)) {
                return $ph;
            }
        }

        foreach ($this->children('sp') as $shape) {
            if ($shape->isPlaceholder() && $shape->getPlaceholderId() == $id) {
                return $shape;
            }
        }

        return false;
    }


    public function merge(ComplexAbstract $successor)
    {
        $this->nodeValue = $successor->nodeValue;
        $this->root = $successor->root;
        $this->parent = $successor->parent;

        foreach ($successor->getAttributes() as $key => $value) {
            if (($value instanceof SimpleAbstract && $value->isPresent())
                || $value !== null
            ) {
                $this->setAttribute($key, $value);
            }
        }

        // Merge groups
        // First check if there are placeholders in parent (generally parent is Layout and successor is Slide)
        /**
         * This whole thing bases on assumption that placeholders and shapes are matched by their order of appearance in xml
         * Isn't it sweet to rely on such "solid" thing, dear MS?
         */
        foreach ($successor->children('grpSp') as $key => $sGroup) {
            if (isset($this->children('grpSp')[$key]) && $this->children('grpSp')[$key]->isPlaceholder()) {
                $this->children('grpSp')[$key]->merge($sGroup);
            } else {
                $this->addChild($sGroup);
            }
        }

        // Merge shapes
        // First check if there are placeholders in parent (generally parent is Layout and successor is Slide)
        /**
         * This whole thing bases on assumption that placeholders and shapes are matched by their order of appearance in xml
         * Isn't it sweet to rely on such "solid" thing, dear MS?
         */
        foreach ($successor->children('sp') as $key => $sGroup) {
            if (isset($this->children('sp')[$key]) && $this->children('sp')[$key]->isPlaceholder()) {
                $this->children('sp')[$key]->merge($sGroup);
            } else {
                $this->addChild($sGroup);
            }
        }

        // Todo remove placeholders that found no merge
    }


}