<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/22/14
 * Time: 9:16 PM
 */

namespace TPPPTX\Parser;

use \TPPPTX\Parser as Parser;

/**
 * Class XmlFileBasedEntity
 * @package TPPPTX\Parser
 */
abstract class XmlFileBasedEntity
{

    /**
     * @var Parser
     */
    protected $parser;

    /**
     * @var string
     */
    protected $filepath;

    /**
     * @var bool
     */
    protected $parsed = false;

    /**
     * @var \DOMDocument
     */
    protected $dom;

    /**
     * @var \DOMXPath
     */
    protected $xpath;

    /**
     * @var array
     */
    protected $relations;


    /**
     * @param Parser $parser
     * @param string $filepath
     * @todo implement proper lazy loading
     */
    function __construct(Parser $parser, $filepath)
    {
        $this->parser = $parser;

        $this->filepath = $filepath;

        $this->dom = new \DOMDocument();
        $this->dom->loadXML($this->parser->getPptxFileHandler()->read($this->filepath));

        $this->xpath = new \DOMXPath($this->dom);

        $this->relations = $this->parser->parseFileRelations($this->filepath);

        $this->parse();
    }


    public function getUid()
    {
        $uid = str_replace(array('ppt', '.xml'), '', $this->filepath);
        $uid = preg_replace_callback('/\/[a-z]{1}/', function ($match) {
            return strtoupper(str_replace('/', '', $match[0]));
        }, $uid);
        $uid = preg_replace('/[a-z]/', '', $uid);
        $uid = strtolower($uid);

        return $uid;
    }


    /**
     */
    abstract protected function parse();
} 