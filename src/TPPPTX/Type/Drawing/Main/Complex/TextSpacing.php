<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/13/14
 * Time: 8:08 PM
 */

namespace TPPPTX\Type\Drawing\Main\Complex;
use TPPPTX\Type\ComplexAbstract;

/**
 * Class TextSpacing
 * <xsd:complexType name="CT_TextSpacing">
 *     <xsd:choice>
 *         <xsd:element name="spcPct" type="CT_TextSpacingPercent"/>
 *         <xsd:element name="spcPts" type="CT_TextSpacingPoint"/>
 *     </xsd:choice>
 * </xsd:complexType>
 * @package TPPPTX\Type\Drawing\Main\Complex
 */
class TextSpacing extends ComplexAbstract
{

    /**
     * @var array
     */
    protected $sequence = array(
        'spcPct' => 'Drawing\\Main\\Complex\\TextSpacingPercent',
        'spcPts' => 'Drawing\\Main\\Complex\\TextSpacingPoint',
    );


    public function toCss()
    {
        if (count($lnSpc = $this->getChildren('spcPct'))) {
            return $lnSpc[0]->val->toCss();
        } else if (count($lnSpc = $this->getChildren('CT_TextSpacingPoint'))) {
            return $lnSpc[0]->val->toCss();
        }
    }
} 