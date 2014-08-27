<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/14/14
 * Time: 11:35 AM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class NoFillProperties
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class NoFillProperties extends ComplexAbstract {

    public function toCss() {
        return 'transparent';
    }
} 