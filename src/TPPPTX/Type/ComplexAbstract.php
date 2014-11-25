<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/12/14
 * Time: 11:06 PM
 */

namespace TPPPTX\Type;
use Psr\Log\LoggerAwareTrait;


/**
 * Class ComplexAbstract
 * @package TPPPTX\Type
 */
abstract class ComplexAbstract
{
    use LoggerAwareTrait;

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
    public function getChildren($tagName = '')
    {
        $result = array();

        $tagNames = explode(' ', $tagName);

        foreach ($this->children as &$child) {
            if (!$tagName || in_array($child->tagName, $tagNames)) {
                $result[] =& $child;
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
        return isset($this->getChildren($tagName)[0]) ? $this->getChildren($tagName)[0] : null;
    }


    /**
     * @param ComplexAbstract $child
     */
    public function addChild(ComplexAbstract $child)
    {
        $this->children[$child->tagName . count($this->getChildren($child->tagName))] = $child;
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
                $this->logger->info('Child <' . $childNode->localName . '> in ' . get_called_class() . ' ignored due to no sequence mapping set.');
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
            $child->setLogger($this->logger);
            $child->fromDom($childNode, array_merge($options, array(
                'parent' => &$this,
            )));

            $this->addChild($child);
        }

        return $this;
    }


    /**
     * @param \DOMDocument $dom
     * @param array $options
     * @return \DOMElement
     * @todo rework all overrides to include the common part
     */
    public function toHtmlDom(\DOMDocument $dom, $options = array())
    {
        $container = $dom->createElement(isset($options['tagName']) ? $options['tagName'] : 'div');
        if (isset($options['class'])) {
            $container->setAttribute('class', $options['class']);
        }

        $style = '';
        foreach ($this->getChildren() as $child) {
            if (method_exists($child, 'toCssInline')) {
                $style .= $child->toCssInline();
            }
            if (!isset($options['noChildren']) && $tmp = $child->toHtmlDom($dom)) {
                $container->appendChild($tmp);
            }
        }

        $container->setAttribute('style', $style);

        if (isset($_GET['show_class'])) {
            $container->setAttribute('data-class', get_called_class());
        }

        return $container;
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

        // Loop ancestor children
        foreach ($ancestor->getChildren() as $key => $aChild) {
            // Ancestor or Descendant has many of such children
            if (count($ancestor->getChildren($aChild->tagName)) > 1
                || count($this->getChildren($aChild->tagName)) > 1
            ) {
                throw new \Exception('ComplexAbstract failed to resolve merge of ' . get_called_class() . ' because there are many children of type ' . $aChild->tagName);
            }

            if ($this->child($aChild->tagName)) {
                // Descendant has such child too
                $this->children[$aChild->tagName . '0']->merge($aChild);
            } else {
                // Descendant has no such child yet
                $this->addChild($aChild);
            }
        }
    }
} 