<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/12/14
 * Time: 11:06 PM
 */

namespace TPPPTX\Type;


/**
 * Class ComplexAbstract
 * @package TPPPTX\Type
 */
abstract class ComplexAbstract
{

    /**
     * @var string
     */
    public $tagName = '';


    /**
     * @var string
     */
    public $nodeValue = '';


    /**
     * @var array
     */
    protected $attributes = array();


    /**
     * @var string[] stores mapping of child elements to php classes
     */
    protected $sequence = array();


    /**
     * @var ComplexAbstract[]
     */
    protected $children = array();


    /**
     * @var null
     */
    protected $parent = null;


    /**
     * @var null
     */
    protected $root = null;


    /**
     * @param $tagName
     * @param array $attributes
     * @param array $options
     */
    function __construct($tagName = '', $attributes = array(), $options = array())
    {
        $this->tagName = $tagName;
        $this->setAttributes($attributes);
        if (isset($options['parent']))
            $this->parent = $options['parent'];
        if (isset($options['root'])) {
            $this->root = $options['root'];
        }
    }


    function __destruct()
    {
        foreach ($this->children as $key => $child) {
            $child->__destruct();
            unset($this->children[$key]);
        }

    }


    /**
     * @param $attributes
     * @return $this
     */
    public function setAttributes($attributes)
    {
        foreach ($attributes as $key => $value) {
            if ($value instanceof \DOMAttr) {
                $name = ($value->prefix ? $value->prefix . ':' : '') . $key;
                $this->setAttribute($name, $value->value);
            } else {
                $this->setAttribute($key, $value);
            }
        }

        return $this;
    }


    /**
     * @param $name
     * @return bool
     * @throws \Exception
     */
    public function getAttribute($name)
    {
        if (!array_key_exists($name, $this->attributes)) {
            throw new \Exception("Unknown attribute {$name} requested from class " . get_called_class());
        }

        if ($this->attributes[$name] instanceof SimpleAbstract) {
            return $this->attributes[$name];
        } else if ($this->attributes[$name] === 'true') {
            return true;
        } else if ($this->attributes[$name] === 'false') {
            return false;
        } else {
            return $this->attributes[$name];
        }
    }


    /**
     * @param $name
     * @param $value
     * @return $this
     * @throws \Exception
     */
    public function setAttribute($name, $value)
    {
        if (!array_key_exists($name, $this->attributes)) {
            throw new \Exception("Unknown attribute {$name} passed to class " . get_called_class());
        }
        if ($this->attributes[$name] instanceof SimpleAbstract) {
            if ($value instanceof SimpleAbstract) {
                $this->attributes[$name] = $value;
            } else {
                $this->attributes[$name]->set($value);
            }
        } else {
            $this->attributes[$name] = $value;
        }

        return $this;
    }


    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }


    /**
     * @param string $tagName
     * @return ComplexAbstract[]
     */
    public function children($tagName = '')
    {
        $result = array();

        $tagNames = explode(' ', $tagName);

        foreach ($this->children as &$child) {
            if (!$tagName || in_array($child->tagName, $tagNames)) {
                $result[] = $child;
            }
        }

        return $result;
    }


    /**
     * @param $tagName
     * @return mixed
     */
    public function child($tagName)
    {
        return array_shift($this->children($tagName));
    }


    /**
     * @param \TPPPTX\Type\ComplexAbstract[] $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }


    /**
     * @param ComplexAbstract $child
     */
    public function addChild(ComplexAbstract $child)
    {
        $this->children[] = & $child;
    }


    /**
     * @param $name
     * @return string
     * @throws \Exception
     */
    function __get($name)
    {
        return $this->getAttribute($name);
    }


    /**
     * @param $name
     * @param $value
     * @throws \Exception
     */
    function __set($name, $value)
    {
        $this->setAttribute($name, $value);
    }


    /**
     * @param $nodeName
     * @return bool|string
     */
    public function getChildClassName($nodeName)
    {
        return isset($this->sequence[$nodeName]) ? $this->sequence[$nodeName] : false;
    }


    /**
     * @param \DOMNode $node
     * @param array $options
     * @return $this
     */
    public function fromDom(\DOMNode $node, $options = array())
    {
        $this->tagName = $node->localName;
        $this->nodeValue = $node->nodeValue;
        $this->setAttributes($node->attributes);
        if (isset($options['parent']))
            $this->parent = $options['parent'];
        if (isset($options['root']))
            $this->root = $options['root'];

        foreach ($node->childNodes as $childNode) {
            if (!$className = $this->getChildClassName($childNode->localName)) {
                continue;
            }

            /*
             * Call to static method of variable class doesn't resolve relative class path in __autoload.
             * You can try yourself if you wish, here is the code
             * d($className, __NAMESPACE__, get_called_class()); - to debug
             * d($className::fromDom($childNode)); - fails
             * d(call_user_func(array($className, 'fromDom'), $childNode)); - fails
             * d(Presentation\Main\Complex\SlideMasterIdList::fromDom($childNode)); - works
             */
            $className = __NAMESPACE__ . '\\' . $className;

            $child = new $className();
            $child->fromDom($childNode, array_merge($options, array(
                'parent' => &$this,
            )));

            $this->addChild($child);
        }

        return $this;
    }


    /**
     * Presence of this method in abstract class allows to check execution results instead of checking of method
     * presence in child classes while not all classes are implemented.
     * As all classes implemented this method can be removed.
     * @param \DOMDocument $dom
     * @return bool
     */
    public function toHtmlDom(\DOMDocument $dom)
    {
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

        foreach ($successor->children() as $sChild) {
            $matched = false;
            // If there is only one, it replaces the parental
            if (count($successor->children($sChild->tagName)) == 1) {
                foreach ($this->children as &$pChild) {
                    if ($pChild->tagName == $sChild->tagName) {
                        $pChild->merge($sChild);
                        $matched = true;
                        break;
                    }
                }
            } else {
                // There are more then one of such element so they should be appended
                // todo check elements maximum allowance rather then actual count
                throw new \Exception('ComplexAbstract failed to resolve merge of ' . get_called_class() . ' because there are many children of type ' . $sChild->tagName);
            }

            if (!$matched) {
                $this->addChild($sChild);
            }
        }
    }
} 