<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 8/11/14
 * Time: 5:20 PM
 */

namespace TPPPTX\Type;


trait ModifiableColor
{
    protected function applyModifications($color)
    {
        if ($tmp = $this->child('lumMod')) {
            $hsl = $this->rgbToHsl($this->rgbToArray($color));
            $hslBak = $hsl;
            $hsl[2] *= $tmp->val->get() / 1000 / 100;
            $hsl[2] = min(1, max(0, $hsl[2]));

            $colorBak = $color;
            $color = $this->arrayToRgb($this->hslToRgb($hsl));

//            d($colorBak, 'lumMod', $tmp->val->get(), $hslBak, $hsl, $color);
        }

        if ($tmp = $this->child('lumOff')) {
            $hsl = $this->rgbToHsl($this->rgbToArray($color));
            $hslBak = $hsl;
            $hsl[2] += $tmp->val->get() / 1000 / 100;
            $hsl[2] = min(1, max(0, $hsl[2]));

            $colorBak = $color;
            $color = $this->arrayToRgb($this->hslToRgb($hsl));

//            d($colorBak, 'lumOff', $tmp->val->get(), $hslBak, $hsl, $color);
        }

        return $color;
    }


    protected function rgbToArray($rgb)
    {
        if (preg_match('/\#([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})/i', $rgb, $matches)) {
            return array(
                str_pad(hexdec($matches[1]), 2, 0),
                str_pad(hexdec($matches[2]), 2, 0),
                str_pad(hexdec($matches[3]), 2, 0),
            );
        } else if (preg_match('/\#([0-9a-f]{1})([0-9a-f]{1})([0-9a-f]{1})/i', $rgb, $matches)) {
            return array(
                str_pad(hexdec($matches[1]), 2, 0),
                str_pad(hexdec($matches[2]), 2, 0),
                str_pad(hexdec($matches[3]), 2, 0),
            );
        } else {
            throw new \Exception("Wrong RGB color {$rgb} passed");
        }

    }


    protected function arrayToRgb($array)
    {
        return '#' . dechex($array[0]) . dechex($array[1]) . dechex($array[2]);
    }


    protected function rgbToHsl($rgb)
    {
        $r = $rgb[0];
        $g = $rgb[1];
        $b = $rgb[2];

        $oldR = $r;
        $oldG = $g;
        $oldB = $b;

        $r /= 255;
        $g /= 255;
        $b /= 255;

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);

        $h = 0;
        $s = 0;
        $l = ($max + $min) / 2;
        $d = $max - $min;

        if ($d == 0) {
            $h = $s = 0; // achromatic
        } else {
            $s = $d / (1 - abs(2 * $l - 1));

            switch ($max) {
                case $r:
                    $h = 60 * fmod((($g - $b) / $d), 6);
                    if ($b > $g) {
                        $h += 360;
                    }
                    break;

                case $g:
                    $h = 60 * (($b - $r) / $d + 2);
                    break;

                case $b:
                    $h = 60 * (($r - $g) / $d + 4);
                    break;
            }
        }

        return array(round($h, 2), round($s, 2), round($l, 2));
    }


    protected function hslToRgb($hsl)
    {
        $h = $hsl[0];
        $s = $hsl[1];
        $l = $hsl[2];

        $r = 0;
        $g = 0;
        $b = 0;

        $c = (1 - abs(2 * $l - 1)) * $s;
        $x = $c * (1 - abs(fmod(($h / 60), 2) - 1));
        $m = $l - ($c / 2);

        if ($h < 60) {
            $r = $c;
            $g = $x;
            $b = 0;
        } else if ($h < 120) {
            $r = $x;
            $g = $c;
            $b = 0;
        } else if ($h < 180) {
            $r = 0;
            $g = $c;
            $b = $x;
        } else if ($h < 240) {
            $r = 0;
            $g = $x;
            $b = $c;
        } else if ($h < 300) {
            $r = $x;
            $g = 0;
            $b = $c;
        } else {
            $r = $c;
            $g = 0;
            $b = $x;
        }

        $r = ($r + $m) * 255;
        $g = ($g + $m) * 255;
        $b = ($b + $m) * 255;

        return array(floor($r), floor($g), floor($b));
    }
} 