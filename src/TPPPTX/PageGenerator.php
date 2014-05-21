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
    protected $pointPixelRatio = 12700;

    protected $parsedData;
    /**
     * @var FileHandler
     */
    protected $pptxFileHandler;
    
    
    protected $dom;


    function __construct($options)
    {
        $this->setOptions($options);
        
        $this->dom = new \DOMDocument();
    }


    public function setOptions(array $options)
    {
        foreach ($options as $property => $value) {
            if (method_exists($this, 'set' . ucfirst($property))) {
                $this->{'set' . ucfirst($property)}($value);
            }
        }
    }


    public function saveToDisk($file, $data, $output)
    {
        $assetsPath = $output . '_files';

        $file->extract($assetsPath);
//        rename($assetsPath . '/ppt/media', $assetsPath . '/media');
        copy(dirname(__FILE__) . '/../../static/main.js', $assetsPath . '/main.js');
        copy(dirname(__FILE__) . '/../../static/main.css', $assetsPath . '/main.css');

        $this->dom = $this->buildPageDom($data, array_pop(array_slice(explode('/', $assetsPath), -1, 1)));

        file_put_contents($output, $this->dom->saveHtml());


        return true;
    }


    protected function buildPageDom($data, $assetsUrl)
    {
        $html = $this->dom->createElement('html');

        $head = $this->dom->createElement('head');
        $css = $this->dom->createElement('link');
        $css->setAttribute('rel', 'stylesheet');
        $css->setAttribute('type', 'text/css');
        $css->setAttribute('href', $assetsUrl . '/main.css');
        $head->appendChild($css);
        $css = $this->dom->createElement('style');
        $css->nodeValue = '
        .slide {
            width: ' . $data['slide_dimensions']['width'] / $this->pointPixelRatio . 'px;
            height: ' . $data['slide_dimensions']['height'] / $this->pointPixelRatio . 'px;
        }';
        $head->appendChild($css);
        $js = $this->dom->createElement('script');
        $js->setAttribute('type', 'text/javascript');
        $js->setAttribute('src', $assetsUrl . '/main.js');
        $head->appendChild($js);
        $html->appendChild($head);


        $body = $this->dom->createElement('body');
        foreach ($data['slides'] as $slideData) {
            $slide = $this->dom->createElement('div');
            $slide->setAttribute('class', 'slide');

            $this->appendSlideContent($slide, $slideData, $assetsUrl);
            if ($slideData['layout']) {
                $this->appendSlideContent($slide, $data['slide_layouts'][$slideData['layout']], $assetsUrl);
            }

            $body->appendChild($slide);
        }


        $html->appendChild($body);
        $this->dom->appendChild($html);

        return $this->dom;
    }


    protected function appendSlideContent (&$slide, $slideContent, $assetsUrl)
    {
        foreach ($slideContent['shapes'] as $shapeData) {
            $shape = $this->dom->createElement('div');
            $shape->setAttribute('class', 'shape ' . isset($shapeData['type']) ? : '');
            if (isset($shapeData['form'])) {
                $shape->setAttribute('style', '
                        width: ' . $shapeData['form']['width'] / $this->pointPixelRatio . 'px;
                        height: ' . $shapeData['form']['height'] / $this->pointPixelRatio . 'px;
                        left: ' . $shapeData['form']['left'] / $this->pointPixelRatio . 'px;
                        top: ' . $shapeData['form']['top'] / $this->pointPixelRatio . 'px;
                    ');
            }

            foreach ($shapeData['text'] as $paragraph) {
                $p = $this->dom->createElement('p');
                foreach ($paragraph as $textPiece) {
                    $span = $this->dom->createElement('span');
                    $span->nodeValue = htmlentities($textPiece['value']);
                    $p->appendChild($span);
                }
                $shape->appendChild($p);
            }

            $slide->appendChild($shape);
        }

        foreach ($slideContent['pictures'] as $pictureData) {
            $img = $this->dom->createElement('img');
            $img->setAttribute('class', 'pic');
            $img->setAttribute('style', '
                    width: ' . $pictureData['form']['width'] / $this->pointPixelRatio . 'px;
                    height: ' . $pictureData['form']['height'] / $this->pointPixelRatio . 'px;
                    left: ' . $pictureData['form']['left'] / $this->pointPixelRatio . 'px;
                    top: ' . $pictureData['form']['top'] / $this->pointPixelRatio . 'px;
                ');
            $img->setAttribute('src', $assetsUrl . str_replace('..', '/ppt', $pictureData['image']['src']));

            $slide->appendChild($img);
        }
    }


    protected function buildSlideSubContainerDom($data)
    {

    }

} 