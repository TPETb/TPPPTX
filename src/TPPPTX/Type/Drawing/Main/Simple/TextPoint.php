<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/14/14
 * Time: 11:17 AM
 */

namespace TPPPTX\Type\Drawing\Main\Simple;


use TPPPTX\Type\SimpleAbstract;

class TextPoint extends SimpleAbstract
{
    public function toCss()
    {
        return $this->value / 1000 . '%';
    }
} 