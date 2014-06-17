<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/17/14
 * Time: 6:00 AM
 */

namespace TPPPTX\Type\Drawing\Main\Simple;


use TPPPTX\Type\SimpleAbstract;

class LineWidth extends SimpleAbstract
{
    public function toCss() {
        return $this->value / 12700 . 'pt';
    }
} 