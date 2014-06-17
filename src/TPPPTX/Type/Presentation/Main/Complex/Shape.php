<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/12/14
 * Time: 11:03 PM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class Shape
 * <xsd:complexType name="CT_Shape">
 *     <xsd:sequence>
 *         <xsd:element name="nvSpPr" type="CT_ShapeNonVisual" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="spPr" type="a:CT_ShapeProperties" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="style" type="a:CT_ShapeStyle" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="txBody" type="a:CT_TextBody" minOccurs="0" maxOccurs="1"/>
 *         <xsd:element name="extLst" type="CT_ExtensionListModify" minOccurs="0" maxOccurs="1"/>
 *     </xsd:sequence>
 *     <xsd:attribute name="useBgFill" type="xsd:boolean" use="optional" default="false"/>
 * </xsd:complexType>
 * @package TPPPTX\Type\Complex
 */
class Shape extends ComplexAbstract
{
    /**
     * @var Shape
     */
    protected $placeholder = null;

    /**
     * @var array
     */
    protected $sequence = array(
        'nvSpPr' => 'Presentation\\Main\\Complex\\ShapeNonVisual',
        'spPr' => 'Drawing\\Main\\Complex\\ShapeProperties',
        'style' => 'Drawing\\Main\\Complex\\ShapeStyle',
        'txBody' => 'Drawing\\Main\\Complex\\TextBody',
//        'extLst' => 'Presentation\\Main\\Complex\\CT_ExtensionListModify',
    );


    /**
     * @param $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->attributes = array(
            'useBgFill' => false,
        );

        parent::__construct($tagName = '', $attributes, $options);
    }


    /**
     * @param \DOMDocument $dom
     * @return bool|\DOMElement
     */
    public function toHtmlDom(\DOMDocument $dom)
    {
        $container = $dom->createElement('div');
        $container->setAttribute('class', 'shape');

//        if ($GLOBALS['counter']++ == 5){
//            die;
//        }

        $shapeStyle = '';
        // Placeholder processing
        if ($this->isPlaceholder()) {
            // This is a placeholder =)
            if ($this->root instanceof Slide) {
                // Do merging
//                d($this);
                $merged = unserialize(serialize($this->getPlaceholder()));
                $merged->merge($this);

//                d($this, $merged);

                if ($tmp = array_shift($merged->children('spPr')))
                    $container->setAttribute('style', $tmp->toCss());

                if ($tmp = array_shift($merged->children('txBody')))
                    $container->appendChild($tmp->toHtmlDom($dom));

                unset($merged);
            } else if ($this->root instanceof SlideLayout) {
                // Placeholders are not to be shown if not overridden
                return false;
            }
        } else {
            if ($tmp = array_shift($this->children('spPr')))
                $container->setAttribute('style', $tmp->toCss());

            if ($tmp = array_shift($this->children('txBody')))
                if ($p = $tmp->toHtmlDom($dom))
                    $container->appendChild($p);
        }


        return $container;
    }


    /**
     * Will also load the placeholder to var
     * @return bool
     * @todo move placeholder loading from layout somewhere else
     */
    public function isPlaceholder()
    {
        if ($tmp = array_shift($this->children('nvSpPr'))) {
            if ($tmp = array_shift($tmp->children('nvPr'))) {
                if ($tmp = array_shift($tmp->children('ph'))) {
                    if ($this->root instanceof Slide) {
                        // Find a placeholder in Layout
                        $layout = $this->root->getLayout();
                        $this->placeholder = $layout->findPlaceholder($this->getPlaceholderId());
                    }

                    return true;
                }
            }
        }

        return false;
    }


    /**
     * Returns a Shape from Layout
     * @return mixed|null|Shape
     */
    public function getPlaceholder()
    {
        if ($this->placeholder) {
            return $this->placeholder;
        }
        if ($tmp = array_shift($this->children('nvSpPr'))) {
            if ($tmp = array_shift($tmp->children('nvPr'))) {
                if ($tmp = array_shift($tmp->children('ph'))) {
                    if ($this->root instanceof Slide) {
                        // Find a placeholder in Layout
                        $layout = $this->root->getLayout();
                        $this->placeholder = $layout->findPlaceholder($this->getPlaceholderId());

                        return $this->placeholder;
                    }
                }
            }
        }

        return null;
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

        return false;
    }


    /**
     * @param Shape $placeholder
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;
    }
}