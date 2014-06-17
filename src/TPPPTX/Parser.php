<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/14/14
 * Time: 21:57
 */

namespace TPPPTX;

use TPPPTX\Type\Presentation\Main\Complex\Presentation;


/**
 * Class Parser
 * Extracts all available data from .pptx file
 * Result is an assoc array
 * @package TPPPTX
 * @todo add default values instead of omitted in text styles
 * @todo implement XSD based type detection
 */
class Parser
{

    /**
     * @var FileHandler
     */
    protected $pptxFileHandler;


    /**
     * @var Parser\Registry
     */
    protected $registry;


    /**
     * @param $pptxFileHandler
     * @todo implement real lazy loading - move $this->parse() to some getter
     */
    function __construct($pptxFileHandler)
    {
        $this->pptxFileHandler = $pptxFileHandler;
        $this->registry = new Parser\Registry();
    }


    /**
     * @return \TPPPTX\FileHandler
     */
    public function getPptxFileHandler()
    {
        return $this->pptxFileHandler;
    }


    /**
     * Returns relations of given file as an array
     *
     * @param string $filepath Name of the original file.
     * @return array Relations file content
     */
    public function parseFileRelations($filepath)
    {
        $fileNamePrefix = dirname($filepath);
        $fileNameSuffix = basename($filepath);
        $relsPath = $fileNamePrefix . "/_rels/" . $fileNameSuffix . ".rels";

        if (isset($this->registry[$relsPath])) {
            return $this->registry[$relsPath];
        }

        if (!$this->pptxFileHandler->read($relsPath)) {
            return null;
        }

        $rels = new \DOMDocument();
        $rels->loadXML($this->pptxFileHandler->read($relsPath));
        $xpath = new \DOMXPath($rels);
        $xpath->registerNamespace('r', 'http://schemas.openxmlformats.org/package/2006/relationships'); // OFC there is no "r" namespace in file, but DOMXpath need an NS direly

        $result = array();
        foreach ($xpath->query('/r:Relationships/r:Relationship') as $relNode) {
            $relationPath = explode('/', $filepath);
            array_pop($relationPath);
            foreach (explode('/', $relNode->getAttribute('Target')) as $relPathBit) {
                if ($relPathBit == '..') {
                    array_pop($relationPath);
                } else {
                    array_push($relationPath, $relPathBit);
                }
            }
            $relationPath = implode('/', $relationPath);
            $result[$relNode->getAttribute('Id')] = array(
                'type' => $relNode->getAttribute('Type'),
                'target' => $relationPath,
            );
        }

        $this->registry[$relsPath] = $result;

        return $result;
    }


    /**
     * @return \TPPPTX\Parser\Registry
     */
    public function getRegistry()
    {
        return $this->registry;
    }


    /**
     * @return Type\ComplexAbstract
     */
    public function unmarshal()
    {
        $presentation = new Presentation('presentation');
        $presentation->load($this);

        $dom = new \DOMDocument();
        $dom->formatOutput = true;
        $html = $dom->createElement('html');

        $head = $dom->createElement('head');

        // Reset css
        $css = $dom->createElement('style');
        $css->nodeValue = '/* Eric Meyer\'s Reset CSS v2.0 - http://cssreset.com */html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{border:0;font-size:100%;font:inherit;vertical-align:baseline;margin:0;padding:0}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block}body{line-height:1}ol,ul{list-style:none}blockquote,q{quotes:none}blockquote:before,blockquote:after,q:before,q:after{content:none}table{border-collapse:collapse;border-spacing:0}';
        $head->appendChild($css);

        // Let's add some debug
        $css = $dom->createElement('style');
        $css->nodeValue = '.slide {border: 1px solid red;} .slide {margin: 20px; overflow: hidden;}';
        $head->appendChild($css);

//        $css = $dom->createElement('link');
//        $css->setAttribute('rel', 'stylesheet');
//        $css->setAttribute('type', 'text/css');
//        $css->setAttribute('href', $assetsUrl . '/main.css');
//        $head->appendChild($css);
//        $css = $dom->createElement('style');
//        $css->nodeValue = StyleHelper::buildSlideDimensionsStyle($this->parser->getPresentation());
//        $head->appendChild($css);
//        $js = $dom->createElement('script');
//        $js->setAttribute('type', 'text/javascript');
//        $js->setAttribute('src', $assetsUrl . '/main.js');
//        $head->appendChild($js);
        $html->appendChild($head);

        $body = $dom->createElement('body');
        $body->appendChild($presentation->toHtmlDom($dom));

        $html->appendChild($body);
        $dom->appendChild($html);

        // Store file
        echo $dom->saveHTML();

        return;
    }


    public function getByFilepath($filepath)
    {
        if (!$this->pptxFileHandler->read($filepath)) {
            throw new \Exception('Non-existing file requested');
        }

        return array(
            'content' => $this->pptxFileHandler->read($filepath),
            'relations' => $this->parseFileRelations($filepath),
        );
    }
}