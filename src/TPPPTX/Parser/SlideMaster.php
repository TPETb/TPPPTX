<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/14/14
 * Time: 22:00
 */

namespace TPPPTX\Parser;

use \TPPPTX\Parser as Parser;

/**
 * Class SlideMaster
 * @package TPPPTX\Parser
 * @todo add Background retrieval
 */
class SlideMaster extends SlideAbstract
{

    /**
     * @var array
     */
    protected $textStyles = array();


    protected $colorMap = array();


    /**
     * Returns actual shapes, not placeholders
     * @return array
     */
    public function getShapes()
    {
        $shapes = array();
        foreach ($this->shapes as $shape) {
            if (!$shape['placeholder']) {
                $shapes[] = $shape;
            }
        }

        return $shapes;
    }


    /**
     *
     */
    protected function parse()
    {
        parent::parse();

        // Retrieve text styles
        /*
        $this->textStyles['title'] = StyleHelper::mergeTextStyles(
            $this->parser->getPresentation()->getDefaultTextStyles(),
            StyleHelper::parseTextParagraphPropertiesSet($this->xpath, $this->xpath->query('p:txStyles/p:titleStyle')->item(0))
        );
        $this->textStyles['body'] = StyleHelper::mergeTextStyles(
            $this->parser->getPresentation()->getDefaultTextStyles(),
            StyleHelper::parseTextParagraphPropertiesSet($this->xpath, $this->xpath->query('p:txStyles/p:bodyStyle')->item(0))
        );
        $this->textStyles['other'] = StyleHelper::mergeTextStyles(
            $this->parser->getPresentation()->getDefaultTextStyles(),
            StyleHelper::parseTextParagraphPropertiesSet($this->xpath, $this->xpath->query('p:txStyles/p:otherStyle')->item(0))
        );
        */
        $this->textStyles['title'] = StyleHelper::parseTextParagraphPropertiesSet($this->xpath, $this->xpath->query('p:txStyles/p:titleStyle')->item(0));
        $this->textStyles['body'] = StyleHelper::parseTextParagraphPropertiesSet($this->xpath, $this->xpath->query('p:txStyles/p:bodyStyle')->item(0));
        $this->textStyles['other'] = StyleHelper::parseTextParagraphPropertiesSet($this->xpath, $this->xpath->query('p:txStyles/p:otherStyle')->item(0));

        // Color mapping
        foreach ($this->xpath->query('p:clrMap')->item(0)->attributes as $attribute) {
            $this->colorMap[$attribute->name] = $attribute->value;
        }

        $this->getTheme();

        // Parsing completed
        $this->parsed = true;
    }


    public function getTheme()
    {
        return $this->parser->getTheme($this->getThemePath());
    }


    public function getThemePath()
    {
        foreach ($this->relations as $rel) {
            if ($rel['type'] == 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/theme') {
                return $rel['target'];
            }
        }

        return null;
    }

    /**
     * @return array
     */
    public function getTextStyles()
    {
        return $this->textStyles;
    }


    /**
     * Retrieves the color value via own mapping and theme schema
     * @param $colorName
     * @return string
     */
    public function getColor($colorName)
    {
        return $this->getTheme()->getColor($this->colorMap[$colorName]);
    }


    /**
     * Proxies to theme
     * @return mixed
     */
    public function getMajorFont()
    {
        return $this->getTheme()->getMajorFont();
    }


    /**
     * Proxies to theme
     * @return mixed
     */
    public function getMinorFont()
    {
        return $this->getTheme()->getMinorFont();
    }

}