<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/14/14
 * Time: 22:00
 */

namespace TPPPTX\Parser;


class SlideLayout extends Slide
{

    public function getMasterPath()
    {
        $relations = $this->parser->parseFileRelations($this->filepath);

        foreach ($relations as $rel) {
            if ($rel['type'] == 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/slideMaster') {
                return $rel['target'];
            }
        }

        return null;
    }

}