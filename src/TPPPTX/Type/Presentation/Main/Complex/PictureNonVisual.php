<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/17/14
 * Time: 6:36 AM
 */

namespace TPPPTX\Type\Presentation\Main\Complex;


use TPPPTX\Type\ComplexAbstract;

/**
 * Class PictureNonVisual
 * <xsd:complexType name="CT_PictureNonVisual">
 *     <xsd:sequence>
 *         <xsd:element name="cNvPr" type="a:CT_NonVisualDrawingProps" minOccurs="1" maxOccurs="1"/>
 *         <xsd:element name="cNvPicPr" type="a:CT_NonVisualPictureProperties" minOccurs="1" maxOccurs = "1" />
 *         <xsd:element name="nvPr" type="CT_ApplicationNonVisualDrawingProps" minOccurs="1" maxOccurs = "1" />
 *     </xsd:sequence>
 * </xsd:complexType>
 * @package TPPPTX\Type\Presentation\Main\Complex
 */
class PictureNonVisual extends ComplexAbstract
{
    protected $sequence = array(
//        'cNvPr' => 'Drawing\\Main\\Complex\\NonVisualDrawingProps',
//        'cNvSpPr' => 'Drawing\\Main\\Complex\\NonVisualDrawingShapeProps',
        'nvPr' => 'Presentation\\Main\\Complex\\ApplicationNonVisualDrawingProps',
    );


    public function toHtmlDom(\DOMDocument $dom, $options = array())
    {
        // Video
        if ($tmp = $this->child('nvPr')) {
            if ($tmp = $tmp->child('videoFile')) {
                $container = parent::toHtmlDom($dom, array(
                    'tagName' => 'video',
                    'noChildren' => true,
                ));

                $container->setAttribute('src', $tmp->getFilepath());
                $container->setAttribute('controls', 'true');
                $container->setAttribute('poster', $this->child('blipFill')->child('blip')->getFilepath());

                return $container;
            }
        }

        // Audio
        if ($tmp = $this->child('nvPr')) {
            if ($tmp = $tmp->child('audioFile')) {
                $container = parent::toHtmlDom($dom, array(
                    'tagName' => 'div',
                    'noChildren' => true,
                ));

                $audio = parent::toHtmlDom($dom, array(
                    'tagName' => 'audio',
                    'noChildren' => true,
                ));

                $audio->setAttribute('src', $tmp->getFilepath());
                $audio->setAttribute('id', $id = 'audio_' . substr(md5(uniqid()), 0, 6));

                $container->appendChild($audio);

                $img = $dom->createElement('img');

                $img->setAttribute('src', $this->child('blipFill')->child('blip')->getFilepath());
                $img->setAttribute('onclick', "$('#{$id}')[0].play();");

                $container->appendChild($img);

                return $container;
            }
        }

        return null;
    }
}
