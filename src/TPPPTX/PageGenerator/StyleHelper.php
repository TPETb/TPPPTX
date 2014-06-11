<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/23/14
 * Time: 4:35 PM
 */

namespace TPPPTX\PageGenerator;

use \TPPPTX\Parser as Parser;


/**
 * Class StyleHelper
 * @package TPPPTX\PageGenerator
 */
class StyleHelper
{

    /**
     * @var string
     */
    protected static $unit = 'pt';


    /**
     * @param $styles
     * @param Parser\SlideMaster $master
     * @param string $selectorPrefix
     * @return array
     */
    public static function convertTextStylesSetToCss($styles, Parser\SlideMaster $master, $selectorPrefix = '')
    {
        $resultArray = array();

        foreach ($styles as $lvl => $style) {
            $resultArray[$lvl] = self::textParagraphPropertiesToCss($style, $master);
        }

        $result = '';
        foreach ($resultArray as $lvl => $style) {
            $result .= "\n" . $selectorPrefix . '.lvl-' . $lvl . "{{$style}}";
        }


        return $result;
    }


    public static function textParagraphPropertiesToCss($pPr, Parser\SlideMaster $master)
    {
        $style = array(
            'text-align' => $pPr['algn'] == 'l'
                    ? 'left'
                    : $pPr['algn'] == 'r'
                        ? 'right'
                        : $pPr['algn'] == 'ctr'
                            ? 'center'
                            : $pPr['algn'] == 'dec'
                                ? 'justify'
                                : null,
            'vertical-align' => $pPr['fontAlgn'] == 'auto'
                    ? 'initial'
                    : $pPr['fontAlgn'] == 'base'
                        ? 'baseline'
                        : $pPr['fontAlgn'] == 'ctr'
                            ? 'middle'
                            : $pPr['fontAlgn'] == 'b'
                                ? 'bottom'
                                : $pPr['fontAlgn'] == 't'
                                    ? 'top'
                                    : null,
            'margin-left' => UnitConverter::convertEmu($pPr['marL']) . self::$unit,
            'margin-right' => UnitConverter::convertEmu($pPr['marR']) . self::$unit,
            'margin-top' => $pPr['spcBef']
                    ? (stristr($pPr['spcBef'], '%') > -1
                        ? UnitConverter::convertPercent($pPr['spcBef']) . '%'
                        : UnitConverter::convertEmu($pPr['spcBef']) . self::$unit)
                    : null,
            'margin-bottom' => $pPr['spcAft']
                    ? (stristr($pPr['spcAft'], '%') > -1
                        ? UnitConverter::convertPercent($pPr['spcAft']) . '%'
                        : UnitConverter::convertEmu($pPr['spcAft']) . self::$unit)
                    : null,
            'text-indent' => UnitConverter::convertEmu($pPr['indent']) . self::$unit,
        );

        $style = array_filter($style, function ($value) {
            return $value !== null;
        });

        $result = '';
        foreach ($style as $attribute => $value) {
            $result .= $attribute . ': ' . $value . '; ';
        }

        if ($pPr['defRPr']) {
            $result .= self::textCharacterPropertiesToCss($pPr['defRPr'], $master);
        }

        return $result;
    }


    public static function textCharacterPropertiesToCss($cPr, Parser\SlideMaster $master)
    {
        $style = array(
            'font-size' => $cPr['sz'] ? UnitConverter::convertFontPoints($cPr['sz']) . self::$unit : null,
            'font-weight' => $cPr['b'] ? 'bold' : null,
            'font-style' => $cPr['i'] ? 'italic' : null,
            'text-decoration' => $cPr['u'] ? 'underline' : null,
            'font-family' => $cPr['latin'] ? $cPr['latin']['typeface'] : null,
        );

        if ($style['font-family'] == '+mj-lt') {
            $style['font-family'] = $master->getMajorFont();
        } else if ($style['font-family'] == '+mn-lt') {
            $style['font-family'] = $master->getMinorFont();
        }

        $style = array_filter($style, function ($value) {
            return $value !== null;
        });

        $result = '';
        foreach ($style as $attribute => $value) {
            $result .= $attribute . ': ' . $value . '; ';
        }

        return $result;
    }


    /**
     * @param Parser\Presentation $presentation
     * @return string
     */
    public static function buildSlideDimensionsStyle(Parser\Presentation $presentation)
    {
        return '
        .slide {
            width: ' . UnitConverter::convertEmu($presentation->getSlidesDimensions()['width']) . self::$unit . ';
            height: ' . UnitConverter::convertEmu($presentation->getSlidesDimensions()['height']) . self::$unit . ';
        }';
    }


    /**
     * Builds inline style from form
     * @param $form
     * @return string
     */
    public static function buildFormStyle($form)
    {
        $style = array(
            'width: ' . UnitConverter::convertEmu($form['cx']) . self::$unit,
            'height: ' . UnitConverter::convertEmu($form['cy']) . self::$unit,
            'left: ' . UnitConverter::convertEmu($form['x']) . self::$unit,
            'top: ' . UnitConverter::convertEmu($form['y']) . self::$unit,
            '-ms-transform: rotate(' . UnitConverter::convertDegree($form['rot']) . 'deg)',
            '-webkit-transform: rotate(' . UnitConverter::convertDegree($form['rot']) . 'deg)',
            'transform: rotate(' . UnitConverter::convertDegree($form['rot']) . 'deg)',
        );

        return implode('; ', $style) . ';';
    }
}