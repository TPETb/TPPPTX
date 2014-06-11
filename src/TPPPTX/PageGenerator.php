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
use TPPPTX\PageGenerator\StyleHelper;
use TPPPTX\PageGenerator\UnitConverter;

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
     * @var \DOMDocument
     */
    protected $dom;


    /**
     * @var $this ->unitConverter
     */
    protected $unitConverter;


    /**
     * @param Parser $parser
     * @param array $options
     */
    function __construct(Parser $parser, array $options = array())
    {
        $this->parser = $parser;
        $this->dom = new \DOMDocument();

        $this->unitConverter = new UnitConverter();

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
        $assetsPath = $output . '_files';
        $assetsUrl = array_pop(array_slice(explode('/', $assetsPath), -1, 1));

        $html = $this->dom->createElement('html');

        $head = $this->dom->createElement('head');
        $css = $this->dom->createElement('link');
        $css->setAttribute('rel', 'stylesheet');
        $css->setAttribute('type', 'text/css');
        $css->setAttribute('href', $assetsUrl . '/main.css');
        $head->appendChild($css);
        $css = $this->dom->createElement('style');
        $css->nodeValue = StyleHelper::buildSlideDimensionsStyle($this->parser->getPresentation());
        $head->appendChild($css);
        $js = $this->dom->createElement('script');
        $js->setAttribute('type', 'text/javascript');
        $js->setAttribute('src', $assetsUrl . '/main.js');
        $head->appendChild($js);
        $html->appendChild($head);


        $body = $this->dom->createElement('body');
        foreach ($this->parser->getSlides() as $i => $slide) {
            // Prepare slide container
            $slideDiv = $this->dom->createElement('div');
            $slideClasses = array('slide', 'slide-' . $i);
            if ($slide->getLayout()) {
                $slideClasses[] = 'slide-layout-' . $slide->getLayout()->getUid();
            }
            if ($slide->getLayout()->getMaster()) {
                $slideClasses[] = 'slide-master-' . $slide->getLayout()->getMaster()->getUid();
            }
            $slideDiv->setAttribute('class', implode(' ', $slideClasses));

            // Generate slide-wide styles
            //      Presentation
            $css = $this->dom->createElement('style');
            $css->nodeValue .= StyleHelper::convertTextStylesSetToCss(
                $this->parser->getPresentation()->getDefaultTextStyles(),
                $slide->getMaster(),
                ".slide-{$i} ");
            //      Master
            //          Title
            $css->nodeValue .= StyleHelper::convertTextStylesSetToCss(
                $slide->getMaster()->getTextStyles()['title'],
                $slide->getMaster(),
                ".slide-{$i}" . '.slide-master-' . $slide->getLayout()->getMaster()->getUid() . ' .title ');
            //          Body
            $css->nodeValue .= StyleHelper::convertTextStylesSetToCss(
                $slide->getMaster()->getTextStyles()['body'],
                $slide->getMaster(),
                ".slide-{$i}" . '.slide-master-' . $slide->getLayout()->getMaster()->getUid() . ' .body ');
            //          Other
            $css->nodeValue .= StyleHelper::convertTextStylesSetToCss(
                $slide->getMaster()->getTextStyles()['other'],
                $slide->getMaster(),
                ".slide-{$i}" . '.slide-master-' . $slide->getLayout()->getMaster()->getUid() . ' .other ');

            $slideDiv->appendChild($css);


            // Slide shapes
            foreach (array_merge($slide->getMaster()->getShapes(), $slide->getLayout()->getShapes(), $slide->getShapes()) as $shape) {
                // Remember that getShapes() method of Layout and Master will not return placeholders so don't worry they are all in same list
                if ($shape['placeholder']) {
                    // This shape is produced by placeholder and therefore its properties should be taken from it
                    $placeholder = $slide->getLayout()->getPlaceholder($shape['placeholder']);
                    $shape['form'] = $shape['form'] ? : $placeholder['form'];
                    $shape['txBody']['styles'] = $shape['txBody']['styles'] ? : $placeholder['txBody']['styles'];
                }

                $shapeDiv = $this->dom->createElement('div');
                $shapeId = 'Shape_' . substr(md5(uniqid()), 0, 6);
                $shapeDiv->setAttribute('id', $shapeId);

                if (isset($shape['form'])) {
                    $shapeDiv->setAttribute('style', StyleHelper::buildFormStyle($shape['form']));
                } else {
//            return null;
                }

                $shapeDivClasses = array('shape');
                if ($shape['placeholder']) {
                    switch ($shape['placeholder']['type']) {
                        case 'ctrTitle':
                        case 'title':
                            $shapeDivClasses[] = 'title';
                            break;
                        case 'body':
                        case null:
                        default:
                            $shapeDivClasses[] = 'body';
                            break;
                    }
                } else {
                    $shapeDivClasses[] = 'body';
                }
                $shapeDiv->setAttribute('class', implode(' ', $shapeDivClasses));

                // Go for shape styles!
                if ($shape['txBody']['styles']) {
                    $css = $this->dom->createElement('style');
                    $css->nodeValue .= StyleHelper::convertTextStylesSetToCss(
                        $shape['txBody']['styles'],
                        $slide->getMaster(),
                        "#{$shapeId} ");

                    $shapeDiv->appendChild($css);
                }

                // Add the text content
                foreach ($shape['txBody']['content'] as $paragraph) {
                    $p = $this->dom->createElement('p');
                    $p->setAttribute('class', 'lvl-' . $paragraph['lvl']);
                    if ($paragraph['pPr']['buChar']) {
                        $bullet = $this->dom->createElement('span');
                        $bullet->setAttribute('class', 'bullet');
                        $bullet->nodeValue = htmlentities($paragraph['pPr']['buChar']) . '&nbsp;&nbsp;';
                        $p->appendChild($bullet);
                    }
                    foreach ($paragraph['r'] as $textPiece) {
                        if ($textPiece['t'] == 'br') {
                            $p->appendChild($this->dom->createElement('br'));
                        } else {
                            $span = $this->dom->createElement('span');
                            $span->nodeValue = htmlentities($textPiece['t']);
                            if ($textPiece['rPr']) {
                                $span->setAttribute('style', StyleHelper::textCharacterPropertiesToCss($textPiece['rPr'], $slide->getMaster()));
                            }
                            $p->appendChild($span);
                        }
                    }
                    $shapeDiv->appendChild($p);
                }

                $slideDiv->appendChild($shapeDiv);
            }

            // Layout and master slides


            // Add pictures
            foreach (array_merge($slide->getPictures(), $slide->getLayout()->getPictures(), $slide->getMaster()->getPictures()) as $picture) {
                $img = $this->dom->createElement('img');
                $img->setAttribute('class', 'pic');

                if (isset($picture['form'])) {
                    $img->setAttribute('style', StyleHelper::buildFormStyle($picture['form']));
                } else {
                    continue;
                }

                $img->setAttribute('src', str_replace('ppt/media', $assetsUrl, $picture['image']['src']));

                $slideDiv->appendChild($img);
            }

            $body->appendChild($slideDiv);
        }


        $html->appendChild($body);
        $this->dom->appendChild($html);

        // Store file
        $this->dom->saveHTMLFile($output);

//        return;

        // Store assets
        mkdir($assetsPath);
        copy(dirname(__FILE__) . '/../../static/main.js', $assetsPath . '/main.js');
        copy(dirname(__FILE__) . '/../../static/main.css', $assetsPath . '/main.css');

        // Extract media
        foreach ($this->parser->getMedia() as $filepath) {
            file_put_contents($assetsPath . '/' . array_pop(array_slice(explode('/', $filepath), -1, 1)), $this->parser->getPptxFileHandler()->read($filepath));
        }
    }
} 