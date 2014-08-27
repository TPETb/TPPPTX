<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 8/27/14
 * Time: 11:37 AM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

class LineJoinRound extends ComplexAbstract
{
    public function toCss()
    {
        return 'round';
    }
} 