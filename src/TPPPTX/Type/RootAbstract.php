<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/15/14
 * Time: 1:32 PM
 */

namespace TPPPTX\Type;


use TPPPTX\Type\Presentation\Main\Complex\Presentation;

class RootAbstract extends ComplexAbstract
{
    /**
     * @var array
     */
    protected $relations = array();


    /**
     * @var Presentation
     */
    protected $presentation = null;


    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        if (isset($options['relations']))
            $this->relations = & $options['relations'];
        if (isset($options['presentation']))
            $this->presentation = & $options['presentation'];

        parent::__construct($tagName, $attributes, $options);
    }


    public function fromDom(\DOMNode $node, $options = array())
    {
        $this->tagName = $node->localName;
        $this->setAttributes($node->attributes);

        $this->relations = $options['relations'];
        if (isset($options['presentation']))
            $this->presentation = $options['presentation'];

        foreach ($node->childNodes as $childNode) {
            if (!$className = $this->getChildClassName($childNode->localName)) {
                continue;
            }
            $className = __NAMESPACE__ . '\\' . $className;

            $child = new $className();
            if (!$this->logger) {
                d(get_called_class());
            }
            $child->setLogger($this->logger);
            $child->fromDom($childNode, array_merge($options, array(
                'parent' => &$this,
                'root' => &$this,
            )));

            $this->addChild($child);
        }

        return $this;
    }


    /**
     * @param \TPPPTX\Type\Presentation\Main\Complex\Presentation $presentation
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;
    }


    /**
     * @return \TPPPTX\Type\Presentation\Main\Complex\Presentation
     */
    public function getPresentation()
    {
        return $this->presentation;
    }


    /**
     * @return array
     */
    public function getRelations()
    {
        return $this->relations;
    }




}