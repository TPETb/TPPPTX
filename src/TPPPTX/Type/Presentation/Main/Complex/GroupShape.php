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

        'sp' => 'Presentation\\Main\\Complex\\Shape',
        'grpSp' => 'Presentation\\Main\\Complex\\GroupShape',
//        'graphicFrame' => 'Presentation\\Main\\Complex\\GraphicalObjectFrame',
        'cxnSp' => 'Presentation\\Main\\Complex\\Connector',
        'pic' => 'Presentation\\Main\\Complex\\Picture',
//        'contentPart' => 'Presentation\\Main\\Complex\\Rel',

//        'extLst' => 'Presentation\\Main\\Complex\\ExtensionListModify',
    );


    /**
     * @param \DOMDocument $dom
     * @return \DOMElement
     */
    public function toHtmlDom(\DOMDocument $dom)
    {
        $container = parent::toHtmlDom($dom);
        $container->setAttribute('class', 'shape-group');

        return $container;
    }


    /**
     * @return bool
     */
    public function isPlaceholder()
    {
        if ($tmp = array_shift($this->getChildren('nvSpPr'))) {
            if ($tmp = array_shift($tmp->getChildren('nvPr'))) {
                if ($tmp = array_shift($tmp->getChildren('ph'))) {
                    return true;
                }
            }
        }

        return false;
    }


    public function merge(ComplexAbstract $ancestor)
    {
        foreach ($this->getAttributes() as $key => $value) {
            if (($value instanceof SimpleAbstract && !$value->isPresent())
                || $value == null
            ) {
                $this->setAttribute($key, $ancestor->$key);
            }
        }

        /**
         * This whole thing bases on assumption that placeholders and shapes are matched by their order of appearance in xml
         * Isn't it sweet to rely on such "solid" thing, dear MS?
         */
        $counters = array(
            'sp' => 0,
            'grpSp' => 0,
        );
        foreach ($ancestor->getChildren() as $aChild) {
            switch ($aChild->tagName) {
                case 'grpSp':
                case 'sp':
                    if ($aChild->isPlaceholder()) {
                        if (isset($this->children[$aChild->tagName . $counters[$aChild->tagName]])) {
                            $this->children[$aChild->tagName . $counters[$aChild->tagName]]->merge($aChild);
                        }
                    } else {
                        $this->addChild($aChild);
                    }
                    $counters[$aChild->tagName]++;
                    break;
                case 'pic':
                case 'cxnSp':
                $this->addChild($aChild);
                    break;
            }
        }
//
//
//        foreach ($ancestor->getChildren('grpSp') as $key => $aGroup) {
//            if ($aGroup->isPlaceholder()) {
//                if (isset($this->children['grpSp' . $key])) {
//                    $this->children['grpSp' . $key]->merge($aGroup);
//                }
//            } else {
//                $this->addChild($aGroup);
//            }
//        }
//
//        foreach ($ancestor->getChildren('sp') as $key => $aShape) {
//            if ($aShape->isPlaceholder()) {
//                if (isset($this->children['sp' . $key])) {
//                    $this->children['sp' . $key]->merge($aShape);
//                }
//            } else {
//                $this->addChild($aShape);
//            }
//        }
//
//        // Connectors and Pics are cheap - just add all
//        foreach ($ancestor->getChildren('cxnSp pic') as $aChild) {
//            $this->addChild($aChild);
//        }
    }


}