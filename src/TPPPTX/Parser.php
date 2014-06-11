<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/14/14
 * Time: 21:57
 */

namespace TPPPTX;


/**
 * Class Parser
 * Extracts all available data from .pptx file
 * Result is an assoc array
 * @package TPPPTX
 * @todo add default values instead of omitted in text styles
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
     * @var bool
     */
    protected $parsed = false;


    /**
     * @param $pptxFileHandler
     * @todo implement real lazy loading - move $this->parse() to some getter
     */
    function __construct($pptxFileHandler)
    {
        $this->pptxFileHandler = $pptxFileHandler;
        $this->registry = new Parser\Registry();

        $this->parse();
    }


    /**
     * Generally this is useless method in fact it only just executes full scan of .pptx instead of waiting for lazy load
     * Never the less this method is awesome for debug purposes =)
     * @todo obsolete and remove it
     */
    protected function parse()
    {
        // Parse Handout Master


        // Parse Slides
        foreach ($this->getSlides() as $slide) {
//            d($slide);
//            d($slide->getUid());
        }


        // Parse Slide Layouts
        foreach ($this->getSlides() as $slide) {
            $slideLayout = $slide->getLayout();
//            d($slideLayout);
//            d($slideLayout->getUid());
        }


        // Parse Slide Masters
        foreach ($this->getSlides() as $slide) {
            $slideMaster = $slide->getLayout()->getMaster();
//            d($slideMaster);
//            d($slideMaster->getUid());
        }


        // Parse slide dimensions


        // Parse Notes Master


        // Parse Notes Slides


        $this->parsed = true;
    }


    /**
     * Returns instance of Presentation. Creates one if doesn't exist. Adds to Registry
     * @return Parser\Presentation
     * @throws \Exception
     */
    public function getPresentation()
    {
        if (isset($this->registry['ppt/presentation.xml']))
            return $this->registry['ppt/presentation.xml'];

        if (!$this->pptxFileHandler->read('ppt/presentation.xml')) {
            throw new \Exception('Non-existing slide requested');
        }

        return $this->registry['ppt/presentation.xml'] = new Parser\Presentation($this);
    }


    /**
     * Returns array of Slide instances
     * @return Parser\Slide[]
     */
    public function getSlides()
    {
        $slides = array();
        foreach ($this->getPresentation()->getSlidesFilepaths() as $filepath) {
            $slides[] = $this->getSlide($filepath);
        }

        return $slides;
    }


    /**
     * @param $filepath
     * @return Parser\Slide
     * @throws \Exception
     */
    public function getSlide($filepath)
    {
        if (isset($this->registry[$filepath])) 
            return $this->registry[$filepath];
        
        if (!$this->pptxFileHandler->read($filepath)) {
            throw new \Exception('Non-existing slide requested');
        }

        return $this->registry[$filepath] = new Parser\Slide($this, $filepath);
    }


    /**
     * @param $filepath
     * @return Parser\SlideLayout
     * @throws \Exception
     */
    public function getSlideLayout($filepath)
    {
        if (isset($this->registry[$filepath]))
            return $this->registry[$filepath];

        if (!$this->pptxFileHandler->read($filepath)) {
            throw new \Exception('Non-existing slide layout requested');
        }

        return $this->registry[$filepath] = new Parser\SlideLayout($this, $filepath);
    }


    /**
     * @param $filepath
     * @return Parser\SlideMaster
     * @throws \Exception
     */
    public function getSlideMaster($filepath)
    {
        if (isset($this->registry[$filepath]))
            return $this->registry[$filepath];

        if (!$this->pptxFileHandler->read($filepath)) {
            throw new \Exception('Non-existing slide master requested');
        }

        return $this->registry[$filepath] = new Parser\SlideMaster($this, $filepath);
    }


    /**
     * @param $filepath
     * @return Parser\Theme
     * @throws \Exception
     */
    public function getTheme($filepath)
    {
        if (isset($this->registry[$filepath]))
            return $this->registry[$filepath];

        if (!$this->pptxFileHandler->read($filepath)) {
            throw new \Exception('Non-existing slide master requested');
        }

        return $this->registry[$filepath] = new Parser\Theme($this, $filepath);
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
        $relsPath = $fileNamePrefix."/_rels/".$fileNameSuffix.".rels";

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
     * Returns all media used in presentation
     * @return array
     */
    public function getMedia()
    {
        $media = array();
        foreach ($this->getSlides() as $slide) {
            $media = array_merge($media, $slide->getMedia());
            $media = array_merge($media, $slide->getLayout()->getMedia());
            $media = array_merge($media, $slide->getMaster()->getMedia());
        }

        return $media;
    }
}