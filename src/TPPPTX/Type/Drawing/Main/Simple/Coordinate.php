<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/15/14
 * Time: 3:17 PM
 */

namespace TPPPTX\Type\Drawing\Main\Simple;


use TPPPTX\Type\SimpleAbstract;

class Coordinate extends SimpleAbstract
{
    public function toCss()
    {
        return round($this->value / 12700) . 'pt';
    }
} 