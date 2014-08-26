<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/14/14
 * Time: 22:28
 */

namespace TPPPTX;


/**
 * Class PageGenerator
 * @package TPPPTX
 */
class PageGenerator
{

    /**
     * @var Parser
     */
    protected $parser;


    /**
     * @param Parser $parser
     * @param array $options
     */
    function __construct(Parser $parser, array $options = array())
    {
        $this->parser = $parser;

        $this->setOptions($options);
    }


    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        foreach ($options as $property => $value) {
            if (method_exists($this, 'set' . ucfirst($property))) {
                $this->{'set' . ucfirst($property)}($value);
            }
        }
    }


    /**
     * @param $output
     */
    public function saveAs($output)
    {
        $presentation = $this->parser->getPresentation();

        $dom = new \DOMDocument();
        $dom->formatOutput = true;
        $html = $dom->createElement('html');

        $head = $dom->createElement('head');

        // Swiper styles
        $css = $dom->createElement('link');
        $css->setAttribute('rel', 'stylesheet');
        $css->setAttribute('type', 'text/css');
        $css->setAttribute('href', '#base_path#/idangerous.swiper.css');
        $head->appendChild($css);
        // Global styles
        $css = $dom->createElement('link');
        $css->setAttribute('rel', 'stylesheet');
        $css->setAttribute('type', 'text/css');
        $css->setAttribute('href', '#base_path#/main.css');
        $head->appendChild($css);
        // jQuery
        $js = $dom->createElement('script');
        $js->setAttribute('type', 'text/javascript');
        $js->setAttribute('src', '#base_path#/jquery-1.10.1.min.js');
        $head->appendChild($js);
        // Swiper
        $js = $dom->createElement('script');
        $js->setAttribute('type', 'text/javascript');
        $js->setAttribute('src', '#base_path#/idangerous.swiper.min.js');
        $head->appendChild($js);
        // Main js
        $js = $dom->createElement('script');
        $js->setAttribute('type', 'text/javascript');
        $js->setAttribute('src', '#base_path#/main.js');
        $head->appendChild($js);

        $html->appendChild($head);

        $body = $dom->createElement('body');
        $body->appendChild($presentation->toHtmlDom($dom));

        $html->appendChild($body);
        $dom->appendChild($html);

        // Store file
        $assetsPath = $output . '_files';
        $tmp = array_slice(explode('/', $assetsPath), -1, 1);
        $assetsUrl = array_pop($tmp);
        mkdir($assetsPath);
        copy(dirname(__FILE__) . '/../../static/main.js', $assetsPath . '/main.js');
        copy(dirname(__FILE__) . '/../../static/main.css', $assetsPath . '/main.css');
        copy(dirname(__FILE__) . '/../../static/idangerous.swiper.css', $assetsPath . '/idangerous.swiper.css');
        copy(dirname(__FILE__) . '/../../static/jquery-1.10.1.min.js', $assetsPath . '/jquery-1.10.1.min.js');
        copy(dirname(__FILE__) . '/../../static/idangerous.swiper.min.js', $assetsPath . '/idangerous.swiper.min.js');
        mkdir($assetsPath . '/ppt');
        mkdir($assetsPath . '/ppt/media');
        $this->parser->getPptxFileHandler()->extractFolder($assetsPath . '/ppt/media', 'ppt/media');

        $html = $dom->saveHTML();
        $html = str_replace('#base_path#', $assetsUrl, $html);

        file_put_contents($output, $html);

        // Debug?
        if (isset($_GET['debug'])) {
            $html = $dom->saveHTML();
            $html = str_replace('#base_path#', '/output/' . $assetsUrl, $html);

            echo $html;
        }
    }
} 