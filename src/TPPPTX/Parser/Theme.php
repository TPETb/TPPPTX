<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/22/14
 * Time: 7:11 PM
 */

namespace TPPPTX\Parser;


class Theme extends XmlFileBasedEntity
{

    protected $colorScheme = array();

    protected $fontScheme = array();


    protected function parse()
    {
        // Parse color scheme
        foreach ($this->xpath->query('/a:theme/a:themeElements/a:clrScheme/*') as $colorNode) {
            $this->colorScheme[str_replace('a:', '', $colorNode->nodeName)] = $this->xpath->query('a:sysClr', $colorNode)->item(0)
                ? $this->xpath->query('a:sysClr', $colorNode)->item(0)->getAttribute('lastClr')
                : $this->xpath->query('a:srgbClr', $colorNode)->item(0)->getAttribute('val');
        }

        // Parse font scheme
        $this->fontScheme['major'] = $this->xpath->query('/a:theme/a:themeElements/a:fontScheme/a:majorFont/a:latin')->item(0)->getAttribute('typeface');
        $this->fontScheme['minor'] = $this->xpath->query('/a:theme/a:themeElements/a:fontScheme/a:minorFont/a:latin')->item(0)->getAttribute('typeface');
    }


    /**
     * @param $colorName
     * @return string
     * @todo add support for non-hex colors
     */
    public function getColor($colorName)
    {
        return '#' . $this->colorScheme[$colorName];
    }


    public function getMajorFont()
    {
        return $this->fontScheme['major'];
    }


    public function getMinorFont()
    {
        return $this->fontScheme['minor'];
    }

    /**
     * @return array
     */
    public function getColorScheme()
    {
        return $this->colorScheme;
    }

    /**
     * @return array
     */
    public function getFontScheme()
    {
        return $this->fontScheme;
    }


}